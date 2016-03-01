<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Materials Project Inventory') ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($materialsProjectInventory) ?>
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
                ['action' => 'delete', $materialsProjectInventory->material_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $materialsProjectInventory->material_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Materials Project Inventories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Materials'), ['controller' => 'Materials', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Material'), ['controller' => 'Materials', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="materialsProjectInventories form large-9 medium-8 columns content">
    <?= $this->Form->create($materialsProjectInventory) ?>
    <fieldset>
        <legend><?= __('Edit Materials Project Inventory') ?></legend>
        <?php
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
-->