<?php 
use Core\DB;
use App\Models\Comments;
use App\Models\Users;
?>
<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('head'); //this will start the head output buffer and all of the centent before end() will be hold in this ob ?> 
<?php $this->end(); //cleans the ob?>

<?php $this->start('body'); ?>
<?php if ($this->showTimeline == true): ?>

    <?php 

        $db = DB::getInstance();
        $commentsObj = new Comments();

    ?>
    <section class="hero">
        <div class="hero-body">
            <div class="container">
            <h1 class="title">Welcome to your Timeline - <?=Users::currentUser()->fname?></h1>
            <h2 class="subtitle">Event Unacademy</h2>
            </div>
        </div>
    </section>
    <?php if(!empty($this->followingPosts)):?>
    <section class="section">
        <div class="container">
        <div class="columns">
                <div class="column is-8">

                <?php foreach($this->followingPosts as $post):?>
                <?php $comments = $commentsObj->getComments($post->id)->results();?>

                <article class="media">
                    <figure class="media-left">
                        <p class="image is-64x64">
                        <img src="<?=PROJECT_ROOT?>img/default_profile.jpg">
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="content">
                        <p>
                            <strong><?= $post->fname. ' ' . $post->lname?></strong> <small><a href="<?=PROJECT_ROOT?>profile/user/<?=$post->username?>">@<?=$post->username?></a></small>
                            <br>
                            <?=Posts::add_link($post->postbody)?>
                            <br>
                            <small><a>
                                <form action="<?=PROJECT_ROOT?>profile/like/<?=Users::currentUser()->id?>/<?=$post->id?>/home"  method="POST">
                                        <?php if ($db->query("SELECT id FROM post_likes WHERE user_id = ? AND post_id = ? " , [Users::currentUser()->id,$post->id])->count()): ?>
                                                    <input type="submit" name="unlike" value="Unlike">
                                                    <i class="fa fa-thumbs-up"></i>

                                        <?php else:?>
                                                    <input type="submit" name="like" value="Like">
                                                    <i class="fa fa-thumbs-o-up"></i>

                                        <?php endif;?>
                                            
                                </form>
                            </a> · <a><?=$post->likes?> likes</a> · 3 hrs</small>
                        </p>
                        </div>

                        
                        <?php if(!empty($comments)):?>
                            <?php foreach($comments as $comment):?>
                            <article class="media">
                                <figure class="media-left">
                                    <p class="image is-48x48">
                                    <img src="<?=PROJECT_ROOT?>img/default_profile.jpg">
                                    </p>
                                </figure>
                                <div class="media-content">
                                    <div class="content">
                                    <p>
                                        <strong><?=$comment->fname . ' ' . $comment->lname?></strong> <small><a href="<?=PROJECT_ROOT?>profile/user/<?=$comment->username?>">@<?=$comment->username?></a></small>
                                        <br>
                                        <?=$comment->commentbody ?>                                      
                                        <br>
                                        <small><a>likes
                                        </a> · <a><?=$post->likes?> likes</a> · 2 hrs</small>
                                    </p>
                                    </div>
                                </div>
                            </article>

                            <?php endforeach;?>
                        <?php endif;?>

                    </div>
                    </article>
                    <article class="media">
                    <figure class="media-left">
                        <p class="image is-64x64">
                        <img src="<?=PROJECT_ROOT?>img/default_profile.jpg">
                        </p>
                    </figure>
                    <div class="media-content">
                        <form action="<?=PROJECT_ROOT?>profile/comment/<?=Users::currentUser()->id?>/<?=$post->id?>/home" method="POST">
                            <!-- <div class="bg-danger">$this->displayErrors . "</div>"; -->
                            <div class="field">
                                <p class="control">
                                    <textarea class="textarea" rows="3" name="commentbody" placeholder="Add a comment..."></textarea>
                                </p>
                            </div>
                            <div class="field">
                                <p class="control">
                                    <button class="button" type="submit" name="comment">Post comment</button>
                                </p>
                            </div>
                        </form>
                        
                        
                    </div>
                    </article>

                    <!-- Need to add image part -->

                    
                <?php endforeach;?>
                
                </div>
                <div class="column">
                    <form action="<?=PROJECT_ROOT?>home/search" method="POST">
                        <div class="field is-grouped">
                            <p class="control is-expanded">
                                <input class="input" type="text" name="searchbox" placeholder="Want to find something...">
                            </p>
                            <p class="control">
                                <input class="button is-primary" type="submit" name="search" value="Search"/>
                            </p>
                        </div>
                        <!-- <input class="input is-rounded" type="search" name="searchbox" id="search" placeholder="Enter username or posts content"/>
                        <input class="button" type="submit" name="search" value="search"/> -->
                    </form>
                </div>
                <!-- <div class="column"></div> -->
    
        </div>
    </section>
    <?php else:?>
        <?php require_once(ROOT . DS . 'app' . DS . 'views' . DS .'register' . DS . 'newuser.php');?>
    <?php endif;?>

<?php else:?>
    <h1>Welcome to eventunacademy =login or sign up</h1>
<?php endif;?>

<?php $this->end(); ?>