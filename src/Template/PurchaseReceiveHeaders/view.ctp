<?= $this->assign('title', 'Purchase Receive') ?>
<div class="purchaseReceiveHeaders view large-9 medium-8 columns content">
    <h3><?= 'Purchase Receive Number ' . h($purchaseReceiveHeader->number) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Purchase Receive Number') ?></th>
            <td><?= h($purchaseReceiveHeader->number) ?></td>
        </tr>
        <tr>
            <th><?= __('Purchase Order Number') ?></th>
            <td><?= h($purchaseReceiveHeader->purchase_receive_details[0]->purchase_order_detail->purchase_order_header->id) ?></td>
        </tr>
        <?php if($purchaseReceiveHeader->purchase_receive_details[0]->purchase_order_detail->purchase_order_header->has('project')) : ?>
            <tr>
                <th><?= __('Project') ?></th>
                <td><?= h($purchaseReceiveHeader->purchase_receive_details[0]->purchase_order_detail->purchase_order_header->project->title) ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <th><?= __('Supplier') ?></th>
            <td><?= h($purchaseReceiveHeader->purchase_receive_details[0]->purchase_order_detail->purchase_order_header->supplier->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Ordered') ?></th>
            <td><?= h($purchaseReceiveHeader->purchase_receive_details[0]->purchase_order_detail->purchase_order_header->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Received') ?></th>
            <td><?= h($purchaseReceiveHeader->received_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <?php if (!empty($purchaseReceiveHeader->purchase_receive_details)): ?>
            <h4><?= __('Purchase Receive Details') ?></h4>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Materials') ?></th>
                    <th><?= __('Unit Measure') ?></th>
                    <th><?= __('Quantity Received') ?></th>
                </tr>
            <?php foreach ($purchaseReceiveHeader->purchase_receive_details as $purchaseReceiveDetails): ?>
            <tr>
                <td><?= h($purchaseReceiveDetails->purchase_order_detail->material->name) ?></td>
                <td><?= h($purchaseReceiveDetails->purchase_order_detail->material->unit_measure) ?></td>
                <td><?= h($purchaseReceiveDetails->quantity) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
