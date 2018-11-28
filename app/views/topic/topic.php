<?php $this->setSiteTitle('Topics');?>

<?php $this->start('head'); ?>
<?php $this->end();?>

<?php $this->start('body');?>
<?php
    $postString = "";

    $postString = "</br>";
    $postString = "</br>";
    foreach($this->posts as $post){
        echo($post->postbody) . "<hr>";
    }
?>
<?php $this->end();?>