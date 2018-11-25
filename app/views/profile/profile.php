<?php $this->setSiteTitle('Profile');?>

<?php $this->start('head'); ?>
<?php $this->end();?>

<?php $this->start('body');?>

<h1><?=$this->user->fname?>'s Profile - <?=($this->user->verified == 1)? "Verified Account" : "Unverified Account"?></h1>

<?php if(currentUser()->id != $this->user->id){ ?>

<form action="<?=PROJECT_ROOT?>profile/user/<?=$this->user->username?>" method="POST">
    <?php
    if ($this->isFollowing) {
       echo  '<input type="submit" name="unfollow" value="Unfollow"/>';
    }else{
        echo '<input type="submit" name="follow" value="Follow"/>';
    } ?>
</form>
<?php }?>

<?php if(currentUser()->id == $this->user->id){ ?>
<form action="<?=PROJECT_ROOT?>profile/user/<?=$this->user->username?>/posts" method="POST">
    <div class="bg-danger"><?=$this->displayErrors?></div>
    <textarea name="postbody" rows="5" cols="80"></textarea>
    <input type="submit" value="Post" name="post"/>

</form>
<?php } ?>
<div class="posts">
   <?php
    if ($this->posts) {
        $postString = "";
        foreach($this->posts as $post){ 
            $postString = $post->postbody . '<br>';
            $postString .= "<form action=".PROJECT_ROOT."profile/like/".currentUser()->id."/".$post->id ." method=\"POST\">";
            $postString .=  "<input type=\"submit\" name=\"like\" value=\"Like\">";
            $postString .= "<hr>";
            $postString .= "</form>";
            echo $postString;
        }
    }
   ?>
</div>
<?php $this->end();?>