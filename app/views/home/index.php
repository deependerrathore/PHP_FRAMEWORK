<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('head'); //this will start the head output buffer and all of the centent before end() will be hold in this ob ?> 
<?php $this->end(); //cleans the ob?>

<?php $this->start('body'); ?>
<h1 class="text-center blue">Welcome to this MVC framework</h1>
<?php $this->end(); ?>