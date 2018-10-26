<?php

class DB{
    private static $_instance = null;
    private $_pdo ,$_query,$_error = false, $_result,$_count = 0 , $_lastInserID = null;

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

    public function query($sql, $params = []){
        $_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            
            $x = 1;
            if (count($params)) {
                foreach($params as $param){
                    /**
                    * @fun bindValue
                    * Paramerter:
                    * Parameter identifier. For a prepared statement using named placeholders, this will be a parameter name of the form :name. For a prepared statement using question mark placeholders, this will be the 1-indexed position of the parameter.
                    * Value:
                    * The value to bind to the parameter.
                    */
                    $this->_query->bindValue($x,$param);
                    $x++;
                }
            }
        }

        if ($this->_query->execute()) {
            $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
            $this->_count = $this->_query->rowCount();
            $this->_lastInserID = $this->_pdo->lastInsertId();
        }else{
            $this->_error = true;
        }

        return $this;
    }

}