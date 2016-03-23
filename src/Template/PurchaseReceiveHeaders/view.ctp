<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Purchase Receive Header'), ['action' => 'edit', $purchaseReceiveHeader->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Purchase Receive Header'), ['action' => 'delete', $purchaseReceiveHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReceiveHeader->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Receive Headers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Receive Header'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Receive Details'), ['controller' => 'PurchaseReceiveDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Receive Detail'), ['controller' => 'PurchaseReceiveDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="purchaseReceiveHeaders view large-9 medium-8 columns content">
    <h3><?= h($purchaseReceiveHeader->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($purchaseReceiveHeader->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Received Date') ?></th>
            <td><?= h($purchaseReceiveHeader->received_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($purchaseReceiveHeader->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($purchaseReceiveHeader->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Purchase Receive Details') ?></h4>
        <?php if (!empty($purchaseReceiveHeader->purchase_receive_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Purchase Receive Header Id') ?></th>
                <th><?= __('Purchase Order Detail Id') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($purchaseReceiveHeader->purchase_receive_details as $purchaseReceiveDetails): ?>
            <tr>
                <td><?= h($purchaseReceiveDetails->id) ?></td>
                <td><?= h($purchaseReceiveDetails->purchase_receive_header_id) ?></td>
                <td><?= h($purchaseReceiveDetails->purchase_order_detail_id) ?></td>
                <td><?= h($purchaseReceiveDetails->quantity) ?></td>
                <td><?= h($purchaseReceiveDetails->created) ?></td>
                <td><?= h($purchaseReceiveDetails->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseReceiveDetails', 'action' => 'view', $purchaseReceiveDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseReceiveDetails', 'action' => 'edit', $purchaseReceiveDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseReceiveDetails', 'action' => 'delete', $purchaseReceiveDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReceiveDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
