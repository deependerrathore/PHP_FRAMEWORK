<?php

session_start();

define('DS', DIRECTORY_SEPARATOR); //Windows = \ , Linux,Mac = /
//define('ROOT',dirname(__FILE__)); //Path of the index file, C:\Dev&Test\www\PHP_FRAMEWORK\index.php
define('ROOT',__DIR__);

//break the URL into array using '/' 
$url = isset($_SERVER['PATH_INFO']) ? explode('/',ltrim($_SERVER['PATH_INFO'],'/')) : [];

require_once(ROOT . DS . 'core' . DS . 'bootstrap.php');

