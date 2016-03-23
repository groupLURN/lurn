<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Purchase Order Header'), ['action' => 'edit', $purchaseOrderHeader->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Purchase Order Header'), ['action' => 'delete', $purchaseOrderHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrderHeader->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Order Headers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order Header'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Order Details'), ['controller' => 'PurchaseOrderDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order Detail'), ['controller' => 'PurchaseOrderDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="purchaseOrderHeaders view large-9 medium-8 columns content">
    <h3><?= h($purchaseOrderHeader->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Project') ?></th>
            <td><?= $purchaseOrderHeader->has('project') ? $this->Html->link($purchaseOrderHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $purchaseOrderHeader->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Supplier') ?></th>
            <td><?= $purchaseOrderHeader->has('supplier') ? $this->Html->link($purchaseOrderHeader->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $purchaseOrderHeader->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($purchaseOrderHeader->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($purchaseOrderHeader->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($purchaseOrderHeader->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Purchase Order Details') ?></h4>
        <?php if (!empty($purchaseOrderHeader->purchase_order_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Purchase Order Header Id') ?></th>
                <th><?= __('Material Id') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($purchaseOrderHeader->purchase_order_details as $purchaseOrderDetails): ?>
            <tr>
                <td><?= h($purchaseOrderDetails->id) ?></td>
                <td><?= h($purchaseOrderDetails->purchase_order_header_id) ?></td>
                <td><?= h($purchaseOrderDetails->material_id) ?></td>
                <td><?= h($purchaseOrderDetails->quantity) ?></td>
                <td><?= h($purchaseOrderDetails->created) ?></td>
                <td><?= h($purchaseOrderDetails->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseOrderDetails', 'action' => 'view', $purchaseOrderDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseOrderDetails', 'action' => 'edit', $purchaseOrderDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseOrderDetails', 'action' => 'delete', $purchaseOrderDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrderDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
