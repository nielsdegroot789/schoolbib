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
}