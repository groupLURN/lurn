<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($project) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Add Project') ?></h3></legend>
            <?php

            echo $this->Form->input('title', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);
            echo $this->Form->input('description', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('client_id', [
                'options' => $clients,
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('project_manager_id', [
                'options' => $employees,
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('start_date', [
                'type' => 'text',
                'class' => 'form-control datetime-picker',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('end_date', [
                'type' => 'text',
                'class' => 'form-control datetime-picker',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('project_status_id', [
                'options' => $projectStatuses,
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
</div>
<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Statuses'), ['controller' => 'ProjectStatuses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Status'), ['controller' => 'ProjectStatuses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projects form large-9 medium-8 columns content">
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend><?= __('Add Project') ?></legend>
        <?php
            echo $this->Form->input('client_id', ['options' => $clients]);
            echo $this->Form->input('project_manager_id', ['options' => $employees]);
            echo $this->Form->input('project_status_id', ['options' => $projectStatuses]);
            echo $this->Form->input('title');
            echo $this->Form->input('description');
            echo $this->Form->input('start_date');
            echo $this->Form->input('end_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
-->