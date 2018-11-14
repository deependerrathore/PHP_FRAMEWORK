<?php 

//helper dnd function
function  dnd($data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function sanatize($dirtyValue){
    return htmlentities($dirtyValue,ENT_QUOTES,'UTF-8');
}

function currentUser(){
    return Users::currentLoggedInUser();
}

function posted_values($post){
    $clean_ary = [];
    foreach($post as $key => $value){
        $clean_ary[$key] = sanatize($value);
    }

    return $clean_ary;
}

function currentPage(){
    $currentPage = $_SERVER['REQUEST_URI'];
    if($currentPage == PROJECT_ROOT || $currentPage == PROJECT_ROOT.'home/index'){
        $currentPage = PROJECT_ROOT . 'home';
    }
    return $currentPage;
} 