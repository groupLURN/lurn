<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Rental Request Header'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rental Request Details'), ['controller' => 'RentalRequestDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rental Request Detail'), ['controller' => 'RentalRequestDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rentalRequestHeaders index large-9 medium-8 columns content">
    <h3><?= __('Rental Request Headers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('project_id') ?></th>
                <th><?= $this->Paginator->sort('supplier_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rentalRequestHeaders as $rentalRequestHeader): ?>
            <tr>
                <td><?= $this->Number->format($rentalRequestHeader->id) ?></td>
                <td><?= $rentalRequestHeader->has('project') ? $this->Html->link($rentalRequestHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $rentalRequestHeader->project->id]) : '' ?></td>
                <td><?= $rentalRequestHeader->has('supplier') ? $this->Html->link($rentalRequestHeader->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $rentalRequestHeader->supplier->id]) : '' ?></td>
                <td><?= h($rentalRequestHeader->created) ?></td>
                <td><?= h($rentalRequestHeader->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $rentalRequestHeader->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rentalRequestHeader->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rentalRequestHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rentalRequestHeader->id)]) ?>
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
