<?php $this->setSiteTitle('Event Unacademy - Register');?>
<?php $this->start('head'); ?>
<?php $this->end();?>

<?php $this->start('body');?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 well">
                <h3 class="text-center">Register To Your Account</h3>
                <p class="text-center">Get Unlimited tips,response questions<br/> free all the time</p>
                <form action="<?=PROJECT_ROOT?>register/register" class="form" method="POST">
                    <div class="bg-danger"><?=$this->displayErrors?></div>
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" value="<?=$this->post['fname'];?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" value="<?=$this->post['lname'];?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="<?=$this->post['email'];?>"  class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="username">Choose a Username</label>
                        <input type="text" name="username" id="username" value="<?=$this->post['username'];?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="password">Choose a Password</label>
                        <input type="password" name="password" id="password" value="<?=$this->post['password'];?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="confirm">Confirm  Password</label>
                        <input type="password" name="confirm" id="confirm" value="<?=$this->post['confirm'];?>" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                    <div class="text-right">
                        <a class="text-primary" href="<?=PROJECT_ROOT?>/register/login">Already have account? Login from here.</a>
                    </div>
                </form>
        </div>
    </div>    
</div>
<?php $this->end();?>