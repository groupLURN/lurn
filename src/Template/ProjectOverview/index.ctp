<?= $this->assign('title', 'Project Overview') ?> <!-- Trigger the modal with a button -->

<?= $this->Flash->render()?>

<?php
    if (in_array($employeeType, [0, 1, 2], true))  {
?>
<div class="row mt">
    <div class="col-xs-12">

    <?php 
        if ($project->is_finished == 0 && $project->phase == 4) {
        ?>        
        <?= $this->Form->create('', ['id' => 'finish-form', 'url' => ['action' => 'finish-project', $projectId]]) ?>
        <?= $this->Form->button('<i class="fa fa-save"></i> Finish Project', ['class' => 'btn btn-primary', 'id'=>'finish-form-submit']); ?>
        <?= $this->Form->end() ?>
    <?php 
        }

        if ($project->is_finished == 0) {
    ?>
        <?= $this->Form->create('', ['id' => 'change-phase-form', 'url' => ['action' => 'change-phase', $projectId]]) ?>
            <?= $this->Form->button('<i class="fa fa-wrench"></i> Change Phase', ['class' => 'btn btn-success', 'id'=>'change-phase-submit']); ?>
        <?= $this->Form->end() ?>
    <?php 
        }
    ?>

    </div>
</div>
<?php 
    }
?>
<div class="projects view large-9 medium-8 columns content">
    <h3><?= h($project->title) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($project->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= $this->Text->autoParagraph(h($project->description)); ?></td>
        </tr>
        <tr>
            <th><?= __('Location') ?></th>
            <td><?= h($project->location) ?></td>
        </tr>
        <tr>
            <th><?= __('Client') ?></th>
            <td><?= $project->has('client') ? $this->Html->link($project->client->company_name, ['controller' => 'Clients', 'action' => 'view', $project->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Project Phase') ?></th>
            <td><?= h($project->project_phase->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Project Status') ?></th>
            <td><?= h($project->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Project Manager') ?></th>
            <td><?= $this->Html->link($project->employee->name, ['controller' => 'employees', 'action' => 'view', $project->employee->id]) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Date') ?></th>
            <td><?= h(date_format($project->start_date, 'F d, Y')) ?></td>
        </tr>
        <tr>
            <th><?= __('End Date') ?></th>
            <td><?= h(date_format($project->end_date, 'F d, Y')) ?></td>
        </tr>
    </table>

    <div class="related">
        <h4><?= __('Core Team') ?></h4>
        <?php if (!empty($project->employees_join)): ?>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Employee Type') ?></th>
                    <th><?= __('Employment Date') ?></th>
                    <th><?= __('Termination Date') ?></th>
                </tr>
                <?php foreach ($project->employees_join as $employees_join): ?>
                    <tr>
                        <td><?= h($employees_join->name) ?></td>
                        <td><?= $this->Html->link($employees_join->employee_type->title, ['controller' => 'employees', 'action' => 'view', $employees_join->id]) ?></td>
                        <td><?= h(date_format($employees_join->employment_date, 'F d, Y')) ?></td>
                        <td><?= h(isset($employees_join->termination_date) ? date_format($employees_join->termination_date, 'F d, Y') : '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <h4 class="mt">Uploaded Files</h4>
        <div id="files-existing" >
            <?php 
                if (count($project->projects_files) > 0) {
                    foreach ($project->projects_files as $file){
            ?>                     
                
                    <div class="file-block">
                        <div class="row">
                            <div class="col-sm-12">   
                            <a href=
                                <?= 
                                    rawurldecode(
                                        $this->Url->build([
                                            'controller' => 'Projects',
                                            'action' => 'download',
                                            'file' => $file->file_location.$file->file_name.'.'.$file->file_type
                                        ])
                                    )
                                ?> 
                            >
                                <?= h($file->file_name.'.'.$file->file_type) ?>
                            </a>                 
                            </div>
                        </div>
                    </div>
            <?php 
                    }
                } else { 
            ?>
                None.
            <?php 
                } 
            ?>
        </div>
        <div class="row mt">
            <div class="col-xs-12">
                <h4>Tasks</h4>
                <table class="table table-striped table-advance table-hover">
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
                        <td><strong style="font-size: 20px;"><?= h($milestone->title) ?></strong></td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?=isset($milestonesProgress[$milestone->id])?$milestonesProgress[$milestone->id]: 0 ?>"
                                     aria-valuemin="0" aria-valuemax="100" style="margin-right: -<?=isset($milestonesProgress[$milestone->id])?$milestonesProgress[$milestone->id]: 0 ?>%;
                                    width: <?=isset($milestonesProgress[$milestone->id])?$milestonesProgress[$milestone->id]: 0 ?>%">
                                </div>
                                <div style="text-align:center; color:black;"><?= h(number_format(isset($milestonesProgress[$milestone->id])?$milestonesProgress[$milestone->id]: 0, 2)).'% Complete'?></div>
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
                                        <td><?= h(date_format($task->start_date,"F d, Y")) ?></td>
                                        <td><?= h(date_format($task->end_date,"F d, Y")) ?> </td>
                                        <td>
                                            <span class='task-status <?=str_replace(' ', '-', strtolower($task->status))?>'>
                                                <?= h($task->status) ?>
                                            </span>
                                        </td>
                                        <td class="actions">     
                                        <?php 
                                            if(!$task->is_finished){ 
                                                echo $this->dataTableViewButton(__('View'), 
                                                    ['controller' => 'Tasks', 'action' => 'view', $task->id, '?' => ['project_id' => $project->id]]);
                                            } else { 
                                                echo $this->dataTableViewButton(__('View'), 
                                                    ['controller' => 'Tasks', 'action' => 'ViewFinished', $task->id, '?' => ['project_id' => $project->id]]);  
                                            }
                                        ?>
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
            </div><!-- /col-md-12 -->
        </div><
    </div>
</div>


<div id="finish-project" class="modal fade" role="dialog">
  <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Finish Project</h4>
        </div>
        <div class="modal-body">
            Do you want to mark the project as finished?
        </div>
        <div class="modal-footer" >
            <button type="button" data-dismiss="modal" class="btn btn-primary" id="finish-project-confirm">Finish Project</button>
            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
        </div>
    </div>
</div>


<div id="change-phase" class="modal fade" role="dialog">
  <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Change Project Phase</h4>
        </div>
        <div class="modal-body">
            <?= $this->Form->input('phase', [
                    'class' => 'form-control',
                    'label' => [ 
                        'class' => 'mt'
                    ],
                    'options' => $projectPhases
                ]);?>
        </div>
        <div class="modal-footer" >
            <button type="button" data-dismiss="modal" class="btn btn-success" id="change-phase-confirm">Update Phase</button>
            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
        </div>
    </div>
</div>


