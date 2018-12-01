<?php

define('DEBUG',true);
define('DEFAULT_CONTROLLER', 'Home'); // default controller if there isn't any contoller in url

define('DEFAULT_LAYOUT','bulma'); // if no layout has ben set in contoller then use this layout

define('PROJECT_ROOT','/PHP_FRAMEWORK/');// set this to '/' for live server
define('SITE_TITLE','MVC_FRAMEWORK'); ////this will be used if no site title will be used

define('DB_NAME','social');
define('DB_USER','root');
define('DB_PASSWORD','root');
define('DB_HOST','127.0.0.1');

define('CURRENT_USER_SESSION_NAME','eAfjsdklf93fdl84dfdslsdnsqAdklls');//Session name for the logged in user

define('REMEMBER_ME_COOKIE_NAME','cookienameflsjdflsjdumfswr3434dfmsdfmfdsmf');//cooke name for logged in user remember me

define('REMEMBER_ME_COOKIE_NAME_SECONDARY','cookienameflsjdflsjdumfswr3434dfmsdfmfdsmf_');//cooke name for logged in user remember me

define('REMEMBER_ME_COOKIE_EXPIRY',604800); // time in seconds for memeber me cookie,expiry 7days

define('REMEMBER_ME_COOKIE_EXPIRY_SECONDARY',60 * 60 * 24 * 3);

define('ACCESS_RESTRICTED','Restricted'); //controller name for the restricted redirect

define('MENU_BRAND','EVENTUNACADEMY');
