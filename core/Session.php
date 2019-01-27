<?php

namespace Core;

class Session{
    public static function exists($name){
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function get($name){
        return $_SESSION[$name];
    }

    public static function set($name,$value){
        $_SESSION[$name] = $value;
    }

    public static function delete($name){
        if(self::exists($name)){
            unset($_SESSION[$name]);
        }
    }

    public static function uagent_no_version(){
        $uagent = $_SERVER['HTTP_USER_AGENT'];
        $regex = '/\/[a-zA-Z0-9.]+/';
        $newString = preg_replace($regex,'',$uagent);
        return $newString;
    }

    public static function displayMsg(){
        $alerts = ['is-info','is-success','is-warning','is-danger'];
        $html = '';
        foreach($alerts as $alert){
            if (self::exists($alert)) {
                $html .= '<div  id="alert" class="notification '.$alert.'">';
                $html .= '<button class="delete" onclick="document.getElementById(\'alert\').remove()"></button>';
                $html .= self::get($alert);
                $html .= '</div>';
                self::delete($alert);
            }
        }
        return $html;
    }

    /**
     * Adds the message to the session
     *
     * @param [string] $type can be info, danger, warning and success
     * @param [string] $message is the actual message to be displayed
     * @return void
     */
    public static function addMsg($type,$msg){
        $sessionName = 'is-' . $type;
        self::set($sessionName,$msg);
    }
}