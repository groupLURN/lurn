<?= $this->assign('title', 'Purchase Order') ?>
<div class="purchaseOrderHeaders view large-9 medium-8 columns content">
    <h3><?= 'Purchase Order Number ' . h($purchaseOrderHeader->number) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Purchase Order Number') ?></th>
            <td><?= h($purchaseOrderHeader->number) ?></td>
        </tr>
        <tr>
            <th><?= __('Project') ?></th>
            <td><?= $purchaseOrderHeader->has('project') ? $this->Html->link($purchaseOrderHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $purchaseOrderHeader->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Supplier') ?></th>
            <td><?= $purchaseOrderHeader->has('supplier') ? $this->Html->link($purchaseOrderHeader->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $purchaseOrderHeader->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Date Ordered') ?></th>
            <td><?= h($purchaseOrderHeader->created) ?></td>
        </tr>
    </table>
    <div class="related">
        <?php if (!empty($purchaseOrderHeader->purchase_order_details)): ?>
            <h4><?= __('Purchase Order Details') ?></h4>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= __('Material Name') ?></th>
                <th><?= __('Unit Measure') ?></th>
                <th><?= __('Quantity') ?></th>
            </tr>
            <?php foreach ($purchaseOrderHeader->purchase_order_details as $purchaseOrderDetails): ?>
            <tr>
                <td><?= h($purchaseOrderDetails->material->name) ?></td>
                <td><?= h($purchaseOrderDetails->material->unit_measure) ?></td>
                <td><?= h($purchaseOrderDetails->quantity) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
