<?php

class Contacts extends Model{
    public function __construct(){
        $table = 'contacts';
        parent::__construct($table);
        $this->_softDelete = true;
    }

    public static $addValidation =[
        'fname'=>[
            'display' =>'First Name',
            'required'=> true,
            'max' => 255
        ],
        'lname'=>[
            'display' =>'Last Name',
            'required'=> true,
            'max' => 255
        ]

    ];

    public function getAllByUserId($userId, $params=[]){
        $conditions = [
            'conditions' => ['user_id = ?'],
            'bind' => [$userId]
        ];
        $conditions = array_merge($conditions,$params);
        return $this->find($conditions);
    }

    public function displayFullName(){
        return $this->fname . ' ' . $this->lname;
    }
}