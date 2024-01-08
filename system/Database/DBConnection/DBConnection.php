<?php

namespace System\Database\DBConnection;

use PDO;
use PDOException;

class DBConnection{
    private static $dbConnectionInstance = null;

    private function __construct(){}

    public static function getDBConnectionInstance(){
        if(self::$dbConnectionInstance == null){
            $DBConnectionInstance = new DBConnection();
            self::$dbConnectionInstance = $DBConnectionInstance->dbConnection();
        }
        return self::$dbConnectionInstance;
    }

    private function dbConnection(){
        try{
            $options = array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
            $dbConnection = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME.";charset=utf8", DBUSERNAME, DBPASSWORD, $options);
            return $dbConnection;
        }catch(PDOException $e){
            echo "Error in database connection: " .$e->getMessage();
        }
    }

    public static function newInsertId(){
        return self::getDBConnectionInstance()->lastInsertId();
    }
}