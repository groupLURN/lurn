<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Equipment Project Inventory'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Equipment'), ['controller' => 'Equipment', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Equipment'), ['controller' => 'Equipment', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="equipmentProjectInventories index large-9 medium-8 columns content">
    <h3><?= __('Equipment Project Inventories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('equipment_id') ?></th>
                <th><?= $this->Paginator->sort('project_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipmentProjectInventories as $equipmentProjectInventory): ?>
            <tr>
                <td><?= $equipmentProjectInventory->has('equipment') ? $this->Html->link($equipmentProjectInventory->equipment->name, ['controller' => 'Equipment', 'action' => 'view', $equipmentProjectInventory->equipment->id]) : '' ?></td>
                <td><?= $equipmentProjectInventory->has('project') ? $this->Html->link($equipmentProjectInventory->project->title, ['controller' => 'Projects', 'action' => 'view', $equipmentProjectInventory->project->id]) : '' ?></td>
                <td><?= $this->Number->format($equipmentProjectInventory->quantity) ?></td>
                <td><?= h($equipmentProjectInventory->created) ?></td>
                <td><?= h($equipmentProjectInventory->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $equipmentProjectInventory->equipment_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $equipmentProjectInventory->equipment_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $equipmentProjectInventory->equipment_id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipmentProjectInventory->equipment_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
