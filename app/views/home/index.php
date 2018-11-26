<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('head'); //this will start the head output buffer and all of the centent before end() will be hold in this ob ?> 
<?php $this->end(); //cleans the ob?>

<?php $this->start('body'); ?>
<?php 
if ($this->showTimeline == true) {
    $db = DB::getInstance();
    echo '<h1 class="text-center blue">Welcome to your timeline</h1>';
    //dnd($this->followingPosts);
    foreach($this->followingPosts as $post){
        $postString = '<p>' .$post->postbody . '  ~ '. $post->username. '  :'. $post->likes . ' likes</p>';
        $postString .= "<form action=".PROJECT_ROOT."profile/like/".currentUser()->id."/".$post->id."/home"."  method=\"POST\">";
        if ($db->query("SELECT id FROM post_likes WHERE user_id = ? AND post_id = ? " , [currentUser()->id,$post->id])->count()) {
            $postString .=  "<input type=\"submit\" name=\"unlike\" value=\"Unlike\">";
        }else{
            $postString .=  "<input type=\"submit\" name=\"like\" value=\"Like\">";
        }
        $postString .= "</form>";
        $postString .= "<hr>";
        echo $postString;
    }
}else{
    echo '<h1 class="text-center blue">Welcome to this MVC framework</h1>';
}?>
<?php $this->end(); ?>