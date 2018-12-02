<?php $this->setSiteTitle('Profile');?>

<?php $this->start('head'); ?>
<?php $this->end();?>

<?php $this->start('body');?>

<section class="hero">
  <div class="hero-body">
    <div class="container">
      <h1 class="title"><?=$this->user->fname?>'s Profile </h1>
      <h2 class="subtitle"><?=($this->user->verified == 1)? "Verified Account" : "Unverified Account"?></h2>
        <?php if(currentUser()->id != $this->user->id): ?>
            <form action="<?=PROJECT_ROOT?>profile/user/<?=$this->user->username?>" method="POST">
                <?php if ($this->isFollowing):?> 
                    <input type="submit" name="unfollow" value="Unfollow" class="button"/>
                <?php else:?>
                    <input type="submit" name="follow" value="Follow" class="button"/>
                <?php endif;?>
            </form>
        <?php endif;?>
    </div>
  </div>


    <?php if(currentUser()->id == $this->user->id):?>
        <div class="container">
            <div class="columns">
                <div class="column is-8">
                    <form action="<?=PROJECT_ROOT?>profile/user/<?=$this->user->username?>" method="POST" enctype="multipart/form-data">
                        <div class="bg-danger"><?=$this->displayErrors?></div>        

                        <div class="field">
                            <div class="control">
                                <textarea class="textarea" rows=3 name="postbody" placeholder="What's in your mind!!!!"></textarea>
                            </div>
                        </div>
                    
                        <div class="field is-grouped is-grouped-left">
                            <div class="control">
                            <div class="field">
                                <div class="file is-primary">
                                    <label class="file-label">
                                    <input class="file-input" type="file" name="postimg">
                                    <span class="file-cta">
                                        <span class="file-icon">
                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                        </span>
                                        <span class="file-label">
                                        Upload Image
                                        </span>
                                    </span>
                                    </label>
                                </div>
                                </div>
                            </div>

                            <div class="control">
                                <button type="submit" name="post" class="button is-primary">Post</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="column"></div>
                <div class="column"></div>
            </div>
        </div>
    <?php endif; ?>

</section>




<!--Container to display all of the post-->
<section class="section">
    <div class="container">
    <?php $db = DB::getInstance();?>
        <?php if($this->posts):?>
        <div class="columns">
            <div class="column is-8">
                <!--Start - Looping through all of the posts-->
                <?php foreach($this->posts as $post):?>
                    <article class="media">
                        <figure class="media-left">
                            <p class="image is-64x64">
                            <img src="<?=PROJECT_ROOT?>img/default_profile.jpg">
                            </p>
                        </figure>
                        <div class="media-content">
                            <div class="content">
                            <p>
                                <strong><?=currentUser()->fname .' ' . currentUser()->lname?></strong> <small>@<?=currentUser()->username?></small> <small><?=$post->posted_at?></small>
                                <br>
                                <?=Posts::add_link($post->postbody);?>
                            </p>
                            <?php if ($post->postimg != null):?>
                                <figure class="image">
                                    <img src="<?=$post->postimg?>">
                                </figure>
                            <?php endif;?>
                            </div>
                            <nav class="level is-mobile">
                            <div class="level-left">
                                <a class="level-item">
                                    <form action="<?=PROJECT_ROOT?>profile/like/<?=currentUser()->id?>/<?=$post->id?>/profile" method="POST">
                                        <?php if ($db->query("SELECT id FROM post_likes WHERE user_id = ? AND post_id = ? " , [currentUser()->id,$post->id])->count()):?>
                                            <input type="submit" name="unlike" value="Unlike">
                                            <i class="fa fa-thumbs-up"></i>
                                        <?php else: ?>
                                            <input type="submit" name="like" value="Like">
                                            <i class="fa fa-thumbs-o-up"></i>
                                        <?php endif;?>
                                    </form>
                                </a>
                                <p class="level-item">
                                <span class="is-small"><?=$post->likes?> likes</span>
                                </p>
                            </div>
                            </nav>
                        </div>
                        <div class="media-right">
                            <form action="<?=PROJECT_ROOT?>profile/delete/<?=currentUser()->id?>/<?=$post->id?>/profile" method="POST">
                                <button type="submit" name="deletepost" class="delete">
                            </form>
                        </div>
                    </article>
                <?php endforeach;?>
                <!--End - Looping through all of the posts-->
            </div>
            <div class="column"></div>
            <div class="column"></div>

        </div>
            

        <?php endif;?>
    </div>
</section>
<?php $this->end();?>