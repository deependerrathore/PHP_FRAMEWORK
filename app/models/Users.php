<?php

namespace App\Models;
use Core\Model;

use App\Models\Users as Users;
use App\Models\UserSessions;
use Core\Session;
use Core\Cookie;
use Core\FH;
use Core\H;
use Core\Validators\MinValidator;
use Core\Validators\MaxValidator;
use Core\Validators\RequiredValidator;
use Core\Validators\EmailValidator;
use Core\Validators\UniqueValidator;
use Core\Validators\MatchesValidator;
use Core\Validators\UsernameValidator;

class Users extends Model{
    private $_isLoggedIn, $_sessionName , $_cookieName, $_confirm;

    public $id, $username,$password,$email,$fname,$lname,$acl,$deleted=0,$whenaccountcreated ,$verified = 0,$profileimg;

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
                    'bind' => [$user],
                    'Users'
                ]);
            }else{
                $u = $this->_db->findFirst('users',[
                    'conditions' => ['username = ?'],
                    'bind' => [$user],
                    'Users'
                ]);
            }
            if($u){
                foreach($u as $key => $value){
                    $this->$key = $value;
                }
            }

        }

    }

    public function validator(){
        $this->runValidation(new RequiredValidator($this,['field'=>'fname','msg' => 'First name is required.']));
        $this->runValidation(new RequiredValidator($this,['field'=>'lname','msg' => 'Last name is required.']));
        $this->runValidation(new RequiredValidator($this,['field'=>'email','msg' => 'Email is required.']));
        $this->runValidation(new EmailValidator($this,['field'=>'email','msg' => 'Your must provide a valid email address.']));
        $this->runValidation(new MaxValidator($this,['field'=>'email','rule'=>150,'msg'=>'Email should be not more than 150 characters.']));
        $this->runValidation(new UniqueValidator($this,['field'=>'email','msg'=>'Email in use. Please choose another email.']));

        $this->runValidation(new MinValidator($this,['field'=>'username','rule'=>6,'msg'=>'Username should be at least 6 characters.']));
        $this->runValidation(new MaxValidator($this,['field'=>'username','rule'=>150,'msg'=>'Username should be not more than 150 characters.']));
        $this->runValidation(new UniqueValidator($this,['field'=>'username','msg'=>'Username already exist. Please choose another username.']));
        $this->runValidation(new UsernameValidator($this,['field'=>'username','msg'=>'Username must be valid. only _ is acceptable as special character.']));

        $this->runValidation(new RequiredValidator($this,['field'=>'password','msg' => 'Password is required.']));
        $this->runValidation(new MatchesValidator($this,['field'=>'password','rule'=>$this->_confirm,'msg'=>'Password and confirm password do not match.']));
        $this->runValidation(new MinValidator($this,['field'=>'password','rule'=>6,'msg'=>'Password should be at least 6 characters.']));


    }

    public function beforeSave(){
        $this->fname = ucfirst($this->fname);
        $this->lname = ucfirst($this->lname);
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);
        $this->whenaccountcreated = date('Y-m-d H:i:s');
        $this->profileimg = 'default';
    }

    public function findByUsername($username){
        return $this->findFirst([
            'conditions' => 'username = ?',
            'bind' => [$username]
        ]);
    }

    public function findByEmail($email){
        return $this->findFirst([
            'conditions' => 'email = ?',
            'bind' => [$email]
        ]);
    }

    public static function currentUser(){
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
            $cstrong = TRUE;
            $token =  bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
            //getting the useragent from Session class
            $user_agent = Session::uagent_no_version();


            //set the cookie with the hash value
            Cookie::set($this->_cookieName,$token,REMEMBER_ME_COOKIE_EXPIRY);
            $fields = [
                'token' => sha1($token),
                'user_agent' =>$user_agent,
                'user_id' => $this->id
            ];
            $this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->id,$user_agent]);

            $this->_db->insert('user_sessions',$fields);
        }   
    }

    public static function loginUserFromCookie(){
        $userSession = UserSessions::getFromCookie();
        
        if($userSession && $userSession->user_id != ''){
            $user= new Self((int)$userSession->user_id);

            if($user){
                $user->login();
            }
            return $user;
        }

        return;
        
    }

    /**
     * To logout of the current session
     *
     * @param boolean $allDevices pass TRUE to logout of the all devices
     * @return boolean
     */
    public function logout($allDevices = false){
        if ($allDevices) {
            UserSessions::deleteSessionsForAllDevice();
        }else{
            $userSession = UserSessions::getFromCookie();
            if($userSession) $userSession->delete();
        }
        Session::delete(CURRENT_USER_SESSION_NAME);
        if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
            Cookie::delete(REMEMBER_ME_COOKIE_NAME, REMEMBER_ME_COOKIE_EXPIRY);
        }
        self::$currentLoggedInUser = null;
        return true;
        
    }

    public function acls(){
        if(empty($this->acl)) return [];
        return json_decode($this->acl,true);
    }

    public function changePassword($userid,$params){
        // $user = new Users(currentUser()->id);
        // $user->password = password_hash($params['newpassword'],PASSWORD_DEFAULT);
        // $user->save();
        $changedPassword = password_hash($params['newpassword'],PASSWORD_DEFAULT);
        $fields = [
            'password' => $changedPassword
        ];
        $this->update($userid,$fields);
        return true;
    }
    
    public function setConfirm($value){
        $this->_confirm = FH::sanatize($value);
    }

    public function getConfirm(){
        return $this->_confirm;
    }
}