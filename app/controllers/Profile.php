<?php

class Profile extends Controller{
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->view->setLayout('default');
    }

    public function userAction($params =''){
        //creating user object for the current profile
        $user = new Users($params);
        
        if ($user->id != '') {
            
            //assigning the $user to view so that we can use it
            $this->view->user = $user;

            //userid of the user we are trying to follow
            $userid = $user->id;

            //userid for the current logged in user
            $followerid = currentUser()->id;

            //creating a object of followermodel
            $db = DB::getInstance();

            //checking if follower is already following the user
            $checkForFollowing = $db->find('followers',[
                'conditions' => ['user_id = ?','follower_id = ?'],
                'bind' => [$userid,$followerid]
            ]);
            
            $isFollowing = false;

            if ($checkForFollowing) {
                $isFollowing = true;
            }
            if ($_POST) {
                
                if (isset($_POST['follow'])) {
                    if (!$checkForFollowing) {
                        $db->insert('followers',[
                            'user_id' => $userid,
                            'follower_id' => $followerid
                        ]);
                        $isFollowing = true;
                    }                
                }

                if (isset($_POST['unfollow'])) {
                    if ($checkForFollowing) {
                        $db->delete('followers',$checkForFollowing[0]->id);
                        $isFollowing = false;
                    } 
                }
                
                
            }
            $this->view->isFollowing = $isFollowing;
            $this->view->render('profile/profile');

        }else{
            $this->view->error = 'User not found';
            $this->view->render('profile/profileerror');
            die();
        }

    }
}