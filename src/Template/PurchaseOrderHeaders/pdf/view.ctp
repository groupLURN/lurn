<?= $this->assign('title', 'Purchase Order') ?>
<h4 align="center">Purchase Order</h4>
<table class="purchase-order text-left">
    <tr>
        <th style="width: 150px;"><?= __('Supplier Name') ?></th>
        <td class="border-bottom"><?= ': '.$purchaseOrderHeader->supplier->name?></td>
        <th style="width: 150px;">&nbsp;<?= __('P.O. No.') ?></th>
        <td class="border-bottom" style="width: 150px;"><?= h($purchaseOrderHeader->number) ?></td>
    </tr>
    <tr>
        <th style="width: 150px;"><?= __('Representative') ?></th>
        <td class="border-bottom"><?= ':'?></td>
        <th style="width: 150px;">&nbsp;<?= __('Date') ?></th>
        <td class="border-bottom" style="width: 150px;"><?= h(date_format($purchaseOrderHeader->created, 'd-M-y')) ?></td>
    </tr>
    <tr>
        <th style="width: 150px;"><?= __('Address') ?></th>
        <td class="border-bottom"><?= ': '.$purchaseOrderHeader->supplier->address?></td>
        <th style="width: 150px;">&nbsp;<?= __('Terms') ?></th>
        <td class="border-bottom" style="width: 150px;"></td>
    </tr>
    <tr>
        <th style="width: 150px;"><?= __('Contact No') ?></th>
        <td class="border-bottom"><?= ': '.h($purchaseOrderHeader->supplier->contact_number) ?></td>
        <th style="width: 150px;"></th>
        <td style="width: 150px;"></td>
    </tr>
</table>
<br>
<table class="purchase-order text-left">
    <tr>
        <th style="width: 150px;"><?= __('Delivery Details') ?></th>
        <td class="border-bottom">:</td>
        <th></th>
        <td></td>
    </tr>
    <tr>
        <th style="width: 150px;">&nbsp;</th>
        <td class="border-bottom">&nbsp;</td>
        <th></th>
        <td></td>
    </tr>
    <tr>
        <th style="width: 150px;">&nbsp;</th>
        <td class="border-bottom">&nbsp;</td>
        <th></th>
        <td></td>
    </tr>
    <tr>
        <th style="width: 150px;">&nbsp;</th>
        <td>&nbsp;</td>
        <th></th>
        <td></td>
    </tr>
</table>
<?php if (!empty($purchaseOrderHeader->purchase_order_details)): ?>
<table cellspacing="0" class="purchase-order-details text-center">
    <tr>
        <th style="width: 120px;"><?= __('Item No') ?></th>
        <th style="width: 70px;"><?= __('Quantity') ?></th>
        <th style="width: 70px;"><?= __('Unit') ?></th>
        <th><?= __('Description') ?></th>
        <th style="width: 130px;"><?= __('Unit Price (in Php)') ?></th>
        <th style="width: 100px;"><?= __('Amount (in Php)') ?></th>
    </tr>
    <?php foreach ($purchaseOrderHeader->purchase_order_details as $purchaseOrderDetails): ?>
    <tr>
        <td><?= h($purchaseOrderDetails->material->id) ?></td>
        <td><?= h($purchaseOrderDetails->quantity) ?></td>
        <td><?= h($purchaseOrderDetails->material->unit_measure) ?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <th class="text-right" colspan="5"><?= __('TOTAL:&nbsp;') ?></th>
        <th></th>
    </tr>
</table>
<?php endif; ?>