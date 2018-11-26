<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('head'); //this will start the head output buffer and all of the centent before end() will be hold in this ob ?> 
<?php $this->end(); //cleans the ob?>

<?php $this->start('body'); ?>
<?php 
if ($this->showTimeline == true) {
    echo '<h1 class="text-center blue">Welcome to your timeline</h1>';
    //dnd($this->followingPosts);
    foreach($this->followingPosts as $post){
        echo '<p>' .$post->postbody . '  ~ '. $post->username. '  :'. $post->likes . ' likes</p><hr>';
    }
}else{
    echo '<h1 class="text-center blue">Welcome to this MVC framework</h1>';
}?>
<?php $this->end(); ?>