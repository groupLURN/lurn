<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Materials Project Inventory'), ['action' => 'edit', $materialsProjectInventory->material_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Materials Project Inventory'), ['action' => 'delete', $materialsProjectInventory->material_id], ['confirm' => __('Are you sure you want to delete # {0}?', $materialsProjectInventory->material_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Materials Project Inventories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materials Project Inventory'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Materials'), ['controller' => 'Materials', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Material'), ['controller' => 'Materials', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="materialsProjectInventories view large-9 medium-8 columns content">
    <h3><?= h($materialsProjectInventory->material_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Material') ?></th>
            <td><?= $materialsProjectInventory->has('material') ? $this->Html->link($materialsProjectInventory->material->name, ['controller' => 'Materials', 'action' => 'view', $materialsProjectInventory->material->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Project') ?></th>
            <td><?= $materialsProjectInventory->has('project') ? $this->Html->link($materialsProjectInventory->project->title, ['controller' => 'Projects', 'action' => 'view', $materialsProjectInventory->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($materialsProjectInventory->quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($materialsProjectInventory->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($materialsProjectInventory->modified) ?></td>
        </tr>
    </table>
</div>
