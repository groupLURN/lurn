<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $materialsGeneralInventory->material_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $materialsGeneralInventory->material_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Materials General Inventories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Materials'), ['controller' => 'Materials', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Material'), ['controller' => 'Materials', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="materialsGeneralInventories form large-9 medium-8 columns content">
    <?= $this->Form->create($materialsGeneralInventory) ?>
    <fieldset>
        <legend><?= __('Edit Materials General Inventory') ?></legend>
        <?php
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
