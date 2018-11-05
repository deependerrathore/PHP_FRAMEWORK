<?php

class Register extends Controller{
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->view->setLayout('default');
    }

    public function loginAction(){
        Session::uagent_no_version();
        $this->view->render('register/login');
    }
}
