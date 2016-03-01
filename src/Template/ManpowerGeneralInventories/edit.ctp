<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($equipmentGeneralInventory) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Adjust Inventory') ?></h3></legend>
            <?php

            echo $this->Form->input('quantity', [
                'type' => 'text',
                'class' => 'form-control number-only',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Available Quantity'
                ],
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
                ['action' => 'delete', $equipmentGeneralInventory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $equipmentGeneralInventory->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Equipment General Inventories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Equipment'), ['controller' => 'Equipment', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Equipment'), ['controller' => 'Equipment', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="equipmentGeneralInventories form large-9 medium-8 columns content">
    <?= $this->Form->create($equipmentGeneralInventory) ?>
    <fieldset>
        <legend><?= __('Edit Equipment General Inventory') ?></legend>
        <?php
            echo $this->Form->input('equipment_id', ['options' => $equipment]);
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
-->