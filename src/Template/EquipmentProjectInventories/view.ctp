<?= $this->assign('title', 'Equipment Project Inventory') ?>
<div class="equipment view large-9 medium-8 columns content">
    <h3><?= h($summary->name) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Equipment Name') ?></th>
            <td><?= h($summary->name) ?></td>
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
    <?php if (!empty($equipment->equipment_task_inventories)): ?>
        <h3><?= __('Track Equipment') ?></h3>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= $this->Paginator->sort('title', 'Task') ?></th>
                <th><?= $this->Paginator->sort('start_date') ?></th>
                <th><?= $this->Paginator->sort('end_date') ?></th>
                <th>Status</th>
                <th><?= __('Quantity Assigned') ?></th>
            </tr>
            <?php foreach ($equipment->equipment_task_inventories as $taskInventory): ?>
                <tr>
                    <td><?= $this->Html->link($taskInventory->task->title, ['controller' => 'tasks', 'action' => 'view', $taskInventory->task->id]) ?></td>
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