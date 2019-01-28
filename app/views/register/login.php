<?php 
use Core\FH;
?>
<?php $this->setSiteTitle('Event Unacademy - Login');?>
<?php $this->start('head'); ?>
<?php $this->end();?>

<?php $this->start('body');?>

<section class="section">
        <div class="container">
            <div class="columns">
                <div class="column"></div>
                <div class="column is-4">
                    <div>
                        <form role="form" method="POST" action="<?=$this->postAction?>">
                        <?=FH::csrfInput()?>
                            <p class="subtitle is-4 has-text-centered">
                               <strong>Sign in to your account</strong>
                            </p>
                            <div class="field">
                                <div class="control">
                                    <p class="control has-text-centered">
                                        Don't have an account yet?
                                        <a href="<?=PROJECT_ROOT?>register/register">Sign up here</a>
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
                            <?=FH::inputBlock('text','Username','username',$this->login->username,'Username',['class'=>'field is-5'],['class'=>'label'],['class'=>'input'],$this->displayErrors);?>

                            <?=FH::inputBlock('password','Password','password',$this->login->password,'Password',['class'=>'field is-5'],['class'=>'label'],['class'=>'input'],$this->displayErrors);?>

                            <div class="field">
                                <div class="control">
                                    <label class="checkbox">
                                    <input type="checkbox" value="on" name="remember_me" id="remember_me">
                                    Remember me
                                    </label>
                                </div>
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
                            <!-- <div class="field">
                                <div class="control">
                                    <p class="control">
                                    <?=FH::displayErrors($this->displayErrors); ?> 
                                    </p>
                                </div>
                            </div> -->
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