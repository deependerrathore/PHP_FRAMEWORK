<?php $this->setSiteTitle($this->contact->displayFullName());?>

<?php $this->start('body');?>
    <a href="<?=PROJECT_ROOT?>contacts" class="button">Back</a>
    <h1 class="has-text-centered is-size-2"><?=$this->contact->displayFullName()?> </h1>
    <div class="columns">
        <div class="column">
        </div>
        <div class="column">
            <p><span class="has-text-weight-bold">Email : </span> <?=$this->contact->email?></p>
            <p><span class="has-text-weight-bold">Cell phone : </span> <?=$this->contact->cell_phone?></p>
            <p><span class="has-text-weight-bold">Home phone : </span> <?=$this->contact->home_phone?></p>
            <p><span class="has-text-weight-bold">Work phone : </span> <?=$this->contact->work_phone?></p>
            <p><span>Email : </span> <?=$this->contact->email?></p>
        </div>
        <div class="column">
           <?=$this->contact->displayAddressLabel();?>
        </div>
        <div class="column">
        </div>
        
    <div>
<?php $this->end();?>