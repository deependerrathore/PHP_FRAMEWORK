<?php $this->setSiteTitle('Tools Index Page'); ?>
 
<?php $this->start('head'); ?>

<?php $this->end();?>

<?php $this->start('body'); ?>
<h1 class="text-center blue"> This is the tools index page</h1>
<?= inputBlock('text','Username','Username','','Username',['class'=>'field'],['class'=>'label'],['class'=>'input is-primary'])?>

<?= submitTag('Register',['class'=>'field is-grouped is-grouped-right'],['class'=>'control'],['class'=>'button']);?>
<?php $this->end(); ?>