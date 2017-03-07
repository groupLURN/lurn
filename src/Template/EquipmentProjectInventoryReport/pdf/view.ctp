<?= $this->assign('title', 'Project Equipment Inventory Report') ?>
<?php if (sizeOf($equipmentInventories) > 0): ?>
<table cellspacing="0" class="report text-center">
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
        <?php foreach ($equipmentInventories as $equipmentInventory): ?>
        <tr>
            <td class="text-left"><?= $equipmentInventory->equipment->name ?></td>
            <td><?= $this->Number->format($equipmentInventory->available_in_house_quantity) ?></td>
            <td><?= $this->Number->format($equipmentInventory->available_rented_quantity) ?></td>
            <td><?= $this->Number->format($equipmentInventory->unavailable_in_house_quantity) ?></td>
            <td><?= $this->Number->format($equipmentInventory->unavailable_rented_quantity) ?></td>
            <td><?= $this->Number->format($equipmentInventory->total_quantity) ?></td>
        </tr>
        <?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<p>No data available.</p>
<?php endif; ?>