<?php

class Database
{
    public static $connection;

    public static function setUpConnection()
    {
        if (!isset(Database::$connection)) {
            Database::$connection = new mysqli("localhost", "USERNAME", "PASSWORD", "shop_db", "3306"); //change the details according to your configuration.
        }
    }

    public static function iud($q)
    {
        Database::setUpConnection();
        Database::$connection->query($q);
    }

    public static function search($q)
    {
        Database::setUpConnection();
        $resultset = Database::$connection->query($q);
        return $resultset;
    }
}
