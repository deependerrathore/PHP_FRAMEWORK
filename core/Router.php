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
    }

}