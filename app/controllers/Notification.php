<?php

class Notification extends Controller{
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->load_model('Notifications');
        $this->view->setLayout('default');
    }

    public function indexAction(){
        $notifications = $this->NotificationsModel->find([
            'conditions' => ['receiver = ?'],
            'bind' => [currentUser()->id]
        ]);

        //$notifications = $this->NotificationsModel->find();
        foreach($notifications as $n){
            
            if ($n->type == '1') {
                    $sender = new Users((int)$n->sender);
                    $extra = json_decode($n->extra);
                    echo $sender->username . " mentioned you in a post! - " . $extra->postbody . "<hr>";
                
            }
        }
    }

}