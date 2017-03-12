<?= $this->assign('title', 'Project Materials Inventory Report') ?>
<?php if (sizeOf($materials) > 0): ?>
<table cellspacing="0" class="report text-center">
    <thead>
        <tr>
            <th><?= __('Name') ?></th>
            <th><?= __('Unit Measure') ?></th>
            <th><?= __('Available Quantity') ?></th>
            <th><?= __('Unavailable Quantity')?></th>
            <th><?= __('Total Quantity') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($materials as $material): ?>
        <tr>
            <td class="text-left"><?= $material->name ?></td>
            <td><?= $material->unit_measure ?></td>
            <td><?= $this->Number->format($material->available_quantity) ?></td>
            <td><?= $this->Number->format($material->unavailable_quantity) ?></td>
            <td><?= $this->Number->format($material->total_quantity) ?></td>
        </tr>
        <?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<p>No data available.</p>
<?php endif; ?>