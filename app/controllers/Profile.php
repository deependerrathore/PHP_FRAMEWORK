<?php

class Profile extends Controller{
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->view->setLayout('default');
    }

    public function userAction($params){
        $user = new Users($params);
        if ($user->id != '') {
            $this->view->user = $user;
            if ($_POST) {
                //userid of the user we are trying to follow
                $userid = $user->id;

                //userid for the current logged in user
                $followerid = currentUser()->id;


                //creating a object of followermodel
                $follower = new Followers();
                
                //checking if follower is already following the user
                $checkForFollowing = $follower->find([
                    'conditions' => ['user_id = ?','follower_id = ?'],
                    'bind' => [$userid,$followerid]
                ]);
                
                if (!$checkForFollowing) {
                    $follower->insert([
                        'user_id' => $userid,
                        'follower_id' => $followerid
                    ]);
                }else{
                    $this->view->error = "You are already following {$user->fname}.";
                    $this->view->render('profile/profileerror');
                    die();

                }
                
            }
            $this->view->render('profile/profile');

        }else{
            $this->view->error = 'User not found';
            $this->view->render('profile/profileerror');
            die();
        }

    }
}