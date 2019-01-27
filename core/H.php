<?php 

namespace Core;
class H{
    
    //helper dnd function
    public static function  dnd($data){
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }
    
    public static function currentPage(){
        $currentPage = $_SERVER['REQUEST_URI'];
        if($currentPage == PROJECT_ROOT || $currentPage == PROJECT_ROOT.'home/index'){
            $currentPage = PROJECT_ROOT . 'home';
        }
        return $currentPage;
    } 
    
    public static function getObjectProperties($obj){
        return get_object_vars($obj);
    }
}