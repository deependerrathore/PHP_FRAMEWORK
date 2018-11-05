<?php $this->setSiteTitle('Event Unacademy - Login');?>
<?php $this->start('head'); ?>
<?php $this->end();?>

<?php $this->start('body');?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="navbar-header">
        <a href="#" class="navbar-brand">Event Unacademy</a>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 well">
                <h3 class="text-center">Login To Your Account</h3>
                <p class="text-center">Get Unlimited tips,response questions<br/> free all the time</p>
                <form action="<?=PROJECT_ROOT?>register/login" class="login" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Your Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me" value="on">
                        <label class="form-check-label" for="remember_me">Remember Me</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                    <div class="text-right">
                        <a class="text-primary" href="<?=PROJECT_ROOT?>/register/register">If not registered click here?</a>
                    </div>
                </form>
        </div>
    </div>    
</div>
<?php $this->end();?>