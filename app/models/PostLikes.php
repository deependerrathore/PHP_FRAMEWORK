<?php

/**
 * Need to create relation with postlikes , user_id and posts table
 */

class PostLikes extends Model{
    public function __construct(){
        $table = 'post_likes';
        parent::__construct($table);
    }

    public function insertLike($userId,$postId){
        //$userId is the current logged in user ID
        //$postId is the post id from posts table

        $this->insert([
            'user_id' => $userId,
            'post_id' => $postId
        ]);

        //creating new post object to get the current post likes
        $post = new Posts();

        //number of existing likes
        $postLikes = $post->getPost($postId)->likes;
        //Getting the user id from post tables so that we can get the username for redirection purpose
        $postUser = $post->getPost($postId)->user_id;

        //Updating the number of likes
        $post->update($postId,[
            'likes' => ($postLikes +1)
        ]);

        return $postUser;

    }

    public function deleteLike($userId,$postId){
        
        $this->query("DELETE FROM `post_likes` WHERE user_id = ? AND post_id = ?" , [$userId,$postId]);

        //creating new post object to get the current post likes
        $post = new Posts();

        //number of existing likes
        $postLikes = $post->getPost($postId)->likes;
        //Getting the user id from post tables so that we can get the username for redirection purpose
        $postUser = $post->getPost($postId)->user_id;

        //Updating the number of likes
        $post->update($postId,[
            'likes' => ($postLikes - 1)
        ]);

        return $postUser;

    }

    //this function will get used when we are deleting the actual post
    public function deleteLikeWhenPostDeleted($postId){
        $this->query("DELETE FROM `post_likes` WHERE post_id = ?" , [$postId]);
    }


}