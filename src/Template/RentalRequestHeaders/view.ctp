<?= $this->assign('title', 'Rental Request') ?>
<div class="rentalRequestHeaders view large-9 medium-8 columns content">
    <h3><?= h($rentalRequestHeader->id) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Rental Request Number') ?></th>
            <td><?= $this->Number->format($rentalRequestHeader->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Project') ?></th>
            <td><?= $rentalRequestHeader->has('project') ? $this->Html->link($rentalRequestHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $rentalRequestHeader->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Supplier') ?></th>
            <td><?= $rentalRequestHeader->has('supplier') ? $this->Html->link($rentalRequestHeader->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $rentalRequestHeader->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Date Requested') ?></th>
            <td><?= h($rentalRequestHeader->created) ?></td>
        </tr>
    </table>
</div>
<div class="related">
    <?php if (!empty($rentalRequestHeader->rental_request_details)): ?>
    <h3><?= __('Rental Details') ?></h3>
    <table cellpadding="0" cellspacing="0" class="table table-striped">
        <tr>
            <th><?= __('Equipment Id') ?></th>
            <th><?= __('Quantity') ?></th>
            <th><?= __('Duration') ?></th>
        </tr>
        <?php foreach ($rentalRequestHeader->rental_request_details as $rentalRequestDetails): ?>
        <tr>
            <td><?= h($rentalRequestDetails->equipment->name) ?></td>
            <td><?= h($rentalRequestDetails->quantity) ?></td>
            <td><?= h($rentalRequestDetails->duration) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
</div>
