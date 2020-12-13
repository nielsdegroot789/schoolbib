<?php

namespace skoolBiep;

use DateInterval;
use DateTime;
use skoolBiep\Util\TranslateReadingLevel;

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
        join categories on categories.id = categoriesInBooks.categoriesId where";

        if (is_array($author)) {
            foreach ($author as $key => $value) {
                $sql .= " authors.name like :author" . $key;
                if (count($author) > $key + 1) {
                    $sql .= " or";
                }
            }
        } else {
            $sql .= " authors.name like :author";
        }

        $sql .= " and title like :title group by bookMeta.id having";

        if (is_array($category)) {
            foreach ($category as $key => $value) {
                $sql .= " categories.name like :category" . $key;
                if (count($category) > $key + 1) {
                    $sql .= " or";
                } else {
                    $sql .= " order by bookMeta.id";
                }
            }
        } else {
            $sql .= " categories.name like :category order by bookMeta.id";
        }

        $sql .= " limit :limit";
        $sql .= " offset :offset";

        $query = $this->prepare($sql);

        $query->bindValue(':limit', $limitNumber);
        $query->bindValue(':offset', $offsetNumber);
        $query->bindValue(':title', $title);

        if (is_array($category)) {
            foreach ($category as $key => $value) {
                $query->bindValue(':category' . $key, $value);
            }
        } else {
            $query->bindValue(':category', $category);
        }

        if (is_array($author)) {
            foreach ($author as $key => $value) {
                $query->bindValue(':author' . $key, $value);
            }
        } else {
            $query->bindValue(':author', $author);
        }

        $res = $query->execute();

        $data = array();
        $translator = new TranslateReadingLevel();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $row["readingLevel"] = $translator($row["readingLevel"]);
            array_push($data, $row);
        }

        return $data;
    }

    public function getBookMetaFromId($id){
        $sql = "select bookMeta.id, isbnCode, title, publishDate, rating, totalPages, language, sticker, readingLevel,
		authors.name as authors, publishers.name as publishers,  group_concat(categories.name, ', ') as categories from bookMeta
		join authors on authors.id = bookMeta.authorsId
		join publishers on publishers.id = bookMeta.publishersId
        join categoriesInBooks on bookMeta.id  = categoriesInBooks.bookMetaId
        join categories on categories.id = categoriesInBooks.categoriesId where bookMeta.id = :id ";
        $query = $this->prepare($sql);
        $query->bindValue(':id', (int)$id);
        $res = $query->execute();

        $data = array();
        $translator = new TranslateReadingLevel();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $row["readingLevel"] = $translator($row["readingLevel"]);
            array_push($data, $row);
        }
        
        return $data;
    }

    public function getBookMetaCount()
    {
        $sql = "select count(id) FROM bookMeta ";

        $res = $this->query($sql);

        $data = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function getBooks()
    {
        $sql = "select group_concat(id, ';') as id, group_concat(status, ';') as status, bookMetaId,
        count(bookMetaId) as count from books
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
            //check if this bookmeta does not already exist.

            $sql = $this->prepare('select id from bookMeta where isbnCode = :isbn');
            $sql->bindValue(':isbn', $isbn);
            $res = $sql->execute();
            // needs work still
            if (false) {
                //TODO This bookMeta already exists in the database. this does not work
                //throw new Exception("This bookMeta already exists in the database under id " . $res->fetchArray(SQLITE3_ASSOC));
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

    public function addToFavoriteBookList($usersId, $bookMetaId)
    {

        $sql = $this->prepare("INSERT INTO favoriteBooks (usersId,  bookMetaId)
        values (:usersId,:bookMetaId)");

        $sql->bindValue(':usersId', $usersId, );
        $sql->bindValue(':bookMetaId', $bookMetaId, );

        $status = $sql->execute();

        return $status;
    }
    public function getFavoriteBooks($id)
    {
        $sql = $this->prepare("SELECT usersId,bookMetaId, title, sticker, totalPages,rating,readingLevel
        FROM favoriteBooks
		LEFT join bookMeta 
		ON favoriteBooks.bookMetaId = bookMeta.Id
        where usersId = :id");
        
        $sql->bindvalue(':id', $id);
        $res = $sql->execute();

        $data = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }
        return $data;
    }
    
    public function getFavoriteAuthors($id)
    {
        $sql = $this->prepare("SELECT favoriteAuthors.id, usersId, authorsId, name
        FROM favoriteAuthors
		LEFT join authors 
		ON favoriteAuthors.authorsId = authors.id
        where usersId = :id");

        $sql->bindvalue(':id', $id);
        $res = $sql->execute();

        $data = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }
        return $data;
    }

    public function deleteFavoriteAuthors($id){
        $sql =  $this->prepare("DELETE FROM favoriteAuthors      
		WHERE id = :id");
             
            $sql->bindvalue(':id', $id);
            $sql->execute();
    }

    
    public function getReservationUser($id)
    {
        $sql =  $this->prepare("SELECT reservations.id,  bookMeta.title as booksName
        FROM reservations        
		left join books on books.id = reservations.booksId
		left join bookMeta on bookMeta.id = books.bookMetaId
		WHERE accepted = 0 AND usersId = :id");
             
             $sql->bindvalue(':id', $id);
             $res = $sql->execute();
     
             $data = array();
             while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                 array_push($data, $row);
             }
             return $data;
    }
    
    public function deleteReservationUser($id)
    {
        $sql =  $this->prepare("DELETE FROM reservations      
		WHERE id = :id");
        
        $sql->bindValue(':id', $id);
        $sql->execute();
        return $id;
    }
    public function getCheckoutUser($id)
    {
        $sql =  $this->prepare("SELECT checkouts.id, usersId, maxAllowedDate, fine, bookMeta.title as booksName
        FROM checkouts        
		left join books on books.id = checkouts.booksId
		left join bookMeta on bookMeta.id = books.bookMetaId
		WHERE usersId = :id
		ORDER by checkouts.maxAllowedDate DESC");
             
             $sql->bindvalue(':id', $id);
             $res = $sql->execute();
     
             $data = array();
             while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                 array_push($data, $row);
             }
             return $data;
    }

    public function saveReservationsUser($usersId, $booksId, $reservationDateTime, $accepted)
    {

        $sql = $this->prepare("INSERT INTO reservations (usersId,  booksId, reservationDateTime, accepted)
        values (:usersId,:booksId,:reservationDateTime, :accepted)");

        $sql->bindValue(':usersId', $usersId, );
        $sql->bindValue(':booksId', $booksId, );
        $sql->bindValue(':reservationDateTime', $reservationDateTime, );
        $sql->bindValue(':accepted', $accepted, );

        return $sql->execute() ? "Success" : "Error";
    }

    public function getReservations($limitNumber, $offsetNumber)
    {
        $sql = "SELECT usersId,booksId, reservationDateTime, accepted , users.surname as usersName, bookMeta.title as booksName
        FROM reservations
        left join users on users.id = reservations.usersId
		left join books on books.id = reservations.booksId
		left join bookMeta on bookMeta.id = books.bookMetaId
        WHERE accepted = 0
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
    
    public function acceptReservation($usersId, $booksId)
    {

        //TODO prevent SQL INJECTION!!! Not working SQL code in master?
        $sql = $this->prepare("UPDATE reservations  SET accepted = 1 WHERE booksId = :booksId AND usersId = :usersId");
        $sql->bindValue(':booksId', $usersId);
        $sql->bindValue(':usersId', $booksId);
        $res = $sql->execute();

        $data = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }

        $res = $status ? "Success" : "Failed";
        return $res;
    }
    public function saveCheckouts($usersId, $booksId, $checkoutDateTime, $maxAllowedDate)
    {
        $sql = $this->prepare("INSERT INTO checkouts (usersId,  booksId, checkoutDateTime, maxAllowedDate)
        values (:usersId, :booksId, :checkoutDateTime, :maxAllowedDate)");

        $sql->bindValue(':usersId', $usersId, );
        $sql->bindValue(':booksId', $booksId, );
        $sql->bindValue(':checkoutDateTime', $checkoutDateTime, );
        $sql->bindValue(':maxAllowedDate', $maxAllowedDate, );

        $status = $sql->execute();

        $this->acceptReservation($usersId, $booksId);

        $res = $status ? "Success" : "Failed";
        return $res;

    }

    public function saveNewCheckout($usersId, $booksId, $checkoutDateTime, $returnDateTime, $maxAllowedDate)
    {

        $sql = $this->prepare("INSERT INTO checkouts (usersId,  booksId, checkoutDateTime,returnDateTime, maxAllowedDate, fine, isPaid)
        values (:usersId,:booksId,:checkoutDateTime, :returnDateTime, :maxAllowedDate, :fine, :isPaid )");

        $sql->bindValue(':usersId', $usersId, );
        $sql->bindValue(':booksId', $booksId, );
        $sql->bindValue(':checkoutDateTime', $checkoutDateTime, );
        $sql->bindValue(':returnDateTime', $returnDateTime, );
        $sql->bindValue(':maxAllowedDate', $maxAllowedDate, );

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
        WHERE returnDateTime IS NULL
		ORDER by checkouts.maxAllowedDate DESC";

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

    public function saveProfileData($id, $surname, $lastname, $email)
    {
        $sql = $this->prepare("update users set surname = :surname, lastname = :lastname, email = :email where id = :id ");
        $sql->bindValue(':surname', $surname);
        $sql->bindValue(':lastname', $lastname);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':id', $id);

        $res = $sql->execute();
        return $res;
    }

    public function getAllUsers()
    {
        $sql = 'select id,surname,lastname,age,email from users';
        $data = $this->query($sql);

        $res = array();

        while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
            array_push($res, $row);
        }
        return $res;
    }

    public function checkAdress($email)
    {
        $sql = $this->prepare('select id from users where email = :email');
        $sql->bindValue(':email', $email);

        $res = $sql->execute();
        $idArray = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($idArray, $row);
        }

        if (!$idArray) {
            return false;
        } else {
            $id = $idArray['0']['id'];
            $now = new DateTime();
            $now->add(new DateInterval("PT1H"));
            $expireDate = $now->format('Y-m-d H:i:s');
            $token = md5(uniqid(rand(), true));}

        $sql = $this->prepare("insert into tokens (users_id, expireDate, token) values(:id, :expireDate, :token)");
        $sql->bindValue(':id', $id);
        $sql->bindValue('expireDate', $expireDate);
        $sql->bindValue('token', $token);
        $sql->execute();

        return $token;
    }
    public function checkToken($token)
    {
        $sql = $this->prepare('select users_id,token,expireDate from tokens where token = :token');
        $sql->bindValue(':token', $token);

        $res = $sql->execute();
        $userArray = array();
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($userArray, $row);
        }
        if ($userArray) {
            $dateNow = new DateTime();
            $expireDate = new DateTime($userArray[0]['expireDate']);
            if ($dateNow > $expireDate) {
                $answer['message'] = 'Invalid token';
            } else {
                $answer['message'] = 'Valid token';
                $answer['userId'] = $userArray[0]['users_id'];
            }
        } else {
            $answer['message'] = 'Invalid token';
        }
        return $answer;
    }
    public function updatePassword($password, $id)
    {

        $sql = $this->prepare('Update users set password = :password where id = :id');
        $sql->bindValue(':password', $password);
        $sql->bindValue(':id', $id);
        $sql->execute();
        return 'password succesfully updated';
    }
    public function getAdminSpecificBooks($id)
    {
        $sql = $this->prepare('select * from books where bookMetaId = :id');
        $sql->bindValue(':id', $id);
        $data = $sql->execute();

        $res = array();
        while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
            array_push($res, $row);
        }
        return $res;
    }

    public function deleteSpecificBook($id)
    {
        $sql = $this->prepare('delete from books where id = :id');
        $sql->bindValue(':id', $id);
        $res = $sql->execute();
        return $res;

    }

    public function updateSpecificBook($id, $stock, $qrCode, $status)
    {
        $sql = $this->prepare("Update books set stock = :stock, qrCode = :qrCode, status = :status where id = :id");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':stock', $stock);
        $sql->bindValue(':qrCode', $qrCode);
        $sql->bindValue(':status', $status);
        $res = $sql->execute();
        return $res;
    }

    public function newBook($stock, $qrCode, $status, $bookMetaId)
    {
        $sql = $this->prepare("insert into books (stock, qrCode, status, bookMetaId) values(:stock, :qrCode, :status, :bookMetaId)");
        $sql->bindValue(':stock', $stock);
        $sql->bindValue(':qrCode', $qrCode);
        $sql->bindValue(':status', $status);
        $sql->bindValue(':bookMetaId', $bookMetaId);
        $res = $sql->execute();
        return $res;
    }

    public function searchFilters($searchVal)
    {
        $sql = $this->prepare("select 'Authors' as type, name, id from authors where name like :searchVal
       union select 'Categories', name, id from categories where name like :searchVal
        union select 'Title', title, id from bookMeta where title like :searchVal");
        $sql->bindValue(":searchVal", $searchVal);
        $data = $sql->execute();

        $result = array();
        while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
            array_push($result, $row);
        }

        return $result;
    }
    public function updateFines()
    {
        //Get all checkouts
        $sql = $this->prepare("
        select checkouts.id, booksId, maxAllowedDate, users.email as email from checkouts
        join users on usersId = users.id
        where returnDateTime is null");
        $data = $sql->execute();
        $checkouts = array();
        while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
            array_push($checkouts, $row);
        }

        foreach($checkouts as $checkout){
            //Parse checkouts to Unix
            $returnDateTrimmed = strstr($checkout['maxAllowedDate'], ',', true);      
            $returnDateYearFirstNotation = date_create_from_format("d/m/Y", $returnDateTrimmed);     
            $returnUnix = $returnDateYearFirstNotation->getTimestamp(); 
            $date = new DateTime();
            $now = $date->getTimestamp(); 

            //If book did not need to be returned yet
            if($returnUnix > $now){
                $daysUntilHandin = ($returnUnix - $now) / (60 * 60 * 24);
                if((int)$daysUntilHandin == 2 || (int)$daysUntilHandin == 1 )
                {
                    return [$daysUntilHandin, $checkout['email']];
                }
                //Book does not need to be return yet
                continue;
            }

            //If book needed to be returned already
            $daysLate = ($now - $returnUnix) / (60 * 60 * 24);
            $fine = $daysLate * 0.5 + 1;
            $sql = $this->prepare("update checkouts set fine = :fine where id = :checkoutId");
            $sql->bindValue(":fine", $fine);
            $sql->bindValue(":checkoutId", $checkout['id']);
            $data = $sql->execute();
            return -1;
        }

    }
}
