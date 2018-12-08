<?php $this->setSiteTitle('Notification'); ?>

<?php $this->start('head'); ?> 
<?php $this->end();?>

<?php $this->start('body'); ?>
    <div id="app">
        <ul>
            <li v-for="notification in notifications">
                {{notification}}
            </li>
        </ul>
    </div>
<?php $this->end();?>