<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Purchase Receive Header'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Receive Details'), ['controller' => 'PurchaseReceiveDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Receive Detail'), ['controller' => 'PurchaseReceiveDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseReceiveHeaders index large-9 medium-8 columns content">
    <h3><?= __('Purchase Receive Headers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('received_date') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchaseReceiveHeaders as $purchaseReceiveHeader): ?>
            <tr>
                <td><?= $this->Number->format($purchaseReceiveHeader->id) ?></td>
                <td><?= h($purchaseReceiveHeader->received_date) ?></td>
                <td><?= h($purchaseReceiveHeader->created) ?></td>
                <td><?= h($purchaseReceiveHeader->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $purchaseReceiveHeader->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $purchaseReceiveHeader->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $purchaseReceiveHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReceiveHeader->id)]) ?>
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
