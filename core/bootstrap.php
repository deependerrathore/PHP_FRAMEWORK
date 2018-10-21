<?php

//Including core/config file
require_once(ROOT . DS . 'config' . DS . 'config.php');

//Including app/libs/helpers/functions.php  
require_once(ROOT . DS . 'app' . DS . 'libs' . DS . 'helpers' . DS . 'functions.php');

//Autoload the class from controllers, modals and core folder
function autoload($className){
    if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
    }else if(file_exists(ROOT . DS . 'core' . DS . $className . DS . '.php')){
        require_once(ROOT . DS . 'core' . DS . $className . DS . '.php');
    }else if(file_exists(ROOT . DS . 'app' . DS . 'modals' . DS . $className . '.php')){
        require_once(ROOT . DS . 'app' . DS . 'modals' . DS . $className . '.php');
    }
}

spl_autoload_register('autoload');