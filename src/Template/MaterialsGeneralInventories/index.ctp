<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Materials General Inventory'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materials'), ['controller' => 'Materials', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Material'), ['controller' => 'Materials', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="materialsGeneralInventories index large-9 medium-8 columns content">
    <h3><?= __('Materials General Inventories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('material_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materialsGeneralInventories as $materialsGeneralInventory): ?>
            <tr>
                <td><?= $materialsGeneralInventory->has('material') ? $this->Html->link($materialsGeneralInventory->material->name, ['controller' => 'Materials', 'action' => 'view', $materialsGeneralInventory->material->id]) : '' ?></td>
                <td><?= $this->Number->format($materialsGeneralInventory->quantity) ?></td>
                <td><?= h($materialsGeneralInventory->created) ?></td>
                <td><?= h($materialsGeneralInventory->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $materialsGeneralInventory->material_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $materialsGeneralInventory->material_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $materialsGeneralInventory->material_id], ['confirm' => __('Are you sure you want to delete # {0}?', $materialsGeneralInventory->material_id)]) ?>
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
