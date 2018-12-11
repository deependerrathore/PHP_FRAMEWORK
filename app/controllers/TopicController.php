<?php

class TopicController extends Controller{
    
    /**
    * constructor will instantiate the view from parent controller
    * load the model
    */
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->load_model('Posts'); //load the Posts model
        $this->view->setLayout('default');
    }

    public function indexAction(){

        $this->view->posts = $this->PostsModel->getPostsWithSpecificTopics($_GET['topic']);
        $this->view->render('topic/topic');
        

    }

}