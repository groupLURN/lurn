<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Equipment General Inventory'), ['action' => 'edit', $equipmentGeneralInventory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Equipment General Inventory'), ['action' => 'delete', $equipmentGeneralInventory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipmentGeneralInventory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Equipment General Inventories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Equipment General Inventory'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Equipment'), ['controller' => 'Equipment', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Equipment'), ['controller' => 'Equipment', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="equipmentGeneralInventories view large-9 medium-8 columns content">
    <h3><?= h($equipmentGeneralInventory->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Equipment') ?></th>
            <td><?= $equipmentGeneralInventory->has('equipment') ? $this->Html->link($equipmentGeneralInventory->equipment->name, ['controller' => 'Equipment', 'action' => 'view', $equipmentGeneralInventory->equipment->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($equipmentGeneralInventory->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($equipmentGeneralInventory->quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($equipmentGeneralInventory->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($equipmentGeneralInventory->modified) ?></td>
        </tr>
    </table>
</div>
