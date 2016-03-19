<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $rentalReceiveHeader->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $rentalReceiveHeader->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Rental Receive Headers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Rental Request Headers'), ['controller' => 'RentalRequestHeaders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rental Request Header'), ['controller' => 'RentalRequestHeaders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rental Receive Details'), ['controller' => 'RentalReceiveDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rental Receive Detail'), ['controller' => 'RentalReceiveDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rentalReceiveHeaders form large-9 medium-8 columns content">
    <?= $this->Form->create($rentalReceiveHeader) ?>
    <fieldset>
        <legend><?= __('Edit Rental Receive Header') ?></legend>
        <?php
            echo $this->Form->input('rental_request_header_id', ['options' => $rentalRequestHeaders]);
            echo $this->Form->input('receive_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
