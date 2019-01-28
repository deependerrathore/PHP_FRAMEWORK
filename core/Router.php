<?php

namespace Core;
use Core\Session;
use App\Models\Users;
class Router{

    /**
     * This method will handle all of the URL request coming from index page
     *
     * @param array $url - defined in index page
     * @return void sends to request to different controller
     */
    public static function route($url){
        //controller
        $controller = (!empty($url) && $url[0] != '') ? ucfirst($url[0]).'Controller' : DEFAULT_CONTROLLER . 'Controller';//DEFAULT_CONTROLLER @config/config.php
        $controller_name = str_replace('Controller','',$controller);
        
        /*
         *array_shift() shifts the first value of the array off and returns it, shortening the array by one element and moving everything down. 
         *All numerical array keys will be modified to start counting from zero while literal keys won't be touched.
         */
        array_shift($url);
        

        //actions
        $action = (!empty($url) && $url[0] != '') ? lcfirst($url[0]) . 'Action' : 'indexAction';
        $action_name = (isset($url[0]) && $url[0] != '')? $url[0] : 'index';
        
        array_shift($url);

        //ACL check
        $grantAccess = true;// self::hasAccess($controller_name,$action_name); //Remove true to enable the ACL

        //if access is not granted then setting the controller to Restricted Controller.
        if(!$grantAccess){
            $controller = ACCESS_RESTRICTED .'Controller';
            $controller_name = ACCESS_RESTRICTED;
            $action = 'indexAction';
        }
        
        //Params
        $queryParams = $url;
        $controller = 'App\Controllers\\' . $controller;
        //Checking the the controller existing or not
        if (class_exists($controller)) {
            $dispatch = new $controller($controller_name,$action_name);
        }else{
            die("CLASS {$controller} does not exists");
        }
        if(method_exists($controller,$action)){
            call_user_func_array([$dispatch,$action],array($queryParams)); //$dispatch->$action($queryParams)
        }else{
            echo "{$action} doesnot exist in the {$controller} controller"; 
        }
    }

    /**
     * Redirect the user to particular location
     *
     * @param string $location user have to provide the location in form of controller/action
     * @return void
     */
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

    /**
     * This method will check for access to different controller and action for any particular user
     *
     * @param string $controller_name
     * @param string $action_name
     * @return boolean
     */
    public static function hasAccess($controller_name,$action_name = 'index'){
        $acl_file = file_get_contents(ROOT. DS . 'app'. DS . 'acl.json');
        $acl = json_decode($acl_file,true);//true will convert the object to associative array
        $current_user_acls = ["Guest"];
        $grantAccess = false;

        //Checking for the logged in user based upon the session
        if(Session::exists(CURRENT_USER_SESSION_NAME)){
            //adding item "LoggedIn" to $current_user_acls array
            $current_user_acls[] = "LoggedIn";
            foreach(Users::currentUser()->acls() as $a){
                $current_user_acls[] = $a;
            }
        }

        foreach($current_user_acls as $level){//$level = Guest,LoggedIn,["Admin","xxxxx"](FROM DB)
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


    public static function getMenu($menu){
        $menuAry = [];
        $menuFile = file_get_contents(ROOT. DS . 'app' . DS . $menu . '.json');

        $acl = json_decode($menuFile,true);

        foreach($acl as $key => $val){
            if(is_array($val)){
                $sub = [];
                foreach($val as $k => $v){
                    if($k == 'separator' && !empty($sub)){
                        $sub[$k] = '';
                        continue;
                    }elseif($finalVal = self::get_link($v)){
                        $sub[$k] = $finalVal;
                    }
                }

                if(!empty($sub)){
                    $menuAry[$key] = $sub;
                }
            }else{
                if($finalVal = self::get_link($val)){
                    $menuAry[$key] = $finalVal;
                }
            }
        }
        return $menuAry;
    }

    private static function get_link($val){
        //check if external link
        if(preg_match('/https?:\/\//',$val) == 1){
            return $val;
        }else{
            if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
                $ds = '/';
            }else{
                $ds = '\\';
            }
            $uAry = explode($ds ,$val); //We have to use $ds instead of DS because in json file we are giving tools[/]first where as in windows DS will be [\]
             $controller_name = ucwords($uAry[0]);
            $action_name = (isset($uAry[1])) ? $uAry[1] : '';
            if (self::hasAccess($controller_name,$action_name)) {
                
                return PROJECT_ROOT . $val;
            }
            return false;
        }
    }
}