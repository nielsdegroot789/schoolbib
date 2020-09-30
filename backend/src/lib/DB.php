<?php

namespace skoolBiep;

class DB extends \SQLite3
{
    protected $client;
    function __construct()
    {
        parent::__construct('../db/db.sqlite');
    }

    function getTableName()
    {
        return $this->tableName;
    }

    function getBookMeta(){
        $sql = "		
        select bookMeta.id, isbnCode, title, publishDate, rating, totalPages, language, sticker, readingLevel, 
		authors.name as authors, publishers.name as publishers,  group_concat(categories.name, ', ') as categories from bookMeta
		join authors on authors.id = bookMeta.authorsId
		join publishers on publishers.id = bookMeta.publishersId
        join categoriesInBooks on bookMeta.id  = categoriesInBooks.bookMetaId
		join categories on categories.id = categoriesInBooks.categoriesId
		GROUP by bookMeta.id";
        $res = $this->query($sql);

        $data = array();
        while($row = $res->fetchArray(SQLITE3_ASSOC)){
            array_push($data, $row);
        }
       
        return $data;
    }
    
    function getBooks(){
        $sql = "select group_concat(id, ';') as id, group_concat(status, ';') as status, bookMetaId, count(bookMetaId) as count from books
        group by bookMetaId";
        $res = $this->query($sql);

        $data = array();
        while($row = $res->fetchArray(SQLITE3_ASSOC)){
            array_push($data, $row);
        }

        return $data;
    }

    

        
    function saveBook($title, $isbn, $rating, $totalPages, $sticker, $language, $readingLevel, $id=-1){
        if($id != -1){
            //update
            
            $sql = $this->prepare("UPDATE bookMeta SET isbnCode = :isbn, title = :title, rating = :rating, totalPages = :totalPages, language = :language, sticker = :sticker, readingLevel = :readingLevel WHERE id = :id");
            var_dump($sql);

            $sql->bindValue(':isbn', $isbn);
            $sql->bindValue(':title', $title);
            $sql->bindValue(':rating', $rating);
            $sql->bindValue(':totalPages', $totalPages);
            $sql->bindValue(':language', $language);
            $sql->bindValue(':sticker', $sticker);
            $sql->bindValue(':readingLevel', $readingLevel);
            $sql->bindValue(':id', $id);

            $status = $sql->execute();

            $res = $status ? "Success" : "Failed";
            return $res;
        }
        else {
            //create

            var_dump($title);
            $sql = $this->prepare('insert into bookMeta (isbnCode, title, rating, totalPages, language, sticker, readingLevel) 
            values (:isbn, :title, :rating, :totalPages, :language, :sticker, :readingLevel)');

            $sql->bindValue(':isbn', $isbn);
            $sql->bindValue(':title', $title);
            $sql->bindValue(':rating', $rating);
            $sql->bindValue(':totalPages', $totalPages);
            $sql->bindValue(':language', $language);
            $sql->bindValue(':sticker', $sticker);
            $sql->bindValue(':readingLevel', $readingLevel);
            // $sql->bindValue(':authorsId', $POST['authorsId']);
            // $sql->bindValue(':publishersId', $POST['publishersId']);
            // $sql->bindValue(':categories', $POST['categories']);

            $status = $sql->execute();

            $res = $status ? "Success" : "Failed";
            return $res;

        }

    }

    function editBook(){
        $sql = "UPDATE group_concat(id, ';') as id, group_concat(status, ';') as status, bookMetaId, count(bookMetaId) as count from books
        group by bookMetaId";
        $res = $this->query($sql);

        $data = array();
        while($row = $res->fetchArray(SQLITE3_ASSOC)){
            array_push($data, $row);
        }

        return $data;
    }

   
    function saveReservationsUser($usersId,$booksId,$reservationDateTime) {
      
        $sql = $this->prepare("INSERT INTO RESERVATIONS (usersId,  booksId, reservationDateTime) 
        values (:userId,:booksId,:reservationDateTime)");

        $sql->bindValue(':usersId' , $usersId,);
        $sql->bindValue(':booksId' , $booksId,);
        $sql->bindValue(':reservationDateTime' , $reservationDateTime,);

            $status = $sql->execute();

            return $status;

    }
    
    public function getReservation(){
        $sql="select id, usersId, booksId, reservationDateTime, accepted FROM reservations GROUP by reservations.id ORDER by reservationDateTime DESC" ;
        $res = $this->query($sql);

        $data = array();
        while($row = $res->fetchArray(SQLITE3_ASSOC)){
            array_push($data, $row);
        }

        return $data;
    }
    //(accepted? apparte functie fnie?)
    function saveCheckoutAdmin($usersId,$booksId,$checkoutDateTime,$returnDateTime,$maxAllowedDate) {
      
        $sql = $this->prepare("INSERT INTO checkouts (usersId,  booksId, checkoutDateTime,returnDateTime, maxAllowedDate) 
        Select (:userId,:booksId,:checkoutDateTime, :returnDateTime, :maxAllowedDate ) from reservations where reservations.booksId = checkouts.booksId");
        
        $sql->bindValue(':usersId' , $usersId,);
        $sql->bindValue(':booksId' , $booksId,);
        $sql->bindValue(':checkoutDateTime' , $checkoutDateTime,);
        $sql->bindValue(':returnDateTime' , $returnDateTime,);
        $sql->bindValue(':maxAllowedDate' , $maxAllowedDate,);

        $status = $sql->execute();

        return $status;
    }


    public function getCheckout(){
        $sql="select id, usersId, booksId, checkoutDateTime, returnDateTime, maxAllowedDate, fine, isPaid, paidDate FROM checkouts GROUP by checkouts.id ORDER by checkoutDateTime DESC" ;
        $res = $this->query($sql);

        $data = array();
        while($row = $res->fetchArray(SQLITE3_ASSOC)){
            array_push($data, $row);
        }

        return $data;
    }
}
