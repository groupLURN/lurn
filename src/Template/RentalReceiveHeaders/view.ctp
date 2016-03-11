<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Rental Receive Header'), ['action' => 'edit', $rentalReceiveHeader->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Rental Receive Header'), ['action' => 'delete', $rentalReceiveHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rentalReceiveHeader->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Rental Receive Headers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rental Receive Header'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rental Request Headers'), ['controller' => 'RentalRequestHeaders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rental Request Header'), ['controller' => 'RentalRequestHeaders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rental Receive Details'), ['controller' => 'RentalReceiveDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rental Receive Detail'), ['controller' => 'RentalReceiveDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rentalReceiveHeaders view large-9 medium-8 columns content">
    <h3><?= h($rentalReceiveHeader->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Rental Request Header') ?></th>
            <td><?= $rentalReceiveHeader->has('rental_request_header') ? $this->Html->link($rentalReceiveHeader->rental_request_header->id, ['controller' => 'RentalRequestHeaders', 'action' => 'view', $rentalReceiveHeader->rental_request_header->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($rentalReceiveHeader->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Receive Date') ?></th>
            <td><?= h($rentalReceiveHeader->receive_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($rentalReceiveHeader->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($rentalReceiveHeader->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Rental Receive Details') ?></h4>
        <?php if (!empty($rentalReceiveHeader->rental_receive_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Rental Receive Header Id') ?></th>
                <th><?= __('Equipment Id') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($rentalReceiveHeader->rental_receive_details as $rentalReceiveDetails): ?>
            <tr>
                <td><?= h($rentalReceiveDetails->id) ?></td>
                <td><?= h($rentalReceiveDetails->rental_receive_header_id) ?></td>
                <td><?= h($rentalReceiveDetails->equipment_id) ?></td>
                <td><?= h($rentalReceiveDetails->quantity) ?></td>
                <td><?= h($rentalReceiveDetails->start_date) ?></td>
                <td><?= h($rentalReceiveDetails->end_date) ?></td>
                <td><?= h($rentalReceiveDetails->created) ?></td>
                <td><?= h($rentalReceiveDetails->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RentalReceiveDetails', 'action' => 'view', $rentalReceiveDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RentalReceiveDetails', 'action' => 'edit', $rentalReceiveDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RentalReceiveDetails', 'action' => 'delete', $rentalReceiveDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rentalReceiveDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
