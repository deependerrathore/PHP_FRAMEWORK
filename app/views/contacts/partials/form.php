<?php
use Core\FH; 
?>
<form action="<?=$this->postAction?>" class="" method="post">
    <?=FH::csrfInput()?>
    <div><?=FH::displayErrors($this->displayErrors)?></div>
    <?=FH::inputBlock('text','First Name','fname',$this->contact->fname,'First Name',['class'=>'field is-5'],['class'=>'label'],['class'=>'input']);?>
    <?=FH::inputBlock('text','Last Name','lname',$this->contact->lname,'Last Name',['class'=>'field is-5'],['class'=>'label'],['class'=>'input is-5']);?>
    <?=FH::inputBlock('text','Email','email',$this->contact->email,'Email',['class'=>'field'],['class'=>'label'],['class'=>'input']);?>
    <?=FH::inputBlock('text','Address','address',$this->contact->address,'Address',['class'=>'field'],['class'=>'label'],['class'=>'input']);?>
    <?=FH::inputBlock('text','Address 2','address2',$this->contact->address2,'Address 2',['class'=>'field'],['class'=>'label'],['class'=>'input']);?>
    <?=FH::inputBlock('text','City','city',$this->contact->city,'City',['class'=>'field'],['class'=>'label'],['class'=>'input']);?>
    <?=FH::inputBlock('text','State','state',$this->contact->state,'State',['class'=>'field'],['class'=>'label'],['class'=>'input']);?>
    <?=FH::inputBlock('text','Zip','zip',$this->contact->zip,'Zip',['class'=>'field'],['class'=>'label'],['class'=>'input']);?>
    <?=FH::inputBlock('text','Cell Phone','cell_phone',$this->contact->cell_phone,'Cell Phone',['class'=>'field'],['class'=>'label'],['class'=>'input']);?>
    <?=FH::inputBlock('text','Home Phone','home_phone',$this->contact->home_phone,'Home Phone',['class'=>'field'],['class'=>'label'],['class'=>'input']);?>
    <?=FH::inputBlock('text','Work Phone','work_phone',$this->contact->work_phone,'Work Phone',['class'=>'field'],['class'=>'label'],['class'=>'input']);?>
    <a href="<?=PROJECT_ROOT?>contacts/" class="button">Cancel</a>
    <?= FH::submitTag('Save Contact',['class'=>'field is-grouped is-grouped-right'],['class'=>'control'],['class'=>'button is-primary'])?>
</form>