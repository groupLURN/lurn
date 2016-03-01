<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Equipment Project Inventory'), ['action' => 'edit', $equipmentProjectInventory->equipment_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Equipment Project Inventory'), ['action' => 'delete', $equipmentProjectInventory->equipment_id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipmentProjectInventory->equipment_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Equipment Project Inventories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Equipment Project Inventory'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Equipment'), ['controller' => 'Equipment', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Equipment'), ['controller' => 'Equipment', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="equipmentProjectInventories view large-9 medium-8 columns content">
    <h3><?= h($equipmentProjectInventory->equipment_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Equipment') ?></th>
            <td><?= $equipmentProjectInventory->has('equipment') ? $this->Html->link($equipmentProjectInventory->equipment->name, ['controller' => 'Equipment', 'action' => 'view', $equipmentProjectInventory->equipment->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Project') ?></th>
            <td><?= $equipmentProjectInventory->has('project') ? $this->Html->link($equipmentProjectInventory->project->title, ['controller' => 'Projects', 'action' => 'view', $equipmentProjectInventory->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($equipmentProjectInventory->quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($equipmentProjectInventory->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($equipmentProjectInventory->modified) ?></td>
        </tr>
    </table>
</div>
