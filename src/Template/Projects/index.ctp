<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('New Project'), ['action' => 'add']); ?>
    </div>
</div>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <?= $this->Form->create('Search', ['type' => 'GET']) ?>
            <h4><i class="fa fa-angle-right"></i> Filters </h4>
            <hr>
            <table class="table">
                <tbody>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <input type="checkbox" name="start_date_checked" <?= isset($start_date_checked)? 'checked': ''?>
                               onclick="$('input.datetime-picker:text', $(this).closest('tr')).prop('disabled', !$(this).is(':checked'));">
                        <label>Start Date</label>
                    </td>
                    <td>
                        <?= $this->Form->input('start_date_from', [
                            'class' => 'datetime-picker form-control',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($start_date_checked),
                            'val' => isset($start_date_from)? $start_date_from: ''
                        ]); ?>
                    </td>
                    <td colspan="2">
                        <?= $this->Form->input('start_date_to', [
                            'class' => 'datetime-picker form-control advance-1-day',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($start_date_checked),
                            'val' => isset($start_date_to)? $start_date_to: ''
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <input type="checkbox" name="end_date_checked" <?= isset($end_date_checked)? 'checked': ''?>
                               onclick="$('input.datetime-picker:text', $(this).closest('tr')).prop('disabled', !$(this).is(':checked'));">
                        <label>End Date</label>
                    </td>
                    <td>
                        <?= $this->Form->input('end_date_from', [
                            'class' => 'datetime-picker form-control',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($end_date_checked),
                            'val' => isset($end_date_from)? $end_date_from: ''
                        ]); ?>
                    </td>
                    <td colspan="2">
                        <?= $this->Form->input('end_date_to', [
                            'class' => 'datetime-picker form-control advance-1-day',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($end_date_checked),
                            'val' => isset($end_date_to)? $end_date_to: ''
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <?= $this->Form->label("", "Status"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('project_status_id', [
                            'options' => ['0' => 'All'] + $projectStatuses,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($project_status_id)? $project_status_id: 0,
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="row mt">
                            <div class="col-xs-10">
                                <input type="text" name="title" class="form-control" placeholder="Search Project's Title"
                                       id="txt-search" <?= isset($title)? "value='" . $title . "'": ""; ?> >
                            </div>
                            <div class="col-xs-2">
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Projects') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('client_id') ?></th>
                    <th><?= $this->Paginator->sort('project_manager_id') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('location') ?></th>
                    <th>Progress</th>
                    <th><?= $this->Paginator->sort('phase') ?></th>
                    <th><?= $this->Paginator->sort('project_status_id') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><?= h($project->title) ?></td>
                        <td><?= $project->has('client') ? $this->Html->link($project->client->company_name, ['controller' => 'Clients', 'action' => 'view', $project->client->id]) : '' ?></td>
                        <td><?= $project->has('employee') ? $this->Html->link($project->employee->name, ['controller' => 'Employees', 'action' => 'view', $project->employee->id]) : '' ?></td>
                        <td><?= h(isset($project->start_date) ? date_format($project->start_date, 'F d, Y') : '') ?></td>
                        <td><?= h(isset($project->end_date) ? date_format($project->end_date, 'F d, Y') : '') ?></td>
                        <td><?= h($project->location) ?></td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?=$project->progress ?>"
                                     aria-valuemin="0" aria-valuemax="100" style="margin-right: -<?=$project->progress ?>%;
                                    width: <?=$project->progress ?>%">
                                </div>
                                <div style="text-align:center; color:black;"><?= h(number_format($project->progress, 2)).'% Complete'?></div>
                            </div>
                        </td>
                        <td><?= h($project->project_phase->name) ?></td>
                        <td><?= h($project->status) ?></td>
                        <td class="actions">
                            <?php 
                                if (in_array($project->id, $assignedProjects) && in_array($employeeType, [0, 1, 2]))
                                {
                                    echo $this->dataTableManageButton(__('Manage'), ['controller' => 'ProjectOverview', 'action' => 'index', $project->id]);  
                                }
                            ?>
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $project->id]); ?>
                            <?php 
                                if (in_array($project->id, $assignedProjects) && in_array($employeeType, [0, 1, 2]))
                                {
                                    echo $this->dataTableEditButton(__('Edit'), ['action' => 'edit', $project->id]); 
                                    echo $this->dataTableDeleteButton(__('Delete'), ['action' => 'delete', $project->id], __('Are you sure you want to delete {0}?', $project->title)
                            );
                                }
                            ?>
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
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->