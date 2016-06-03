<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
        echo $this->Form->input('user_type_id', [
            'options' => $userTypes,
            'disabled' => true,
            'class' => 'form-control',
            'label' => [
                'class' => 'mt'
            ]
            ]);
        echo $this->Form->input('username', [
            'class' => 'form-control',
            'label' => [
                'class' => 'mt'
            ]
        ]);

        echo $this->Form->input('current password', [
        class' => 'form-control',
            'label' => [
                'class' => 'mt'
            ]
        ]);
        ?>
        echo $this->Form->input('password', [
            'class' => 'form-control',
            'label' => [
                'class' => 'mt'
            ]
        ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), [
        'class' => 'btn btn-primary btn-submit'
    ]) ?>
    <?= $this->Form->end() ?>
</div>

<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List User Types'), ['controller' => 'UserTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Type'), ['controller' => 'UserTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->input('user_type_id', ['options' => $userTypes]);
            echo $this->Form->input('username');
            echo $this->Form->input('password');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
-->