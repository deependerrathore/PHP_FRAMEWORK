<?php

class Users extends Model{
    private $_isLoggedIn, $_sessionName , $_cookieName;

    public static $currentLoggedInUser = null;

    public function __construct($user = ''){
        $table = 'users';
        parent::__construct($table);
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        $this->_softDelete = true;

        if($user != ''){
            if(is_int($user)){
                $u = $this->_db->findFirst('users',[
                    'conditions' => ['id = ?'],
                    'bind' => [$user]
                ]);
            }else{
                $u = $this->_db->findFirst('users',[
                    'conditions' => ['username = ?'],
                    'bind' => [$user]
                ]);
            }

            if($u){
                foreach($u as $key => $value){
                    $this->$key = $value;
                }
            }
        }
        
    }

    public function findByUsername($username){
        return $this->findFirst([
            'conditions' => 'username = ?',
            'bind' => [$username]
        ]);
    }

    

    
}