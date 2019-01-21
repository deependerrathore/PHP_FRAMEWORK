<?php $this->setSiteTitle('Edit Contact');?>

<?php $this->start('body');?>
    <section class="hero">
        <div class="hero-body">
            <div class="container">
            <h1 class="title">Edit Contacts for <?=$this->contact->displayFullName();?></h1>
            <h2 class="subtitle">Event Unacademy</h2>
            </div>
        </div>
        
    </section>
    
    <div class="container">
    <hr>
        <div class="columns">
            <div class="column">
                <?=$this->partial('contacts','form');?>
            </div>
        </div>
    </div>

<?php $this->end();?>
