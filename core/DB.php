<?php

namespace Core;
use \PDO;
use \PDOException;
class DB{
    private static $_instance = null;
    private $_pdo ,$_query,$_error = false, $_result,$_count = 0 , $_lastInsertID = null;

    public function __construct()
    {
        try{
            $this->_pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance(){

        //check if instance is already set, if not create a new DB instance
        if(!isset(self::$_instance)){
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    //query function will take sql query with parameter values which will be going to replaced with ?
    public function query($sql, $params = [],$class = false){
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
            if ($class) {
                $this->_result = $this->_query->fetchAll(PDO::FETCH_CLASS, $class);
            } else {    
                $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
            }            
            $this->_count = $this->_query->rowCount();
            $this->_lastInsertID = $this->_pdo->lastInsertId();
        }else{
            $this->_error = true;
        }

        return $this;
    }

    protected function _read($table,$params=[],$class){
        $conditionString = '';
        $bind = [];
        $order = '';
        $limit = '';

        //Conditions
        if (isset($params['conditions'])) {
            if(is_array($params['conditions'])){
                foreach($params['conditions'] as $condition){
                    $conditionString .= ' ' . $condition . ' AND' ;
                }

                $conditionString = trim($conditionString);
                $conditionString = rtrim($conditionString,' AND');
            }else{
                $conditionString = $params['conditions'];
            }

            if($conditionString != ''){
                $conditionString = ' WHERE ' . $conditionString;
            }
        }

        //Binding
        if(array_key_exists('bind',$params)){
            $bind = $params['bind'];
        }

        //Order
        if (array_key_exists('order',$params)) {
            $order = ' ORDER BY ' . $params['order'];
        }

        //Limit 
        if(array_key_exists('limit',$params)){
            $limit = ' LIMIT ' . $params['limit'];
        }

        $sql = "SELECT * FROM {$table} {$conditionString} {$order} {$limit}"; 

        if ($this->query($sql,$bind,$class)) {
            if(!count($this->_result)) return false;
            return true;
        }

        return false;

    }

    /**
     * @fun find
     * Parameter:  
     * table and parameters format = ['conditions' => ['lname = ?','fname = ?'],'bind' => ['singh','Narender'],'order' => "lname,fname",'limit' => 5]
     */
    public function find($table,$params = [],$class = false){
        if($this->_read($table,$params,$class)){
            return $this->results();
        }
        return false;
    }

    /**
     * @fun findFirst
     * Parameter:  
     * table and parameters format = ['conditions' => ['lname = ?','fname = ?'],'bind' => ['singh','Narender'],'order' => "lname,fname",'limit' => 5]
     */
    public function findFirst($table,$params=[],$class = false){
        if ($this->_read($table,$params,$class)) {
            return $this->first();
        }

        return false;
    }

    /**
     * @fun insert
     * Parameter: table name , $array $fields = ['fname' => 'Onkar','lname' => 'Rathore','email' => 'onkar@onkar.com'];
     */
    public function insert($table,$fields = []){
        $fieldString = '';
        $valueString = '';
        $values = [];

        foreach($fields as $field => $value){
            $fieldString .= '`' . $field . '`,';
            $valueString .= '?,';
            $values[] = $value;
        }
        $fieldString = rtrim($fieldString,',');
        $valueString = rtrim($valueString,',');

        //forming the insert query
        $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ($valueString)";

        //passing the sql to query function with parameter
        if (!$this->query($sql,$values)->error()) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @fun update
     * Parameter: table name , id, $array $fields = ['fname' => 'Onkar','lname' => 'Rathore','email' => 'onkar@onkar.com'];
     */
    public function update($table,$id,$fields){
        $fieldString = '';
        $valueString = '';
        $values = [];
        foreach($fields as $field => $value){
            $fieldString .= ' '. $field . ' = ?, ';
            $values[] = $value;
        }
        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString,',');
        $sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";
        
        if (!$this->query($sql,$values)->error()) {
            return true;
        }else{
            return false;
        }
    }

    public function delete($table,$id){
        $sql = "DELETE FROM {$table} WHERE id = {$id}";

        if (!$this->query($sql)->error()) {
            return true;
        }else{
            return false;
        }
    }

    //returns the results of the query from query() method
    public function results(){
        return $this->_result;
    }

    //return the first row of the query 
    public function first(){
        return (!empty($this->_result)) ? $this->_result[0] : [];
    }

    //returns the count for query from query() method
    public function count(){
        return $this->_count;
    }
    
    //returns the columns details
    public function get_columns($table){
        return $this->query("SHOW COLUMNS FROM {$table}")->results();
    }

    //This will return last insert id
    public function lastID(){
        return $this->_lastInsertID;
    }

    public function error(){
        return $this->_error;
    }
}