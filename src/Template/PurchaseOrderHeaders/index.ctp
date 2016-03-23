<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Purchase Order Header'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Order Details'), ['controller' => 'PurchaseOrderDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Order Detail'), ['controller' => 'PurchaseOrderDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseOrderHeaders index large-9 medium-8 columns content">
    <h3><?= __('Purchase Order Headers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('project_id') ?></th>
                <th><?= $this->Paginator->sort('supplier_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchaseOrderHeaders as $purchaseOrderHeader): ?>
            <tr>
                <td><?= $this->Number->format($purchaseOrderHeader->id) ?></td>
                <td><?= $purchaseOrderHeader->has('project') ? $this->Html->link($purchaseOrderHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $purchaseOrderHeader->project->id]) : '' ?></td>
                <td><?= $purchaseOrderHeader->has('supplier') ? $this->Html->link($purchaseOrderHeader->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $purchaseOrderHeader->supplier->id]) : '' ?></td>
                <td><?= h($purchaseOrderHeader->created) ?></td>
                <td><?= h($purchaseOrderHeader->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $purchaseOrderHeader->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $purchaseOrderHeader->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $purchaseOrderHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrderHeader->id)]) ?>
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
