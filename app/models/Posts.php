<?php

/**
 * Need to create relation with post table
 */

class Posts extends Model{
    public function __construct(){
        $table = 'posts';
        parent::__construct($table);
    }

    public function insertPost($params,$file,$currentUser){
        $this->assign($params);
        $this->posted_at = $date = date('Y-m-d H:i:s');
        $this->user_id = $currentUser->id;
        $this->likes = 0;
        if (!empty($file)) {
            $this->postimg = Image::uploadImage($file,'postimg');
        }
        $this->save();
    }

    public function getAllPost($userid){
        return $this->find([
            'conditions' => 'user_id = ?',
            'bind' => [$userid],
            'order' => 'posted_at DESC'
        ]);
    }

    public function getPost($postId){
        return $this->findFirst([
            'conditions' =>'id = ?',
            'bind' => [$postId]
        ]);
    }
}