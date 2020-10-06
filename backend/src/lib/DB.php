<?php

namespace skoolBiep;

class DB extends \SQLite3
{
    protected $client;
    public function __construct()
    {
        parent::__construct('../db/db.sqlite');
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getBookMeta($limitNumber, $offsetNumber, $category, $author, $title)
    {
        $sql = "
        select bookMeta.id, isbnCode, title, publishDate, rating, totalPages, language, sticker, readingLevel,
		authors.name as authors, publishers.name as publishers,  group_concat(categories.name, ', ') as categories from bookMeta
		join authors on authors.id = bookMeta.authorsId
		join publishers on publishers.id = bookMeta.publishersId
        join categoriesInBooks on bookMeta.id  = categoriesInBooks.bookMetaId
        join categories on categories.id = categoriesInBooks.categoriesId
        where categories.name like '$category' and authors.name like '$author' and title like '$title'
        GROUP by bookMeta.id
        order by bookMeta.id";

        $sql .= " limit '$limitNumber'";
        $sql .= " offset '$offsetNumber' * '$limitNumber'";

        $res = $this->query($sql);

        $data = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }
    
    public function getBooks()
    {
        $sql = "select group_concat(id, ';') as id, group_concat(status, ';') as status, bookMetaId, count(bookMetaId) as count from books
        group by bookMetaId";

        $res = $this->query($sql);

        $data = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function saveBook($title, $isbn, $rating, $totalPages, $sticker, $language, $readingLevel, $authors, $publishers, $categories, $id = -1)
    {
        if ($id != -1) {
            //update

            $sql = $this->prepare(
                "UPDATE bookMeta
                SET isbnCode = :isbn, title = :title, rating = :rating, totalPages = :totalPages, language = :language,
                sticker = :sticker, readingLevel = :readingLevel, publishersId = :publishersId, authorsId = :authorsIds
                WHERE id = :id");

            $sql->bindValue(':isbn', $isbn);
            $sql->bindValue(':title', $title);
            $sql->bindValue(':rating', $rating);
            $sql->bindValue(':totalPages', $totalPages);
            $sql->bindValue(':language', $language);
            $sql->bindValue(':sticker', $sticker);
            $sql->bindValue(':readingLevel', $readingLevel);
            $sql->bindValue(':id', $id);
            $publisherId = $this->getPublisherId($publishers);
            $sql->bindValue(':publishersId', $publisherId);
            $authorsIds = $this->getAuthorsIds($authors);
            $sql->bindValue(':authorsIds', $authorsIds);

            $status = $sql->execute();
            $categoriesArr = explode(',', $categories);

            $res = $status ? "Success" : "Failed";
            $this->setCategories($id, $categories);
            return $res;
        } else {

            $sql = $this->prepare('insert into bookMeta (isbnCode, title, rating, totalPages, language, sticker, readingLevel, authorsId, publishersId)
            values (:isbn, :title, :rating, :totalPages, :language, :sticker, :readingLevel, :authorsIds, :publishersId)');

            $sql->bindValue(':isbn', $isbn);
            $sql->bindValue(':title', $title);
            $sql->bindValue(':rating', $rating);
            $sql->bindValue(':totalPages', $totalPages);
            $sql->bindValue(':language', $language);
            $sql->bindValue(':sticker', $sticker);
            $sql->bindValue(':readingLevel', $readingLevel);
            $publisherId = $this->getPublisherId($publishers);
            $sql->bindValue(':publishersId', $publisherId);
            $authorsIds = $this->getAuthorsIds($authors);
            $sql->bindValue(':authorsIds', $authorsIds);

            $status = $sql->execute();
            $res = $status ? "Success" : "Failed";
            //todo get the newly created id here
            $this->setCategories($this->lastInsertRowID(), $categories);
            return $res;

        }

    }

    public function editBook()
    {
        $sql = "UPDATE group_concat(id, ';') as id, group_concat(status, ';') as status, bookMetaId, count(bookMetaId) as count from books
        group by bookMetaId";
        $res = $this->query($sql);

        $data = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function getUserByEmail($formEmail)
    {
        $sql = $this->prepare('SELECT users.id, users.surname ,users.password, roles.id as role from users
                                join userRoles on userRoles.usersId = users.id
                                join roles on roles.id = userRoles.rolesId
                                where users.email = :email;');




        $sql->bindValue(':email', $formEmail);
        $res = $sql->execute();
        $data = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }

        return $data[0];
    }

    private function getPublisherId(String $publisherName): String
    {
        $sql = $this->prepare("select id from publishers WHERE name = :name");
        $sql->bindValue(':name', $publisherName);
        $res = $sql->execute();

        $data = $res->fetchArray(SQLITE3_ASSOC);
        if ($data) {
            return $data['id'];
        } else {
            //create new publisher and return the new id
            $sql = $this->prepare(
                "INSERT into publishers(name)
                values (:name)");
            $sql->bindValue(':name', $publisherName);
            $res = $sql->execute();
            var_dump($this->lastInsertRowID());
            return $this->lastInsertRowID();
        }
    }

    private function getAuthorsIds(String $authors): String
    {
        $sql = $this->prepare("select id from authors WHERE name = :name");
        $sql->bindValue(':name', $authors);
        $res = $sql->execute();

        $data = $res->fetchArray(SQLITE3_ASSOC);

        if ($data) {
            return $data['id'];
        } else {
            //create new author and push the new id
            $sql = $this->prepare(
                "INSERT into authors(name)
                values (:name)");
            $sql->bindValue(':name', $authors);
            $res = $sql->execute();
            return $this->lastInsertRowID();
        }
    }

    private function setCategories($bookMetaId, $categories)
    {
        $sql = $this->prepare("SELECT id from categories WHERE name = :name");
        $sql->bindValue(':name', $categories);
        $res = $sql->execute();
        $data = $res->fetchArray(SQLITE3_ASSOC);
        $categoryId = null;

        if ($data) {
            $categoryId = $data['id'];
        } else {
            //create new category
            $sql = $this->prepare("INSERT into categories(name)
            values (:name)");
            $sql->bindValue(':name', $categories);
            $res = $sql->execute();
            $categoryId = $this->lastInsertRowID();
        }

        $sql = $this->prepare("SELECT id from categoriesInBooks WHERE categoriesId = :categoriesId  AND bookMetaId = :bookMetaId");
        $sql->bindValue(':categoriesId', $categoryId);
        $sql->bindValue(':bookMetaId', $bookMetaId);
        $res = $sql->execute();

        $data = $res->fetchArray(SQLITE3_ASSOC);

        if ($data) {
            $res = $status ? "Success" : "Failed";
            return $res;
        } else {

            $sql = $this->prepare("INSERT into categoriesInBooks(categoriesId, bookMetaId)
                values (:categoriesId, :bookMetaId)");
            $sql->bindValue(':categoriesId', $categoryId);
            $sql->bindValue(':bookMetaId', $bookMetaId);
            $status = $sql->execute();
            $res = $status ? "Success" : "Failed";
            return $res;
        }
    }

    public function saveReservationsUser($usersId, $booksId, $reservationDateTime, $accepted)
    {

        $sql = $this->prepare("INSERT INTO reservations (usersId,  booksId, reservationDateTime, accepted)
        values (:userId,:booksId,:reservationDateTime, :accepted)");

        $sql->bindValue(':usersId', $usersId, );
        $sql->bindValue(':booksId', $booksId, );
        $sql->bindValue(':reservationDateTime', $reservationDateTime, );
        $sql->bindValue(':accepted', $accepted, );

        $status = $sql->execute();

        return $status;
    }
    
    public function getReservations($limitNumber, $offsetNumber)
    {
        $sql = "SELECT usersId,booksId, reservationDateTime, accepted , users.surname as usersName, bookMeta.title as booksName
        FROM reservations 
        left join users on users.id = reservations.usersId
		left join books on books.id = reservations.booksId
		left join bookMeta on bookMeta.id = books.bookMetaId		
        GROUP by reservations.id ORDER by reservations.reservationDateTime DESC";

        $sql .= " limit '$limitNumber'";
        $sql .= " offset '$offsetNumber' * '$limitNumber'";
        
        $res = $this->query($sql);

        $data = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }
    
    public function saveCheckouts($usersId, $booksId, $checkoutDateTime, $returnDateTime, $maxAllowedDate, $fine, $isPaid)
    {

        $sql = $this->prepare("INSERT INTO checkouts (usersId,  booksId, checkoutDateTime,returnDateTime, maxAllowedDate, fine, isPaid)
        Select (:usersId,:booksId,:checkoutDateTime, :returnDateTime, :maxAllowedDate, :fine, :isPaid ) from reservations where reservations.booksId = checkouts.booksId");

        $sql->bindValue(':usersId', $usersId, );
        $sql->bindValue(':booksId', $booksId, );
        $sql->bindValue(':checkoutDateTime', $checkoutDateTime, );
        $sql->bindValue(':returnDateTime', $returnDateTime, );
        $sql->bindValue(':maxAllowedDate', $maxAllowedDate, );
        $sql->bindValue(':fine', $fine, );
        $sql->bindValue(':isPaid', $isPaid, );

        $status = $sql->execute();

        return $status;

        
    }
    public function inStock($inStock)
    {

        $sql = $this->prepare("select count booksId");

        $sql->bindValue(':inStock', $inStock, );

        $status = $sql->execute();

        return $status;

        
    }

    public function getCheckouts($limitNumber, $offsetNumber)
    {
        $sql = "SELECT usersId,booksId, checkoutDateTime, returnDateTime ,maxAllowedDate, fine, isPaid ,paidDate, users.surname as usersName, bookMeta.title as booksName
        FROM checkouts 
        left join users on users.id = checkouts.usersId
		left join books on books.id = checkouts.booksId
		left join bookMeta on bookMeta.id = books.bookMetaId	
		ORDER by checkouts.checkoutDateTime DESC";

        $sql .= " limit '$limitNumber'";
        $sql .= " offset '$offsetNumber' * '$limitNumber'";
        
        $res = $this->query($sql);

        $data = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function getProfilePageData($id)
    {
        $sql = $this->prepare("select surname, lastname, email from users where id = :id");
        $sql->bindvalue(':id', $id);
        $res = $sql->execute();

        $data = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }
        return $data;
    }
}
