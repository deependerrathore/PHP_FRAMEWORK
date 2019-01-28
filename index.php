<?php
use Core\Session;
use Core\Cookie;
use Core\Router;
use Core\H;
use App\Models\Users;
session_start();

define('DS', DIRECTORY_SEPARATOR); //Windows = \ , Linux,Mac = /
//define('ROOT',dirname(__FILE__)); //Path of the index file, C:\Dev&Test\www\PHP_FRAMEWORK\index.php
define('ROOT',__DIR__);

/**
 * Contains any client-provided pathname information trailing the actual script filename
 * but preceding the query string, if available. For instance, if the current script was
 * accessed via the URL http://www.example.com/php/path_info.php/some/stuff?foo=bar, 
 * then $_SERVER['PATH_INFO'] would contain /some/stuff.
 * @var $url
 * @return array return array in the form register/login then [0] - register [1] - login
 */
$url = isset($_SERVER['PATH_INFO']) ? explode('/',ltrim($_SERVER['PATH_INFO'],'/')) : [];

//Including core/config file
require_once(ROOT . DS . 'config' . DS . 'config.php');

/**
 * Autoloading as per PSR-4 standard
 *
 * @param class $className
 * @return void
 */
function autoload($className){
    $classArray = explode('\\',$className);
    $class = array_pop($classArray);
    $subPath = strtolower(implode(DS,$classArray));
    $path = ROOT . DS . $subPath . DS . $class . '.php';
    //H::dnd($path);
    if (file_exists($path)) {
        require_once($path);
    }
}

//autoloading function
spl_autoload_register('autoload');

/**
 * Check for existing session and cookie so that user can be automatically login
 */
if(!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
    Users::loginUserFromCookie();
}
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

// $contacts = $db->find('contacts',[
//     'conditions' => 'lname = ?',
//     'bind' => ['singh'],
//     'order' => "lname,fname",
//     'limit' => 5
// ]);

// $mod = new Model('contacts');
// $mod->find([
//     'conditions' => 'lname = ?',
//     'bind' => ['singh'],
//     'order' => "lname,fname",
//     'limit' => 5
// ]);
//dnd($contacts);
//dnd($db->get_columns('contacts'));


/**
 * @uses Router::route this method will handle all of the route request based upon provided $url
 */
Router::route($url);
