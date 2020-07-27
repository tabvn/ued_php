<?php

class Database
{
    private static $db;
    private $connection;

    private function __construct()
    {
        $this->connection =  new mysqli(HOST,DB_USER,DB_PASSWORD,DB);
    }

    function __destruct()
    {
        $this->connection->close();
    }

    public static function getConnection()
    {
        if (self::$db == null) {
            self::$db = new Database();
        }
        return self::$db->connection;
    }
}