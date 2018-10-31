<?php

class Model{
    protected $_db,$_table,$_modelName,$_softDelete = false, $_columnsNames = [];

    public $id;

    public function __construct($table){
        $this->_db = DB::getInstance();
        $this->_table = $table;
        $this->_setColumnNames();
        $this->_modelName = str_replace(' ','',ucwords(str_replace('_',' ',$this->_table)));

    }

    public function _setColumnNames(){
        $columns = $this->get_columns();
        foreach($columns as $column){
            $this->_columnsNames[] = $column->Field;
            //$this->{$columnName} = null;
        }
    }

    protected function get_columns(){
        return $this->_db->get_columns($this->_table);
    }

    public function find($params = []){
        $results = [];
        $resultQuery = $this->_db->find($this->_table,$params);

        foreach($resultQuery as $result){
            $obj = new $this->_modelName($this->_table);
            $this->populateObjData($result);
            $results[] = $obj;
        }

        return $results;
    }

    public function findFirst($params = []){
        $resultQuery = $this->_db->findFirst($this->_table,$params);
        $result = new $this->_modelName($this->_table);
        $result->populateObjData($resultQuery);
        return $result;
    }

    public function findById($id){
        return $this->findFirst([
            'conditions' => ['id = ?'],
            'bind' => [$id]
        ]);
    }

    public function save(){
        $fields = [];
        foreach($this->_columnsNames as $column){
            $fields[$column] = $this->$column; //$field[id] = $this->id i.e. actual value;
        }   

        //Determine whether to update or insert
        if(property_exists($this,'id') && $this->id != ''){
            return $this->update($this->id,$fields);
        }else{
            return $this->insert($fields);
        }
    }

    public function insert($fields){
        if(empty($fields)) return false;
        return $this->_db->insert($this->_table,$fields);
    }

    public function update($id,$fields){
        if (empty($id) || id == '') return false;
        return $this->_db->update($this->_table,$id,$fields);
    }
    protected function populateObjData($result){
        foreach($result as $key => $value){
            $this->$key = $value;
        }
    }
}