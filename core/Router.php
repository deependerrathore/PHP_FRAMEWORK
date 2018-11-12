<?php

class Router{

    public static function route($url){//$url is defined in index.php
        //controller
        $controller = (!empty($url) && $url[0] != '') ? ucfirst($url[0]) : DEFAULT_CONTROLLER;//DEFAULT_CONTROLLER @config/config.php
        $controller_name = $controller;
        array_shift($url);

        //actions
        $action = (!empty($url) && $url[0] != '') ? lcfirst($url[0]) . 'Action' : 'indexAction';
        $action_name = (isset($url[0]) && $url[0] != '')? $url[0] : 'index';
        array_shift($url);

        //ACL check
        $grantAccess = self::hasAccess($controller_name,$action_name);

        if(!$grantAccess){
            $controller_name = $controller = ACCESS_RESTRICTED;
            $action = 'indexAction';
        }
        //Params
        $queryParams = $url;


        //Checking the the controller existing or not
        if (class_exists($controller)) {
            $dispatch = new $controller($controller_name,$action_name);
        }else{
            die("CLASS {$controller} does not exists");
        }
        if(method_exists($controller,$action)){
            
            call_user_func_array([$dispatch,$action],$queryParams); //$dispatch->$action($queryParams)
           
        }else{
            echo "{$action} doesnot exist in the {$controller} controller"; 
        }
    }

    public static function redirect($location){
        if(!headers_sent()){
            header('Location:'.PROJECT_ROOT.$location);
            exit();
        }else{
            echo '<script type="text/javascript">';
            echo 'windown.location.href="' . PROJECT_ROOT.$location.'";';
            echo '<script>';

            echo '<noscript>';
            echo '<meta http-equiv="refresh" contect=0;url='.$location.'"/>';
            echo '</noscript>';

            exit();
        }
    }

    public static function hasAccess($controller_name,$action_name = 'index'){
        $acl_file = file_get_contents(ROOT. DS . 'app'. DS . 'acl.json');
        $acl = json_decode($acl_file,true);//true will convert the object to associative array
        $current_user_acls = ["Guest"];
        $grantAccess = false;

        if(Session::exists(CURRENT_USER_SESSION_NAME)){
            $current_user_acls[] = "LoggedIn";
            foreach(currentUser()->acls() as $a){
                $current_user_acls[] = $a;
            }
        }

        foreach($current_user_acls as $level){//$level = Guest,LoggedIn,Admin
            if(array_key_exists($level,$acl) && array_key_exists($controller_name,$acl[$level])){

                if(in_array($action_name,$acl[$level][$controller_name]) || in_array("*",$acl[$level][$controller_name])){
                    $grantAccess = true;
                    break;
                }
            }
        }

        //check for denied
        foreach($current_user_acls as $level){
            $denied = $acl[$level]['denied'];
            if (!empty($denied) && array_key_exists($controller_name,$denied) && in_array($action_name,$denied[$controller_name])) {
                $grantAccess = false;
                break;
            }
        }

        return $grantAccess;
    }

}