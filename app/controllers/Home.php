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
            $followingPosts = $db->query("SELECT posts.id,posts.postbody,posts.likes,users.username FROM posts,followers,users
            WHERE posts.user_id = followers.user_id
            AND users.id = posts.user_id
            AND follower_id = ?
            ORDER BY posts.likes DESC",[currentUser()->id])->results();
            $showTimeline = true;
        }

        $this->view->showTimeline = $showTimeline;
        $this->view->followingPosts = $followingPosts;
        $this->view->displayErrors = '';
        $this->view->render('home/index');
    }

    public function commentAction($params = ''){
        $validation = new Validate();
        $comment = new Comments();
        if (count($params) == 3) {

            $userId = $params[0]; //userid
            $postId = $params[1]; //postid
            $redirectLike = $params[2];//redirect like


            if (isset($_POST['comment'])) {
                
                $validation->check($_POST,[
                    'commentbody' =>[
                        'display' => 'Comment',
                        'required' => true,
                        'max'=>280
                    ]
                ]);
    
                if ($validation->passed()) {
                    $comment->insertComment($_POST,$userId,$postId);     
                }else{
                    dnd("Comment body cannot be empty");//this needs to be fixed                
                }
                
                if ($redirectLike == 'home') {
                    Router::redirect("");
                }else if ($redirectLike == 'profile') {
                    Router::redirect("profile/user/{$user->username}");
                }
                
    
            }
        }else{
            dnd("Invalid number of arugument");
        }
    }
}