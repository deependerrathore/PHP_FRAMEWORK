<?php 

//helper dnd function
function  dnd($data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function sanatize($dirtyValue){
    return htmlentities($dirtyValue,ENT_QUOTES,'UFT-8');
}

function currentUser(){
    return Users::currentLoggedInUser();
}