<?= $this->assign('title', 'Purchase Order') ?>
<h4 align="center">Purchase Order</h4>
<table class="purchase-order text-left">
    <tr>
        <th style="width: 150px;"><?= __('Supplier Name') ?></th>
        <td class="border-bottom"><?= ': '.$purchaseOrderHeader->supplier->name?></td>
        <th style="width: 150px;"><?= __('P.O. No.') ?></th>
        <td class="border-bottom" style="width: 150px;"><?= h($purchaseOrderHeader->number) ?></td>
    </tr>
    <tr>
        <th style="width: 150px;"><?= __('Representative') ?></th>
        <td class="border-bottom"><?= ':'?></td>
        <th style="width: 150px;"><?= __('Date') ?></th>
        <td class="border-bottom" style="width: 150px;"><?= h(date_format($purchaseOrderHeader->created, 'd-M-y')) ?></td>
    </tr>
    <tr>
        <th style="width: 150px;"><?= __('Address') ?></th>
        <td class="border-bottom"><?= ': '.$purchaseOrderHeader->supplier->address?></td>
        <th style="width: 150px;"><?= __('Terms') ?></th>
        <td class="border-bottom" style="width: 150px;"></td>
    </tr>
    <tr>
        <th style="width: 150px;"><?= __('Contact No') ?></th>
        <td class="border-bottom"><?= ': '.h($purchaseOrderHeader->supplier->contact_number) ?></td>
        <th style="width: 150px;"></th>
        <td style="width: 150px;"></td>
    </tr>
</table>

<table class="purchase-order text-left">
    <tr>
        <th style="width: 150px;"><?= __('Delivery Details') ?></th>
        <td class="border-bottom">:</td>
        <th></th>
        <td></td>
    </tr>
    <tr>
        <th style="width: 150px;"></th>
        <td class="border-bottom"></td>
        <th></th>
        <td></td>
    </tr>
    <tr>
        <th style="width: 150px;"></th>
        <td class="border-bottom"></td>
        <th></th>
        <td></td>
    </tr>
    <tr>
        <th style="width: 150px;"></th>
        <td></td>
        <th></th>
        <td></td>
    </tr>
</table>

<?php if (!empty($purchaseOrderHeader->purchase_order_details)): ?>
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