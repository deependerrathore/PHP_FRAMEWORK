<?php

class Router{

    public static function route($url){//$url is defined in index.php
        $controller = (!empty($url) && $url[0] != '') ? ucfirst($url[0]) : DEFAULT_CONTROLLER;//DEFAULT_CONTROLLER @config/config.php
        $controller_name = $controller;
        array_shift($url);
    }

}