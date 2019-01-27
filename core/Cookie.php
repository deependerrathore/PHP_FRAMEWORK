<?php

namespace Core;

class Cookie{
    public static function set($name,$value,$expiry){
        if(setcookie($name,$value,time()+$expiry,'/',NULL,NULL,TRUE)){
            return true;
        }

        return false;
    }

    public static function delete($name,$expiry){
        self::set($name,'',$expiry - 1000);
    }

    public static function get($name){
        return $_COOKIE[$name];
    }

    public static function exists($name){
        return isset($_COOKIE[$name]);
    }

}