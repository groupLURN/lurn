<div class="tasks view large-9 medium-8 columns content">
    <h3><?= h($task->title) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Milestone') ?></th>
            <td><?= h($task->milestone->title); ?></td>
        </tr>
        <tr>
            <th><?= __('Task') ?></th>
            <td><?= h($task->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Date') ?></th>
            <td><?= h(date_format($task->start_date, 'F d, Y')) ?></td>
        </tr>
        <tr>
            <th><?= __('End Date') ?></th>
            <td><?= h(date_format($task->end_date, 'F d, Y')) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $task->status; ?></td>
        </tr>
        <?php if ($task->status === 'Done') : ?>
            <tr>
                <th><?= __('Comments') ?></th>
                <td><?= $task->comments; ?></td>
            </tr>
        <?php endif; ?>
    </table>
    <div class="related">
        <h4><?= __('Assigned Equipment') ?></h4>
        <?php if (!empty($task->equipment)): ?>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Quantity Needed') ?></th>
                </tr>
                <?php foreach ($task->equipment as $equipment): ?>
                    <tr>
                        <td><?= h($equipment->name) ?></td>
                        <th><?= h($equipment->_joinData->quantity) ?></th>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Assigned Manpower Types') ?></h4>
        <?php if (!empty($task->manpower_types)): ?>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Manpower Type') ?></th>
                    <th><?= __('Quantity') ?></th>
                </tr>
                <?php foreach ($task->manpower_types as $manpower_type): ?>
                    <tr>
                        <td><?= h($manpower_type->title) ?></td>
                        <td><?= h($manpower_type->_joinData->quantity) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Assigned Materials') ?></h4>
        <?php if (!empty($task->materials)): ?>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Unit Measure') ?></th>
                    <th><?= __('Quantity Needed') ?></th>
                </tr>
                <?php foreach ($task->materials as $materials): ?>
                    <tr>
                        <td><?= h($materials->name) ?></td>
                        <td><?= h($materials->unit_measure) ?></td>
                        <td><?= h($materials->_joinData->quantity) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>