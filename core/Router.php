<?php

class Router{

    public static function route($url){//$url is defined in index.php
        //controller
        $controller = (!empty($url) && $url[0] != '') ? ucfirst($url[0]) : DEFAULT_CONTROLLER;//DEFAULT_CONTROLLER @config/config.php
        $controller_name = $controller;
        array_shift($url);

        //actions
        $action = (!empty($url) && $url[0] != '') ? lcfirst($url[0]) . 'Action' : 'indexAction';
        $action_name = $action;
        array_shift($url);

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

}