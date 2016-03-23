<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $purchaseReceiveHeader->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReceiveHeader->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Purchase Receive Headers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Receive Details'), ['controller' => 'PurchaseReceiveDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Receive Detail'), ['controller' => 'PurchaseReceiveDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseReceiveHeaders form large-9 medium-8 columns content">
    <?= $this->Form->create($purchaseReceiveHeader) ?>
    <fieldset>
        <legend><?= __('Edit Purchase Receive Header') ?></legend>
        <?php
            echo $this->Form->input('received_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
