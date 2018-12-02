<?php

class Home extends Controller{
    
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
    }
    public function indexAction(){
        $showTimeline = false;
        $followingPosts = '';
        if (currentUser()) {
            $db = DB::getInstance();
            $followingPosts = $db->query("SELECT posts.id,posts.postbody,posts.likes,users.fname,users.lname,users.username,posts.postimg FROM posts,followers,users
            WHERE posts.user_id = followers.user_id
            AND users.id = posts.user_id
            AND follower_id = ?
            ORDER BY posts.likes DESC",[currentUser()->id])->results();
            $showTimeline = true;
        }

        $this->view->showTimeline = $showTimeline;
        $this->view->followingPosts = $followingPosts;
        $this->view->displayErrors = '';
        $this->view->render('home/index.1');
    }

    
}