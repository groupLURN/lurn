<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($client) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Edit Client') ?></h3></legend>
            <?php

            echo $this->Form->input('company_name', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);
            echo $this->Form->input('key_person', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);
            echo $this->Form->input('contact_number', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);
            echo $this->Form->input('email', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);
            echo $this->Form->input('address', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);
            ?>

            <legend class="mt"><h3><i class="fa fa-angle-right"></i> <?= __('Change password') ?></h3></legend>
            <?php

            echo $this->Form->input('user.username', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ],
                'disabled' => true
            ]);

            echo $this->Form->input('user.password', [
                'class' => 'form-control required',
                'label' => [
                    'class' => 'mt'
                ],
                'required' => true,
                'text' => 'New Password'
            ]);

            ?>
        </fieldset>

        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>

<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $client->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $client->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clients form large-9 medium-8 columns content">
    <?= $this->Form->create($client) ?>
    <fieldset>
        <legend><?= __('Edit Client') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('company_name');
            echo $this->Form->input('key_person');
            echo $this->Form->input('contact_number');
            echo $this->Form->input('email');
            echo $this->Form->input('address');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
-->