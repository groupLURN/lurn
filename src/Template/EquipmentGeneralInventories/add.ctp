<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Equipment General Inventories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Equipment'), ['controller' => 'Equipment', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Equipment'), ['controller' => 'Equipment', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="equipmentGeneralInventories form large-9 medium-8 columns content">
    <?= $this->Form->create($equipmentGeneralInventory) ?>
    <fieldset>
        <legend><?= __('Add Equipment General Inventory') ?></legend>
        <?php
            echo $this->Form->input('equipment_id', ['options' => $equipment]);
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
