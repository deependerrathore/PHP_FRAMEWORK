<?php
use Core\FH;
?>
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
                                    <?=FH::inputBlock('text','First Name','fname',$this->newUser->fname,'Your First Name',['class'=>'field is-5'],['class'=>'label'],['class'=>'input'],$this->displayErrors);?>
                                    <?=FH::inputBlock('text','Last Name','lname',$this->newUser->lname,' Your Last Name',['class'=>'field is-5'],['class'=>'label'],['class'=>'input'],$this->displayErrors);?>
                                    <?=FH::inputBlock('email','Email Address','email',$this->newUser->email,'Your Email Address',['class'=>'field is-5'],['class'=>'label'],['class'=>'input'],$this->displayErrors);?>
                                    <?=FH::inputBlock('text','Username','username',$this->newUser->username,'Username',['class'=>'field is-5'],['class'=>'label'],['class'=>'input'],$this->displayErrors);?>
                                    <?=FH::inputBlock('password','Password','password',$this->newUser->password,'Choose Password',['class'=>'field is-5'],['class'=>'label'],['class'=>'input'],$this->displayErrors);?>
                                    <?=FH::inputBlock('password','Confirm Password','confirm',$this->newUser->getConfirm(),'Confirm Password',['class'=>'field is-5'],['class'=>'label'],['class'=>'input'],$this->displayErrors);?>
                                    <?= FH::submitTag('Register',['class'=>'field is-grouped is-grouped-right'],['class'=>'control'],['class'=>'button is-primary'])?>

                                    <!-- <div class="field">
                                        <div class="control">
                                            <p class="control">
                                            <?= FH::displayErrors($this->displayErrors);?> 
                                            </p>
                                        </div>
                                    </div> -->
                    </form>
                </div>
                <div class="column"></div>
        </div>
    </div>
</section>

<?php $this->end();?>