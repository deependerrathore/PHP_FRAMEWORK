<?php

class DB{
    private static $_instance = null;
    private $_pdo ,$query,$_error = false, $_result,$count = 0 , $_lastInserID = null;

    public function __construct()
    {
        try{
            $this->_pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }

        return self::$_instance;
    }

}