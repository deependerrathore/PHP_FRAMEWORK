<?php

class Input{

    public static function get($input){
        if(isset($_POST[$input])){
            return FH::sanatize($_POST[$input]);
        }else{
            return FH::sanatize($_GET[$input]);
        }
    }
}