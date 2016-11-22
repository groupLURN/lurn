<?= $this->assign('title', 'Project Overview') ?> <!-- Trigger the modal with a button -->

<div class="row mt">
    <div class="col-xs-12">

    <?php if ($project->is_finished == 0):?>

        <?= $this->Form->button('<i class="fa fa-save"></i> Finish Project', 
            array('class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target'=>'#finish-project')); ?>
    <?php endif;?>

    </div>
</div>
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
            <th><?= __('Project Status') ?></th>
            <td><?= h($project->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Project Manager') ?></th>
            <td><?= $this->Html->link($project->employee->name, ['controller' => 'employees', 'action' => 'view', $project->employee->id]) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Date') ?></th>
            <td><?= h($project->start_date) ?></td>
        </tr>
        <tr>
            <th><?= __('End Date') ?></th>
            <td><?= h($project->end_date) ?></td>
        </tr>
    </table>

    <div class="related">
        <h3><?= __('Core Team') ?></h3>
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
                        <td><?= h($employees_join->employment_date) ?></td>
                        <td><?= h($employees_join->termination_date) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>


<div id="finish-project" class="modal fade" role="dialog">
  <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
            Do you want to mark the project as finished?
        </div>
        <div class="modal-footer" >
            <button type="button" data-dismiss="modal" class="btn btn-primary" onClick="finishProject()">Finish Project</button>
            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
        </div>
    </div>
</div>