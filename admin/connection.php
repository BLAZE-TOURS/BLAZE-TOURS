<?php

class Database
{

    public static $connection;

    // Setup the database connection
    public static function setUpConnection()
    {
        if (!isset(Database::$connection)) {

    Database::$connection = new mysqli("localhost", "root", "#Lucky2003sql", "blaze-tours_db", 3306);
           // Database::$connection = new mysqli("localhost", "root", "SMsuperX@262", "blaze-tours_db", 3306, '/tmp/mysql.sock');
         //Database::$connection = new mysqli("localhost", "root", "SMsuperX@262", "blaze-tours_db", 3306 );
       


            // Check for connection errors
            if (Database::$connection->connect_error) {
                die("Connection failed: " . Database::$connection->connect_error);
            }
        }
    }

    // Function to escape strings to prevent SQL injection
    public static function escape_string($string)
    {
        Database::setUpConnection();
        return Database::$connection->real_escape_string($string);
    }

    // Function to execute Insert/Update/Delete (IUD) queries
    public static function iud($q)
    {
        Database::setUpConnection();
        if (!Database::$connection->query($q)) {
            throw new Exception("Error executing query: " . Database::$connection->error . " | SQL: $q");
        }
    }

    // Function to execute a Select query and return the result set
    public static function search($q)
    {
        Database::setUpConnection();
        $resultset = Database::$connection->query($q);
        if ($resultset === false) {
            throw new Exception("Error executing query: " . Database::$connection->error . " | SQL: $q");
        }
        return $resultset;
    }
}
