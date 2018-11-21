<?php

class Profile extends Controller{
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->view->setLayout('default');
    }

    public function userAction($params =''){
        //creating user object for the current profile
        $searchedUser = new Users($params);
        
        if ($searchedUser->id != '') {
            
            //assigning the $user to view so that we can use it
            $this->view->user = $searchedUser;

            //userid of the user we are trying to follow
            $searchedUserId = $searchedUser->id;

            //userid for the current logged in user
            $followerid = currentUser()->id;

            //creating a object of followermodel
            $db = DB::getInstance();

            //checking if follower is already following the user
            //this will return false if no row found otherwise it will return array with data
            $isFollowing = $followerData = $db->find('followers',[
                'conditions' => ['user_id = ?','follower_id = ?'],
                'bind' => [$searchedUserId,$followerid]
            ]);

            //empty($isFollowing) is true when $isFollowing is false
            //empty($isFollowing) is false when $isFollowing is true i.e. $isfollowing contains array from above query
            if (!empty($isFollowing)) {
                $isFollowing = true;
            }
            if ($_POST) {
                
                if (isset($_POST['follow'])) {
                    if (empty($isFollowing)) {
                        $db->insert('followers',[
                            'user_id' => $searchedUserId,
                            'follower_id' => $followerid
                        ]);
                        $isFollowing = true;
                    }                
                }

                if (isset($_POST['unfollow'])) {
                    if (!empty($isFollowing)) {
                        $db->delete('followers',$followerData[0]->id);
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