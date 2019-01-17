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

    public function findByIdAndUserId($contactId,$userId,$params=[]){
        $conditions = [
            'conditions'=>['id = ? AND user_id = ?'],
            'bind'=> [$contactId,$userId]
        ];
        $conditions = array_merge($conditions,$params);

        return $this->findFirst($conditions);
        
    }

    public function displayAddress(){
        $address = '';

        if (!empty($this->address)) {
            $address .= $this->address . '<br>';  
        }
        if (!empty($this->address2)) {
            $address .= $this->address2 . '<br>';  
        }
        if (!empty($this->city)) {
            $address .= $this->city . ', ';  
        }
        if (!empty($this->state)) {
            $address .= $this->state . ', ';  
        }
        if (!empty($this->zip)) {
            $address .= $this->zip . '<br>';  
        }

        return $address;

    }
    public function displayAddressLabel(){
        $html = $this->displayFullName() . '<br />';
        $html .= $this->displayAddress();
        return $html;

    }
}