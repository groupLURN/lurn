<?= $this->assign('title', 'General Manpower Inventory Report') ?>
<?php if (sizeOf($manpower) > 0): ?>
<table cellspacing="0" class="table table-striped report">
    <thead>
        <tr>
            <th><?= __('Manpower Type') ?></th>
            <th><?= __('Available') ?></th>
            <th><?= __('Unavailable')?></th>
            <th><?= __('Total') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($manpower as $manpower_): ?>
        <tr>
            <td class="text-left"><?= h($manpower_->manpower_type->title) ?></td>
            <td><?= $this->Number->format($manpower_->available_quantity) ?></td>
            <td><?= $this->Number->format($manpower_->unavailable_quantity) ?></td>
            <td><?= $this->Number->format($manpower_->total_quantity) ?></td>
        </tr>
        <?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>