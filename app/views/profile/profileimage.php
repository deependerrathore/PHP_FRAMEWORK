<?php $this->setSiteTitle('Profile');?>

<?php $this->start('head'); ?>
<?php $this->end();?>

<?php $this->start('body');?>
<h1>Upload Profile Image</h1>
<form action="<?=PROJECT_ROOT?>profile/profileimage" method="post" enctype="multipart/form-data">
    Upload a profile image:
    <input type="file" name="profileimg"/>
    <input type="submit" name="uploadprofileimg" value="Upload Iamge"/>
</form>

<?php $this->end();?>