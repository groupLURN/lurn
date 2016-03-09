<?= $this->assign('title', 'Material Project Inventory') ?>
<div class="material view large-9 medium-8 columns content">
    <h3><?= h($summary->name) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Material Name') ?></th>
            <td><?= h($summary->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Unit Measure') ?></th>
            <td><?= h($summary->unit_measure) ?></td>
        </tr>
        <tr>
            <th><?= __('Available Quantity') ?></th>
            <td><?= h($summary->available_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Unavailable Quantity') ?></th>
            <td><?= h($summary->unavailable_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Total Quantity') ?></th>
            <td><?= h($summary->available_quantity + $summary->unavailable_quantity) ?></td>
        </tr>
    </table>
</div>

<div class="related">
    <h3><?= __('Track Materials') ?></h3>
    <?php if (!empty($material->materials_task_inventories)): ?>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= h('Milestone') ?></th>
                <th><?= h('Task') ?></th>
                <th><?= h('Start Date') ?></th>
                <th><?= h('End Date') ?></th>
                <th>Status</th>
                <th><?= __('Quantity Assigned') ?></th>
            </tr>
            <?php foreach ($material->materials_task_inventories as $taskInventory): ?>
                <tr>
                    <td><?= h($taskInventory->task->milestone->title) ?></td>
                    <td><?= h($taskInventory->task->title) ?></td>
                    <td><?= h($taskInventory->task->start_date) ?></td>
                    <td><?= h($taskInventory->task->end_date) ?></td>
                    <td>
                        <span class='task-status <?=str_replace(' ', '-', strtolower($taskInventory->task->status))?>'>
                            <?= h($taskInventory->task->status) ?>
                        </span>
                    </td>
                    <td><?= $this->Number->format($taskInventory->quantity) ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>