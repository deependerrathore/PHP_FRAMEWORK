<?php $this->setSiteTitle('Profile');?>

<?php $this->start('head'); ?>
<?php $this->end();?>

<?php $this->start('body');?>

<h1><?=$this->user->fname?>'s Profile</h1>

<form action="<?=PROJECT_ROOT?>profile/user/<?=$this->user->username?>" method="POST">
    <input type="submit" <?php if(currentUser()->id == $this->user->id) echo "hidden"; ?> name="follow" value="Follow"/>
</form>
<?php $this->end();?>