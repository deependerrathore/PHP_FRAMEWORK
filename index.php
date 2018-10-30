<?php

session_start();

define('DS', DIRECTORY_SEPARATOR); //Windows = \ , Linux,Mac = /
//define('ROOT',dirname(__FILE__)); //Path of the index file, C:\Dev&Test\www\PHP_FRAMEWORK\index.php
define('ROOT',__DIR__);

//break the URL into array using '/' 
$url = isset($_SERVER['PATH_INFO']) ? explode('/',ltrim($_SERVER['PATH_INFO'],'/')) : [];

//Including core/config file
require_once(ROOT . DS . 'config' . DS . 'config.php');

//Including app/libs/helpers/functions.php  
require_once(ROOT . DS . 'app' . DS . 'libs' . DS . 'helpers' . DS . 'functions.php');

//Autoload the class from controllers, modals and core folder
function autoload($className){

    if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
    }elseif(file_exists(ROOT . DS . 'core' . DS . $className . '.php')){
        require_once(ROOT . DS . 'core' . DS . $className . '.php');
    }elseif(file_exists(ROOT . DS . 'app' . DS . 'modals' . DS . $className . '.php')){
        require_once(ROOT . DS . 'app' . DS . 'modals' . DS . $className . '.php');
    }
}

spl_autoload_register('autoload');

$db = DB::getInstance();
// $fields = [
//     'fname' => 'Onkar',
//     'lname' => 'Rathore',
//     'email' => 'onkar@onkar.com'
// ];
//$sql = 'SELECT * FROM contacts';
//$db->query($sql,[12]); 
//$contacts = $db->insert('contacts',$fields);
//dnd($db->get_columns('contacts')); //working
//dnd($db->lastID());//working
//dnd($db->results());//working
//dnd($db->count());//working
//dnd($db->first()); //working

//$db->update('contacts',8,$fields);
//$db->delete('contacts',6);

$contacts = $db->findFirst('contacts',[
    'conditions' => 'lname = ?',
    'bind' => ['singh'],
    'order' => "lname,fname",
    'limit' => 5
]);

//dnd($contacts);
dnd($db->get_columns('contacts'));
Router::route($url);
