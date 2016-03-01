<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Materials Project Inventory'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materials'), ['controller' => 'Materials', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Material'), ['controller' => 'Materials', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="materialsProjectInventories index large-9 medium-8 columns content">
    <h3><?= __('Materials Project Inventories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('material_id') ?></th>
                <th><?= $this->Paginator->sort('project_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materialsProjectInventories as $materialsProjectInventory): ?>
            <tr>
                <td><?= $materialsProjectInventory->has('material') ? $this->Html->link($materialsProjectInventory->material->name, ['controller' => 'Materials', 'action' => 'view', $materialsProjectInventory->material->id]) : '' ?></td>
                <td><?= $materialsProjectInventory->has('project') ? $this->Html->link($materialsProjectInventory->project->title, ['controller' => 'Projects', 'action' => 'view', $materialsProjectInventory->project->id]) : '' ?></td>
                <td><?= $this->Number->format($materialsProjectInventory->quantity) ?></td>
                <td><?= h($materialsProjectInventory->created) ?></td>
                <td><?= h($materialsProjectInventory->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $materialsProjectInventory->material_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $materialsProjectInventory->material_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $materialsProjectInventory->material_id], ['confirm' => __('Are you sure you want to delete # {0}?', $materialsProjectInventory->material_id)]) ?>
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
