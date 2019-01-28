<?php

namespace App\Models;

use Core\Model;
use Core\Session;
use Core\Cookie;

class UserSessions extends Model{
    public $id,$user_id,$token,$user_agent;
    public function __construct(){
        $table = 'user_sessions';
        parent::__construct($table);    
    }

    public static function getFromCookie(){
        $userSession = new self();
        if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
            $userSession = $userSession->findFirst([
                'conditions' => "user_agent = ? AND token = ?",
                'bind' => [Session::uagent_no_version(),sha1(Cookie::get(REMEMBER_ME_COOKIE_NAME))]
            ]);

            if(!$userSession) return false;

            return $userSession;//this is the Users Object on which we can perform the operations
        }
    }

    public static function deleteSessionsForAllDevice(){
        $userSession  = new self();
        if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
            $userSession = $userSession->_db->query("DELETE FROM user_sessions WHERE user_id = ?", [Users::currentUser()->id]);
            if(!$userSession) return false;
            return $userSession;
        }
    }
}