<?php


namespace System\Database\DBConnection;

use PDO;
use PDOException;

class DBConnection
{

    private static $dbConnectionInstance = null;

    private function __construct()
    {
    }

    public static function getDBConnectionInstance()
    {

        if (self::$dbConnectionInstance == null) {
            $DBConnectionInstance = new DBConnection();
            self::$dbConnectionInstance = $DBConnectionInstance->dbConnection();
        }

        return self::$dbConnectionInstance;
    }

    private function dbConnection()
    {

        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
        try {
            return new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSERNAME, DBPASSWORD, $options);
        } catch (PDOException $e) {
            echo "error in database connection: " . $e->getMessage();
            return false;
        }
    }


    public static function newInsertId()
    {

        return self::getDBConnectionInstance()->lastInsertId();
    }
}
