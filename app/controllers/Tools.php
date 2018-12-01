<?php 

class Tools extends Controller{
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
    }

    public function indexAction($params = []){
        $this->view->render('tools/index');
    }

    public function firstAction(){
        $this->view->render('tools/first');
    }
}