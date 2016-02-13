<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($employee) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Add Employee') ?></h3></legend>
            <?php

            echo $this->Form->input('employee_type_id', [
                'options' => $employeeTypes,
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);
            echo $this->Form->input('name', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);
            echo $this->Form->input('employment_date', [
                'year' => [
                    'class' => 'form-control margin-left',
                    'style' => 'width: initial; display: initial;'
                ],
                'month' => [
                    'class' => 'form-control margin-left',
                    'style' => 'width: initial; display: initial;'
                ],
                'day' => [
                    'class' => 'form-control margin-left',
                    'style' => 'width: initial; display: initial;'
                ],
                'label' => [
                    'class' => 'mt'
                ],
                'hour' => false,
                'minute' => false,
                'meridian' => false
            ]);
            echo $this->Form->input('termination_date', [
                'empty' => true,
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ],
                'year' => [
                    'class' => 'form-control margin-left',
                    'style' => 'width: initial; display: initial;'
                ],
                'month' => [
                    'class' => 'form-control margin-left',
                    'style' => 'width: initial; display: initial;'
                ],
                'day' => [
                    'class' => 'form-control margin-left',
                    'style' => 'width: initial; display: initial;'
                ],
                'hour' => false,
                'minute' => false,
                'meridian' => false
            ]);
            ?>

            <legend class="mt"><h3><i class="fa fa-angle-right"></i> <?= __('New User Account') ?></h3></legend>
            <?php

            echo $this->Form->input('username', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ],
                'required' => true
            ]);

            echo $this->Form->input('password', [
                'class' => 'form-control required',
                'label' => [
                    'class' => 'mt'
                ],
                'required' => true
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
        <li><?= $this->Html->link(__('List Employees'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employee Types'), ['controller' => 'EmployeeTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee Type'), ['controller' => 'EmployeeTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employees form large-9 medium-8 columns content">
    <?= $this->Form->create($employee) ?>
    <fieldset>
        <legend><?= __('Add Employee') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('employee_type_id', ['options' => $employeeTypes]);
            echo $this->Form->input('name');
            echo $this->Form->input('employment_date');
            echo $this->Form->input('termination_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
