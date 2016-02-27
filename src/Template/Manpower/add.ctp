<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($manpower) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Add Manpower') ?></h3></legend>
            <?php

            echo $this->Form->input('manpower_type_id', [
                'options' => $manpowerTypes,
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
        <li><?= $this->Html->link(__('List Manpower'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Manpower Types'), ['controller' => 'ManpowerTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Manpower Type'), ['controller' => 'ManpowerTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="manpower form large-9 medium-8 columns content">
    <?= $this->Form->create($manpower) ?>
    <fieldset>
        <legend><?= __('Add Manpower') ?></legend>
        <?php
            echo $this->Form->input('manpower_type_id', ['options' => $manpowerTypes]);
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
-->