<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Rental Receive Header'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rental Request Headers'), ['controller' => 'RentalRequestHeaders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rental Request Header'), ['controller' => 'RentalRequestHeaders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rental Receive Details'), ['controller' => 'RentalReceiveDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rental Receive Detail'), ['controller' => 'RentalReceiveDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rentalReceiveHeaders index large-9 medium-8 columns content">
    <h3><?= __('Rental Receive Headers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('rental_request_header_id') ?></th>
                <th><?= $this->Paginator->sort('receive_date') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rentalReceiveHeaders as $rentalReceiveHeader): ?>
            <tr>
                <td><?= $this->Number->format($rentalReceiveHeader->id) ?></td>
                <td><?= $rentalReceiveHeader->has('rental_request_header') ? $this->Html->link($rentalReceiveHeader->rental_request_header->id, ['controller' => 'RentalRequestHeaders', 'action' => 'view', $rentalReceiveHeader->rental_request_header->id]) : '' ?></td>
                <td><?= h($rentalReceiveHeader->receive_date) ?></td>
                <td><?= h($rentalReceiveHeader->created) ?></td>
                <td><?= h($rentalReceiveHeader->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $rentalReceiveHeader->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rentalReceiveHeader->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rentalReceiveHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rentalReceiveHeader->id)]) ?>
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
