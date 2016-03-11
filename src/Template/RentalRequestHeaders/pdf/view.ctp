<?= $this->assign('title', 'Rental Request') ?>
<h1 align="center">Rental Request Form</h1>
<table>
    <tr>
        <th><?= __('Rental Request Number') ?></th>
        <td><?= h($rentalRequestHeader->id) ?></td>
    </tr>
    <tr>
        <th><?= __('Project') ?></th>
        <td><?= $rentalRequestHeader->project->title?></td>
    </tr>
    <tr>
        <th><?= __('Supplier') ?></th>
        <td><?= $rentalRequestHeader->supplier->name?></td>
    </tr>
    <tr>
        <th><?= __('Supplier Address') ?></th>
        <td><?= $rentalRequestHeader->supplier->address?></td>
    </tr>
    <tr>
        <th><?= __('Date Requested') ?></th>
        <td><?= h($rentalRequestHeader->created) ?></td>
    </tr>
</table>

<?php if (!empty($rentalRequestHeader->rental_request_details)): ?>
<h1 align="center"><?= __('Rental Details') ?></h1>
<table cellspacing="0" class="table table-striped">
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
