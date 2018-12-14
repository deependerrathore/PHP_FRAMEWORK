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
    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
        <thead>
            <tr>
            <th><abbr title="Full name">Name</abbr></th>
            <th>Team</th>
            <th><abbr title="Email Address">Email</abbr></th>
            <th><abbr title="Work Phone Number">Work Phone</abbr></th>
            <th><abbr title="Cell Phone Number">Cell Phone</abbr></th>
            <th><abbr title="Home Phone Number">Home Phone</abbr></th>
            <th><abbr title="Eidt or Delete the contacts">Edit or Delete</abbr></th>


            </tr>
        </thead>
        <tfoot>
        <tr>
            <th><abbr title="Full name">Name</abbr></th>
            <th>Team</th>
            <th><abbr title="Email Address">Email</abbr></th>
            <th><abbr title="Work Phone Number">Work Phone</abbr></th>
            <th><abbr title="Cell Phone Number">Cell Phone</abbr></th>
            <th><abbr title="Home Phone Number">Home Phone</abbr></th>
            <th><abbr title="Eidt or Delete the contacts">Edit or Delete</abbr></th>

            </tr>
        </tfoot>
        <tbody>
        <?php foreach($this->contacts as $contact): ?>
            <tr>
            <th>1</th>
            <td><?=$contact->displayFullName()?></td>
            <td><?=$contact->email?></td>
            <td><?=$contact->work_phone?></td>
            <td><?=$contact->cell_phone?></td>
            <td><?=$contact->home_phone?></td>
            <td>edit | delete</td>
            </tr>
        </tbody>
        <?php endforeach; ?>

        </table>
    </section>
<?php $this->end(); ?>