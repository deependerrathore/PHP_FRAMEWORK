<?php

class Profile extends Controller{
    public function __construct($controller, $action){
        parent::__construct($controller,$action);
        $this->load_model('Followers');
        $this->load_model('Posts');
        $this->load_model('PostLikes');
        $this->view->setLayout('default');
    }

    public function userAction($params =''){

        $validation = new Validate();
    
        $post = new Posts();

        //creating user object for the current profile
        $searchedUser = new Users($params[0]);
        
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

                if (isset($_POST['post'])) {

                    $validation->check($_POST,[
                        'postbody' =>[
                            'display' => 'Post',
                            'required' => true,
                            'max'=>280
                        ]
                    ]);

                    if ($validation->passed()) {
                        $post->insertPost($_POST,currentUser());
                    }
                }
                
                
            }
            $this->view->isFollowing = $isFollowing;
            if ($post->getAllPost($searchedUserId)) {
                $this->view->posts = $post->getAllPost($searchedUserId);
            }else{
                $this->view->posts = false;
            }
            $this->view->displayErrors = $validation->displayErrors();
            $this->view->render('profile/profile');

        }else{
            $this->view->error = 'User not found';
            $this->view->render('profile/profileerror');
            die();
        }



    }

    public function likeAction($params = ''){
        if (count($params) == 3) {
            $userId = $params[0]; //userid
            $postId = $params[1]; //postid
            $redirectLike = $params[2];//redirect like
            $postLikes = new PostLikes();

            if ($_POST['like']) {
                //Insert like will insert the likes 
                $userId = $postLikes->insertLike($userId,$postId);
            }
            if ($_POST['unlike']) {
                //Delete will dislike the likes 
                $userId = $postLikes->deleteLike($userId,$postId);
            }
            $user = new Users((int)$userId);
            //redirecting to perticular user posts whose posts we have liked
            if ($redirectLike == 'home') {
                Router::redirect("");
            }else if ($redirectLike == 'profile') {
                Router::redirect("profile/user/{$user->username}");
            }
        }else{
            dnd("Invalid request");
            die();
        }
    }
}