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

    public static function currentLoggedInUser(){
        if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)){

            $u = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));

            self::$currentLoggedInUser = $u;
        }
        return self::$currentLoggedInUser;
    }

    public function login($rememberMe = false){

        //set the session with the ID
        Session::set($this->_sessionName,$this->id);
        
        if ($rememberMe) {
            //generate a unique hash that we will be using in session and cookie
            $hash = md5(uniqid() + rand(0,100));

            //getting the useragent from Session class
            $user_agent = Session::uagent_no_version();


            //set the cookie with the hash value
            Cookie::set($this->_cookieName,$hash,REMEMBER_ME_COOKIE_EXPIRY);
            $fields = [
                'session' => $hash,
                'user_agent' =>$user_agent,
                'user_id' => $this->id
            ];
            $this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->id,$user_agent]);

            $this->_db->insert('user_sessions',$fields);
        }   
    }

    public static function loginUserFromCookie(){
        $userSession = UserSessions::getFromCookie();

        if($userSession->user_id != ''){
            $user= new Self((int)$userSession->user_id);
        }else{
            $user= null;
        }

        if($user){
            $user->login();
        }
        return $user;
    }

    public function logout(){
        $userSession = UserSessions::getFromCookie();
        if($userSession) $userSession->delete();
        Session::delete(CURRENT_USER_SESSION_NAME);
        if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
            Cookie::delete(REMEMBER_ME_COOKIE_NAME,REMEMBER_ME_COOKEI_EXPIRY);
        }
        self::$currentLoggedInUser = null;
        return true;

    }

    public function registerNewUser($params){
        $this->assign($params);
        $this->deleted = 0;
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);
        $this->save();
    }

    public function acls(){
        if(empty($this->acl)) return [];
        return json_decode($this->acl,true);
    }
    
}