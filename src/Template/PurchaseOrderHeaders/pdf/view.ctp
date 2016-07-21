<?= $this->assign('title', 'Purchase Order') ?>
<h1 align="center">Purchase Order Form</h1>
<table>
    <tr>
        <th><?= __('Purchase Order Number') ?></th>
        <td><?= h($purchaseOrderHeader->number) ?></td>
    </tr>
    <?php if($purchaseOrderHeader->has('project')) : ?>
    <tr>
        <th><?= __('Project') ?></th>
        <td><?= $purchaseOrderHeader->project->title?></td>
    </tr>
    <?php endif; ?>
    <tr>
        <th><?= __('Supplier') ?></th>
        <td><?= $purchaseOrderHeader->supplier->name?></td>
    </tr>
    <tr>
        <th><?= __('Supplier Address') ?></th>
        <td><?= $purchaseOrderHeader->supplier->address?></td>
    </tr>
    <tr>
        <th><?= __('Date Requested') ?></th>
        <td><?= h($purchaseOrderHeader->created) ?></td>
    </tr>
</table>

<?php if (!empty($purchaseOrderHeader->purchase_order_details)): ?>
<h1 align="center"><?= __('Purchase Order Details') ?></h1>
<table cellspacing="0" class="table table-striped">
    <tr>
        <th><?= __('Materials') ?></th>
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