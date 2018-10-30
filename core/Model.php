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
            $this->{$columnName} = null;
        }
    }

    protected function get_columns(){
        return $this->_db->get_columsn($this->_table);
    }
}