<?php
namespace App\Core ;

use PDO ;
use PDOException ;

class Db extends PDO
{
    // Instance unique de la classe
    private static $instance ;

    private function __construct() 
    {
        // DSN de connexion
        $dsn = 'mysql:dbname=' . DBNAME . ';host=' . DBHOST ;

        // On appelle le constructeur de PDO
        try {
            parent::__construct($dsn, DBUSER, DBPASSWORD) ;
            
            // $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET CHARACTER SET utf8mb4') ;
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ) ;
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
            $this->exec('SET CHARACTER SET utf8mb4') ;
        }
        catch (PDOException $e) {
            die($e->getMessage()) ;
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self() ;
        }

        return self::$instance ;
    }
}