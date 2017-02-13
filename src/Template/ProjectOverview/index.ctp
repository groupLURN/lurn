<?= $this->assign('title', 'Project Overview') ?> <!-- Trigger the modal with a button -->

<?= $this->Flash->render()?>

<div class="row mt">
    <div class="col-xs-12">

    <?php if ($project->is_finished == 0 && $project->phase == 4):?>        
        <?= $this->Form->create('', ['id' => 'finish-form', 'url' => ['action' => 'finish-project', $projectId]]) ?>
        <?= $this->Form->button('<i class="fa fa-save"></i> Finish Project', ['class' => 'btn btn-primary', 'id'=>'finish-form-submit']); ?>
        <?= $this->Form->end() ?>
    <?php endif;?>
    
    <?php if ($project->is_finished == 0):?>
        <?= $this->Form->create('', ['id' => 'change-phase-form', 'url' => ['action' => 'change-phase', $projectId]]) ?>
            <?= $this->Form->button('<i class="fa fa-wrench"></i> Change Phase', ['class' => 'btn btn-success', 'id'=>'change-phase-submit']); ?>
        <?= $this->Form->end() ?>
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
            <td><?= h(date_format($project->start_date, 'F d, Y')) ?></td>
        </tr>
        <tr>
            <th><?= __('End Date') ?></th>
            <td><?= h(date_format($project->end_date, 'F d, Y')) ?></td>
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
                        <td><?= h(date_format($employees_join->employment_date, 'F d, Y')) ?></td>
                        <td><?= h(isset($employees_join->termination_date) ? date_format($employees_join->termination_date, 'F d, Y') : '') ?></td>
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
            <button type="button" data-dismiss="modal" class="btn btn-primary" id="change-phase-confirm">Update Phase</button>
            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
        </div>
    </div>
</div>


