<?= $this->Html->script('tasks.js', ['block' => 'script-end']); ?>
<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <?= $this->Form->create('Search', ['type' => 'GET']) ?>
            <h4><i class="fa fa-angle-right"></i> Filters </h4>
            <hr>
            <?= $this->Form->input('project_id', ['type' => 'hidden', 'value' => $project_id]); ?>
            <table class="table">
                <tbody>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px; width: 20%;">
                        <?= $this->Form->label("", "Task Status"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('status', [
                            'options' => [0 => 'All'] + $statusList,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($status)? $status: 0
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="row mt">
                            <div class="col-md-10">
                                <input type="text" name="title" class="form-control" placeholder="Search Tasks"
                                       id="txt-search" <?= isset($title)? "value='" . $title . "'": ""; ?> >
                            </div>
                            <div class="col-md-2">
                                <?= $this->Form->button(__('Search'), [
                                    'id' => 'btn-search',
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <?= $this->Form->end(); ?>
        </div><!-- --/content-panel ---->
    </div>
</div>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i> <?= __('Tasks') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th></th>
                    <th>Milestones</th>
                    <th>Progress</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($milestones as $milestone): ?>
                <tr>
                    <td>
                        <button data-toggle="collapse" data-target="#milestone-<?=$milestone->id?>"
                        class="btn btn-info btn-xs collapsable-button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </td>
                    <td><?= h($milestone->title) ?></td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                 aria-valuenow="<?=$milestonesProgress[$milestone->id] ?>"
                                 aria-valuemin="0" aria-valuemax="100" style="margin-right: -<?=$milestonesProgress[$milestone->id] ?>%;
                                width: <?=$milestonesProgress[$milestone->id] ?>%">
                            </div>
                            <div style="text-align:center; color:black;"><?= h(number_format($milestonesProgress[$milestone->id], 2)).'% Complete'?></div>
                        </div>
                    </td>
                </tr>
                <tr id="milestone-<?=$milestone->id?>" class="collapse">
                    <td colspan="3" style="padding-left: 30px">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th><?= $this->Paginator->sort('title', 'Task') ?></th>
                                <th><?= $this->Paginator->sort('start_date') ?></th>
                                <th><?= $this->Paginator->sort('end_date') ?></th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($milestone->tasks as $task): ?>
                                <tr>
                                    <td><?= h($task->title) ?></td>
                                    <td><?= h($task->start_date) ?></td>
                                    <td><?= h($task->end_date) ?></td>
                                    <td>
                                        <span class='task-status <?=str_replace(' ', '-', strtolower($task->status))?>'>
                                            <?= h($task->status) ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $task->id, '?' => ['project_id' => $projectId]]); ?>
                                        <?= $this->dataTableEditButton(__('Edit'), ['action' => 'edit', $task->id, '?' => ['project_id' => $projectId]]); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                </ul>
                <p><?= $this->Paginator->counter() ?></p>
            </div>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->
<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Task'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Milestones'), ['controller' => 'Milestones', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Milestone'), ['controller' => 'Milestones', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Equipment'), ['controller' => 'Equipment', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Equipment'), ['controller' => 'Equipment', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Manpower'), ['controller' => 'Manpower', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Manpower'), ['controller' => 'Manpower', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materials'), ['controller' => 'Materials', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Material'), ['controller' => 'Materials', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tasks index large-9 medium-8 columns content">
    <h3><?= __('Tasks') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('milestone_id') ?></th>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('is_finished') ?></th>
                <th><?= $this->Paginator->sort('start_date') ?></th>
                <th><?= $this->Paginator->sort('end_date') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= h($task->id) ?></td>
                <td><?= $task->has('milestone') ? $this->Html->link($task->milestone->title, ['controller' => 'Milestones', 'action' => 'view', $task->milestone->id]) : '' ?></td>
                <td><?= h($task->title) ?></td>
                <td><?= h($task->is_finished) ?></td>
                <td><?= h($task->start_date) ?></td>
                <td><?= h($task->end_date) ?></td>
                <td><?= h($task->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $task->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $task->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $task->id], ['confirm' => __('Are you sure you want to delete # {0}?', $task->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
-->