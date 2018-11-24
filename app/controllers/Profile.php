<?php

class Profile extends Controller{
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->load_model('Followers');
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
            $followerId = currentUser()->id;

            //creating a object of followermodel
            $db = DB::getInstance();

            //checking if follower is already following the user
            //this will return false if no row found otherwise it will return array with data
            $isFollowing = $followerData = $db->find('followers',[
                'conditions' => ['user_id = ?','follower_id = ?'],
                'bind' => [$searchedUserId,$followerId]
            ]);

            //empty($isFollowing) is true when $isFollowing is false
            //empty($isFollowing) is false when $isFollowing is true i.e. $isfollowing contains array from above query
            if (!empty($isFollowing)) {
                $isFollowing = true;
            }

            if ($_POST) {
                
                if (isset($_POST['follow'])) {

                    //checking if following is not following the searcheduser and if empty we will insert the follow
                    if (empty($isFollowing)) {
                        $this->FollowersModel->follow($searchedUserId,$followerId);
                        $isFollowing = true;
                    }                
                }

                if (isset($_POST['unfollow'])) {
                    //checking if $isfollowing is not empty then we will delete the row
                    if (!empty($isFollowing)) {
                        $this->FollowersModel->unfollow($followerData[0]->id,$searchedUserId,$followerId);
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