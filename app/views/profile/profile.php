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
<form action="<?=PROJECT_ROOT?>profile/user/<?=$this->user->username?>" method="POST" enctype="multipart/form-data">
    <div class="bg-danger"><?=$this->displayErrors?></div>
    <textarea name="postbody" rows="5" cols="80"></textarea><br>
    Upload a post image:
    <input type="file" name="postimg"/>
    <input type="submit" value="Post" name="post"/>

</form>
<br>
<?php } ?>
<div class="posts">
   <?php
    if ($this->posts) {
        $db = DB::getInstance();
        $postString = "";
        foreach($this->posts as $post){ 
            $postString = $post->postbody;

            $postString .= "<br>";
            $postString .= "<br>";

            if ($post->postimg != null) {
                $postString .= "<img src=" .$post->postimg . "/>";

            }

            $postString .= "<br>";
            $postString .= "<br>";

            //form for like dislike button
            $postString .= "<form action=".PROJECT_ROOT."profile/like/".currentUser()->id."/".$post->id ."/profile"." method=\"POST\">";

            //like and unlike
            if ($db->query("SELECT id FROM post_likes WHERE user_id = ? AND post_id = ? " , [currentUser()->id,$post->id])->count()) {
                $postString .=  "<input type=\"submit\" name=\"unlike\" value=\"Unlike\">";
            }else{
                $postString .=  "<input type=\"submit\" name=\"like\" value=\"Like\">";
            }
            //likes count
            $postString .= '<span> ' . $post->likes . ' likes</span>';
            $postString .= "<hr>";

            //form end
            $postString .= "</form>";

            echo $postString;
        }
    }
   ?>
</div>
<?php $this->end();?>