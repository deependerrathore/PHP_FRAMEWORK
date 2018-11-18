<?php $this->setSiteTitle('Event Unacademy - Change password');?>
<?php $this->start('head')?>
<?php $this->end(); ?>

<?php $this->start('body');?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 well">
                <h3 class="text-center">Change Password</h3>
                <p class="text-center">Get Unlimited tips,response questions<br/> free all the time</p>
                <form action="<?=PROJECT_ROOT?>register/changepassword" class="login" method="POST">
                    <div class="bg-danger"><?=$this->displayErrors?></div>

                    <div class="form-group">
                        <label for="oldpassword">Old Password</label>
                        <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Enter Your Old Password">
                    </div>
                    <div class="form-group">
                        <label for="newpassword">New Password</label>
                        <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <label for="confirmnewpassword">Password</label>
                        <input type="password" class="form-control" id="confirmnewpassword" name="confirmnewpassword" placeholder="Confirm New Password">
                    </div>

                    <button type="submit" class="btn btn-primary">Change Password</button>
                    
                </form>
        </div>
    </div>    
</div>

<?php $this->end();?>