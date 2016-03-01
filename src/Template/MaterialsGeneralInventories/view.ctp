<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Materials General Inventory'), ['action' => 'edit', $materialsGeneralInventory->material_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Materials General Inventory'), ['action' => 'delete', $materialsGeneralInventory->material_id], ['confirm' => __('Are you sure you want to delete # {0}?', $materialsGeneralInventory->material_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Materials General Inventories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materials General Inventory'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Materials'), ['controller' => 'Materials', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Material'), ['controller' => 'Materials', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="materialsGeneralInventories view large-9 medium-8 columns content">
    <h3><?= h($materialsGeneralInventory->material_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Material') ?></th>
            <td><?= $materialsGeneralInventory->has('material') ? $this->Html->link($materialsGeneralInventory->material->name, ['controller' => 'Materials', 'action' => 'view', $materialsGeneralInventory->material->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($materialsGeneralInventory->quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($materialsGeneralInventory->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($materialsGeneralInventory->modified) ?></td>
        </tr>
    </table>
</div>
