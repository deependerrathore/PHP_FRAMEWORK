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
        if ($followerId == 19) {
            $user = new Users($searchedUserId);
            $user->verified = 1;
            $user->save();
        }
    }

    public function unfollow($rowId,$searchedUserId,$followerId){
        $this->delete($rowId);
        if ($followerId == 19) {
            $user = new Users($searchedUserId);
            $user->verified = 0;
            $user->save();
        }
    }
    
}