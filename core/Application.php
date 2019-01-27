<?php

namespace Core;
class Application{
    public function __construct(){
        $this->_set_reporting();
        $this->_unregister_globals();
    }

    private function _set_reporting(){
        if (DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors',1);
        }else{
            error_reporting(0);
            ini_set('display_errors',0);
            ini_set('log_errors',1);
            ini_set('error_log',ROOT . DS . 'temp' . DS . 'logs' . DS . 'error.log');
        }
    }

    /**
     * https://stackoverflow.com/questions/3593210/what-are-register-globals-in-php
     * register_globals- This feature has been DEPRECATED as of PHP 5.3.0 and REMOVED as of PHP 5.4.0.
     */
    private function _unregister_globals(){
        if (ini_get('register_globals')) {
            $globalsArray = ['_SESSION','_COOKIE','_ENV','_POST','_GET','_FILES','_SERVER','_REQUEST'];

            foreach($globalsArray as $g){
                foreach($GLOBALS[$g] as $key => $value){
                    if (isset($GLOBALS[$key])) {
                        if ($GLOBALS[$k] === $value) {
                            unset($GLOBALS[$k]);
                        } 
                    }
                    
                }
            }
        }
    }
}