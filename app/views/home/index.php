<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('head'); //this will start the head output buffer and all of the centent before end() will be hold in this ob ?> 
<?php $this->end(); //cleans the ob?>

<?php $this->start('body'); ?>
<?php 
if ($this->showTimeline == true) {
    $db = DB::getInstance();
    $commentsObj = new Comments();
    echo '<h1 class="text-center blue">Welcome to your timeline</h1>';
    //dnd($this->followingPosts);
    foreach($this->followingPosts as $post){
        $postString = '<p>' .Posts::add_link($post->postbody) . '  ~ '. $post->username. '</p>';

        if ($post->postimg != null) {
            $postString .= "<img src=" .$post->postimg . "/>";
            $postString .= "<br>";
            $postString .= "<br>";
        }
        
        $postString .= "<form action=".PROJECT_ROOT."profile/like/".Users::currentUser()->id."/".$post->id."/home"."  method=\"POST\">";
        if ($db->query("SELECT id FROM post_likes WHERE user_id = ? AND post_id = ? " , [Users::currentUser()->id,$post->id])->count()) {
            $postString .=  "<input type=\"submit\" name=\"unlike\" value=\"Unlike\">";
        }else{
            $postString .=  "<input type=\"submit\" name=\"like\" value=\"Like\">";
        }
        $postString .= ' ' . $post->likes . ' likes';
        $postString .= "</form>";
        $postString .= "<br>";

        //this is the comment section 
        $postString .= "<form action=".PROJECT_ROOT."profile/comment/".Users::currentUser()->id."/".$post->id."/home". " method=\"POST\">";
        $postString .= "<div class=\"bg-danger\">" . $this->displayErrors . "</div>";
        $postString .= "<textarea name=\"commentbody\" rows=\"3\" cols=\"80\"></textarea>";
        $postString .=  "<input type=\"submit\" value=\"Comment\" name=\"comment\"/>";
        $postString .=  "</form>";
        
        $comments = $commentsObj->getComments($post->id)->results();
        if (!empty($comments)) {
            foreach($comments as $comment){
                $postString .= $comment->commentbody. ' ~ ' . $comment->username ; 
                $postString .= "<br>";
            }
        }
        $postString .= "<hr>";

        echo $postString;
    }
}else{
    echo '<h1 class="text-center blue">Welcome to this MVC framework</h1>';
}?>
<?php $this->end(); ?>