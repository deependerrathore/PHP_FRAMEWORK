<?php

namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\MaxValidator;

class Contacts extends Model{
    public $id,$user_id,$fname,$lname,$email,$address,$address2,$city,$state,$zip;
    public $home_phone,$cell_phone,$work_phone,$deleted = 0;
    public function __construct(){
        $table = 'contacts';
        parent::__construct($table);
        $this->_softDelete = true;
    }

    
    public function validator(){
        $this->runValidation(new MaxValidator($this,['field'=>'fname','rule'=> 156, 'msg'=>"First name should not be more than 156 characters."]));
        $this->runValidation(new RequiredValidator($this,['field'=>'fname','msg'=>"First name is required"]));

        $this->runValidation(new MaxValidator($this,['field'=>'lname','rule'=> 156,'msg'=>"Last name should not be more than 156 characters."]));
        $this->runValidation(new RequiredValidator($this,['field'=>'lname','msg'=>"Last name is required"]));

    }

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