<?php $this->setSiteTitle('Event Unacademy - Register');?>
<?php $this->start('head'); ?>
<?php $this->end();?>

<?php $this->start('body');?>
<section class="section">
    <div class="container">
        <div class="columns">
                <div class="column"></div>
                <div class="column is-4">
                    <form role="form" method="POST" action="<?=PROJECT_ROOT?>register/register">
                    <?=FH::csrfInput()?>
                            <p class="subtitle is-4 has-text-centered">
                               <strong>Register for an account</strong>
                            </p>
                            <div class="field">
                                <div class="control">
                                    <p class="control has-text-centered">
                                        Already have an account?
                                        <a href="<?=PROJECT_ROOT?>register/login">Login here</a>
                                    </p>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">First Name</label>
                                <p class="control">
                                    <input class="input  is-medium" type="text" name="fname" id="fname" value="<?=$this->post['fname'];?>" placeholder="Your First Name">                                 
                                </p>
                            </div>
                            <div class="field">
                                <label class="label">Last Name</label>
                                <p class="control">
                                    <input class="input  is-medium" type="text" name="lname" id="lname" value="<?=$this->post['lname'];?>" placeholder="Your Last name">                                 
                                </p>
                            </div>
                            <div class="field">
                                <label class="label">Your Email</label>
                                <p class="control">
                                    <input class="input  is-medium" type="email" name="email" id="email" value="<?=$this->post['email'];?>" placeholder="Your Email">                                 
                                </p>
                            </div>
                            <div class="field">
                                <label class="label">Username</label>
                                <p class="control">
                                    <input class="input  is-medium" type="text" name="username" id="username" value="<?=$this->post['username'];?>" placeholder="Your Username">                                 
                                </p>
                            </div>
                            <div class="field">
                                <label class="label">Password</label>
                                <p class="control">
                                    <input class="input  is-medium" type="password" name="password" id="password" value="<?=$this->post['password'];?>" placeholder="Enter Password">                                 
                                </p>
                            </div>
                            <div class="field">
                                <label class="label">Confirm Password</label>
                                <p class="control">
                                    <input class="input  is-medium" type="password" name="confirm" id="confirm" value="<?=$this->post['confirm'];?>" placeholder="Confirm Password">                                 
                                </p>
                            </div>
                            
                            <div class="field">
                                <div class="control">
                                    <p class="control">
                                        <button type="submit" name="register" class="button is-primary is-fullwidth is-medium">
                                            <strong>Register</strong>
                                        </button>
                                    </p>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <p class="control">
                                    <?=$this->displayErrors?> 
                                    </p>
                                </div>
                            </div>
                            
                    </div>
                    <div class="column"></div>

                </div>
        </div>
        <!-- <div class="row">
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
        </div>     -->
    </div>
</section>

<?php $this->end();?>