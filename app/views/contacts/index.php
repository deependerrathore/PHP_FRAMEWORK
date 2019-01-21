<?php $this->setSiteTitle('Contacts'); ?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
    <section class="hero">
        <div class="hero-body">
            <div class="container">
            <h1 class="title">My Contacts</h1>
            <h2 class="subtitle">Event Unacademy</h2>
            </div>
        </div>
    </section>
    <section class="container">
    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-hoverable">
        <thead>
            <tr>
            <th>S.No</th>
            <th><abbr title="Full name">Name</abbr></th>
            <th><abbr title="Email Address">Email</abbr></th>
            <th><abbr title="Work Phone Number">Work Phone</abbr></th>
            <th><abbr title="Cell Phone Number">Cell Phone</abbr></th>
            <th><abbr title="Home Phone Number">Home Phone</abbr></th>
            <th><abbr title="Eidt or Delete the contacts">Edit or Delete</abbr></th>


            </tr>
        </thead>
        <tfoot>
        <tr>
            <th>S.No</th>
            <th><abbr title="Full name">Name</abbr></th>
            <th><abbr title="Email Address">Email</abbr></th>
            <th><abbr title="Work Phone Number">Work Phone</abbr></th>
            <th><abbr title="Cell Phone Number">Cell Phone</abbr></th>
            <th><abbr title="Home Phone Number">Home Phone</abbr></th>
            <th><abbr title="Eidt or Delete the contacts">Edit or Delete</abbr></th>

            </tr>
        </tfoot>
        <tbody>
        <?php $id = 1;?>
        <?php foreach($this->contacts as $contact):?>
            <tr>
            <th><?=$id++?></th>
            <td><a href="<?=PROJECT_ROOT?>contacts/details/<?=$contact->id?>"><?=$contact->displayFullName()?></a></td>
            <td><?=$contact->email?></td>
            <td><?=$contact->work_phone?></td>
            <td><?=$contact->cell_phone?></td>
            <td><?=$contact->home_phone?></td>
            <td>  
            <a class="button is-warning is-small" href="<?=PROJECT_ROOT?>contacts/edit/<?=$contact->id?>"><span><i class="fa fa-edit" aria-hidden="true"></i></span> Edit</a>
            | 
            <a class="button is-danger is-small" onclick="if(!confirm('Are you sure?')){return false;}" href="<?=PROJECT_ROOT?>contacts/delete/<?=$contact->id?>"><span><i class="fa fa-trash" aria-hidden="true"></i></span> Delete</a>
            </td>
            </tr>
        </tbody>
        <?php endforeach; ?>

        </table>
    </section>
<?php $this->end(); ?>