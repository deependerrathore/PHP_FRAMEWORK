<?php $this->setSiteTitle('Event Unacademy - Forgot password');?>
<?php $this->start('head')?>
<?php $this->end(); ?>

<?php $this->start('body');?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 well">
                <h3 class="text-center">Forgot Password</h3>
                <p class="text-center">Get Unlimited tips,response questions<br/> free all the time</p>
                <form action="<?=PROJECT_ROOT?>register/forgotpassword" class="login" method="POST">
                    <div class="bg-danger"><?=$this->displayErrors?></div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Email Address">
                    </div>
                    <button type="submit" class="btn btn-primary">Send Reset Password Link</button>
                </form>
        </div>
    </div>    
</div>

<?php $this->end();?>