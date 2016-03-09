<?= $this->assign('title', 'Equipment Project Inventory') ?>
<div class="equipment view large-9 medium-8 columns content">
    <h3><?= h($summary->name) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Equipment Name') ?></th>
            <td><?= h($summary->equipment->name) ?></td>
        </tr>

        <tr>
            <th><?= __('Available Quantity') ?></th>
            <td><?= $this->Number->format($summary->available_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Unavailable Quantity') ?></th>
            <td><?= $this->Number->format($summary->unavailable_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Total Quantity') ?></th>
            <td><?= $this->Number->format($summary->available_quantity + $summary->unavailable_quantity) ?></td>
        </tr>
    </table>
</div>

<div class="related">
    <?php if (!empty($details)): ?>
        <h3><?= __('Track Equipment') ?></h3>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= h('Milestone') ?></th>
                <th><?= h('Task') ?></th>
                <th><?= h('Start Date') ?></th>
                <th><?= h('End Date') ?></th>
                <th>Status</th>
                <th><?= __('Quantity Assigned') ?></th>
            </tr>
            <?php foreach ($details as $detail): ?>
                <tr>
                    <td><?= h($detail['task']->milestone->title) ?></td>
                    <td><?= h($detail['task']->title) ?></td>
                    <td><?= h($detail['task']->start_date) ?></td>
                    <td><?= h($detail['task']->end_date) ?></td>
                    <td>
                        <span class='task-status <?=str_replace(' ', '-', strtolower($detail['task']->status))?>'>
                            <?= h($detail['task']->status) ?>
                        </span>
                    </td>
                    <td><?= $this->Number->format($detail['quantity']) ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>