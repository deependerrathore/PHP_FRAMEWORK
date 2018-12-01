<?php $this->setSiteTitle('Event Unacademy - Login');?>
<?php $this->start('head'); ?>
<?php $this->end();?>

<?php $this->start('body');?>

<!-- <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 well">
                <h3 class="text-center">Login To Your Account</h3>
                <p class="text-center">Get Unlimited tips,response questions<br/> free all the time</p>
                <form action="<?=PROJECT_ROOT?>register/login" class="login" method="POST">
                    <div class="bg-danger"><?=$this->displayErrors?></div>

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
</div> -->

<section class="section">
        <div class="container">
            <div class="columns">
                <div class="column"></div>
                <div class="column is-4">
                    <div>
                        <form role="form" method="POST" action="<?=PROJECT_ROOT?>register/login">
                            <p class="subtitle is-4 has-text-centered">
                               <strong>Sign in to your account</strong>
                            </p>
                            <div class="field">
                                <div class="control">
                                    <p class="control has-text-centered">
                                        Don't have an account yet?
                                        <a href="<?=PROJECT_ROOT?>/register/register">Sign up here</a>
                                    </p>
                                </div>
                            </div>
                            <!-- <div class="field">
                                <p class="control">
                                    <a class="button is-dark is-medium is-fullwidth" href="/auth/github">
                                        <span class="icon" >
                                            <i class="fa fa-github"></i>
                                        </span>
                                        <span><strong>Log in with Github</strong></span>
                                    </a>
                                </p>
                            </div>
                            <div class="is-divider" data-content="OR LOG IN WITH"></div> -->
                            <div class="field">
                                <p class="control">
                                    <input class="input  is-medium" type="text"
                                           name="username" value="" placeholder="Your Username"
                                           >                                 </p>
                            </div>
                        <div class="field">
                                <p class="control">
                                    <input class="input  is-medium"
                                           type="password" name="password" placeholder="Your Password">
                                                                    </p>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <p class="control">
                                        <button type="submit" name="singin" class="button is-primary is-fullwidth is-medium">
                                            <strong>Sign in</strong>
                                        </button>
                                    </p>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <p class="control has-text-centered">
                                        <a href="<?=PROJECT_ROOT?>/register/forgotpassword">
                                            Forgot password?
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="column"></div>
            </div>

        </div>
    </section>
<?php $this->end();?>