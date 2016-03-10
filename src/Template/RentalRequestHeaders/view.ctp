<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Rental Request Header'), ['action' => 'edit', $rentalRequestHeader->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Rental Request Header'), ['action' => 'delete', $rentalRequestHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rentalRequestHeader->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Rental Request Headers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rental Request Header'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rental Request Details'), ['controller' => 'RentalRequestDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rental Request Detail'), ['controller' => 'RentalRequestDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rentalRequestHeaders view large-9 medium-8 columns content">
    <h3><?= h($rentalRequestHeader->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Project') ?></th>
            <td><?= $rentalRequestHeader->has('project') ? $this->Html->link($rentalRequestHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $rentalRequestHeader->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Supplier') ?></th>
            <td><?= $rentalRequestHeader->has('supplier') ? $this->Html->link($rentalRequestHeader->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $rentalRequestHeader->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($rentalRequestHeader->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($rentalRequestHeader->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($rentalRequestHeader->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Rental Request Details') ?></h4>
        <?php if (!empty($rentalRequestHeader->rental_request_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Rental Request Header Id') ?></th>
                <th><?= __('Equipment Id') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Duration') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($rentalRequestHeader->rental_request_details as $rentalRequestDetails): ?>
            <tr>
                <td><?= h($rentalRequestDetails->id) ?></td>
                <td><?= h($rentalRequestDetails->rental_request_header_id) ?></td>
                <td><?= h($rentalRequestDetails->equipment_id) ?></td>
                <td><?= h($rentalRequestDetails->quantity) ?></td>
                <td><?= h($rentalRequestDetails->duration) ?></td>
                <td><?= h($rentalRequestDetails->created) ?></td>
                <td><?= h($rentalRequestDetails->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RentalRequestDetails', 'action' => 'view', $rentalRequestDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RentalRequestDetails', 'action' => 'edit', $rentalRequestDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RentalRequestDetails', 'action' => 'delete', $rentalRequestDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rentalRequestDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
