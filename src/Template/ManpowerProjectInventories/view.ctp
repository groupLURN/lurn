<?= $this->assign('title', 'Manpower Project Inventory') ?>
<?= $this->Html->script('tasks', ['block' => 'script-end']) ?>
<div class="manpower view large-9 medium-8 columns content">
    <h3><?= h($summary->name) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Manpower Type') ?></th>
            <td><?= h($summary->manpower_type->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Available') ?></th>
            <td><?= $this->Number->format($summary->available_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Unavailable') ?></th>
            <td><?= $this->Number->format($summary->unavailable_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Total') ?></th>
            <td><?= $this->Number->format($summary->available_quantity + $summary->unavailable_quantity) ?></td>
        </tr>
    </table>
</div>

<div class="related">
    <?php if (!$availableManpower->isEmpty()) : ?>
        <h3><?= __('Track Available Manpower') ?></h3>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= __('Manpower List') ?></th>
            </tr>
            <?php foreach ($availableManpower as $manpower): ?>
                <tr>
                    <td><?= h($manpower->name) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <?php if (!$unavailableManpowerByTask->isEmpty()): ?>
        <h3><?= __('Track Unavailable Manpower') ?></h3>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th></th>
                <th><?= h('Milestone') ?></th>
                <th><?= h('Task') ?></th>
                <th><?= h('Start Date') ?></th>
                <th><?= h('End Date') ?></th>
                <th><?= h('Status') ?></th>
                <th><?= h('Assigned') ?></th>
            </tr>
            <?php foreach ($unavailableManpowerByTask as $unavailableManpower): ?>
                <?php foreach ($unavailableManpower as $key => $manpower): ?>
                    <?php if($key === 0) : ?>
                        <tr>
                            <td>
                                <button data-toggle="collapse" data-target="#task-<?=$manpower->task->id?>"
                                        class="btn btn-info btn-xs collapsable-button">
                                    <i class="fa fa-arrow-right"></i>
                                </button>
                            </td>
                            <td><?= h($manpower->task->milestone->title) ?></td>
                            <td><?= h($manpower->task->title) ?></td>
                            <td><?= h($manpower->task->start_date) ?></td>
                            <td><?= h($manpower->task->end_date) ?></td>
                            <td>
                                <span class='task-status <?=str_replace(' ', '-', strtolower($manpower->task->status))?>'>
                                    <?= h($manpower->task->status) ?>
                                </span>
                            </td>
                            <td><?= $this->Number->format(count($unavailableManpower)) ?> </td>
                        </tr>
                        <tr id="task-<?=$manpower->task->id?>" class="collapse">
                        <td colspan="10" style="padding-left: 30px">
                        <table class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th><?= __('Manpower List') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                    <?php endif; // First loop ?>
                    <tr>
                        <td><?= h($manpower->name) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                </table>
                </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>