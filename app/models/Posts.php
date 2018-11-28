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
        if ($file['postimg']['error'] == 0) {
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

    public static function add_link($text){
        $text  = explode(" ",$text);
        $newString = "";
        foreach($text as $word){
            if(substr($word,0,1) == '@'){
                $user = new Users(ltrim($word,'@'));
                if ($user->id) {
                    $newString .= "<a href=".PROJECT_ROOT. "profile/user/". $user->username  . ">" . $word . "</a>" . " ";
                }else{
                    $newString .= $word . " "; 
                }
            }else{
                $newString .= $word . " ";
            }
        }
        return $newString;
    }
}