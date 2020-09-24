<?php

namespace skoolBiep;

class DB extends \SQLite3
{
    protected $client;
    function __construct()
    {
        $this->open('../db/db.sqlite');

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

    public function GetReservations(){
        $sql="select id, userId, bookId, reservationDateTime, accepted from reservations group by userId" ;
        $res = $this->query($sql);
        
        $data = array();
        while($row = $res->fetchArray(SQLITE3_ASSOC)){
            array_push($data, $row);
        }

        return $data;
    }
    
}