<?php

class Followers extends Model{
    public function __construct(){
        $table = 'followers';
        parent::__construct($table);
    }

    public function follow($searchedUserId , $followerId){
        $this->insert([
            'user_id' => $searchedUserId,
            'follower_id' => $followerId
        ]);
    }

    public function unfollow($rowId){
        $this->delete($rowId);
    }
}