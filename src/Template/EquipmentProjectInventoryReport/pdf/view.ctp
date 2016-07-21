<?= $this->assign('title', 'Project Equipment Inventory Report') ?>
<?php if (sizeOf($equipment) > 0): ?>
<table cellspacing="0" class="table table-striped report">
    <thead>
        <tr>
            <th><?= __('Name') ?></th>
            <th><?= __('Available In House Quantity') ?></th>
            <th><?= __('Available Rented Quantity') ?></th>
            <th><?= __('Unavailable In House Quantity') ?></th>
            <th><?= __('Unavailable Rented Quantity') ?></th>
            <th><?= __('Total Quantity') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($equipment as $equipment_): ?>
        <tr>
            <td class="text-left"><?= $equipment_->name ?></td>
            <td><?= $this->Number->format($equipment_->available_in_house_quantity) ?></td>
            <td><?= $this->Number->format($equipment_->available_rented_quantity) ?></td>
            <td><?= $this->Number->format($equipment_->unavailable_in_house_quantity) ?></td>
            <td><?= $this->Number->format($equipment_->unavailable_rented_quantity) ?></td>
            <td><?= $this->Number->format($equipment_->total_quantity) ?></td>
        </tr>
        <?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>