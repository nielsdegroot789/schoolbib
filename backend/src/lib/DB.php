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

    function getBooksMeta(){
        $sql = "select bookMeta.id, isbnCode, title, publishDate, rating, totalPages, language, sticker, readingLevel, authors.name as authors, publishers.name as publishers,  group_concat(categories.name) as categories from bookMeta
        join authors on authors.id = bookMeta.authorsId
        join publishers on publishers.id = bookMeta.publishersId
        join categoriesInBooks on categoriesInBooks.bookMetaId = bookMeta.id 
        join categories on categories.id = categoriesInBooks.categoriesId
        group by bookMeta.id";
        $res = $this->query($sql);

        $data = array();
        while($row = $res->fetchArray()){ 
            array_push($data, $row);
        }

        return $data;
    }
}