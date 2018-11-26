<?php

/**
 * Need to create relation with post table
 */

class Comments extends Model{
    public function __construct(){
        $table = 'comments';
        parent::__construct($table);
    }

    public function insertComment($params,$userId,$postId){
        if($this->findById($postId)){
            $this->assign($params);
            $this->posted_at = $date = date('Y-m-d H:i:s');
            $this->user_id = $userId;
            $this->post_id = $postId;
            $this->save();
        }else{
            return false; //if post don't exists
        }
        
    }
}