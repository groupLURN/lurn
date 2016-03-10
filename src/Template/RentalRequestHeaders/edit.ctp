<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $rentalRequestHeader->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $rentalRequestHeader->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Rental Request Headers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rental Request Details'), ['controller' => 'RentalRequestDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rental Request Detail'), ['controller' => 'RentalRequestDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rentalRequestHeaders form large-9 medium-8 columns content">
    <?= $this->Form->create($rentalRequestHeader) ?>
    <fieldset>
        <legend><?= __('Edit Rental Request Header') ?></legend>
        <?php
            echo $this->Form->input('project_id', ['options' => $projects]);
            echo $this->Form->input('supplier_id', ['options' => $suppliers]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
