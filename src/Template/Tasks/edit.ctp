<?= $this->Html->script('tasks.js', ['block' => 'script-end']); ?>
<?= $this->Flash->render() ?>
<!-- start of tabs -->
<div class="row mt">
    <div class="col-xs-12">
        <h3>
            <!--
                <span id="project-status-badge" class="
                    <?= $project->status !== 'Delayed' ? 'hidden' : '' ?>
                ">
                    <?= $project->status === 'Delayed' ? '!' : '' ?>
                </span>
            -->
            <?= h($project->title) ?>        
        </h3>
        <ul class="nav nav-tabs mt">
            <li>
                <a href=<?= $this->Url->build(['controller' => 'ProjectOverview', $projectId])?>>
                    <i class="fa fa-book"></i>
                    <span>Project Overview</span>
                </a>      
            </li>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'events', 'action' => 'project-calendar', $projectId])?>>
                    <i class="fa fa-calendar"></i>
                    <span>Events Calendar</span>
                </a>
            </li>
            <?php 
                if (in_array($employeeType, [0, 1, 2, 3], true)) {
            ?>
            <li class="active">
                <a href=<?= $this->Url->build(['controller' => 'ProjectPlanning', 'action' => 'CreateGanttChart', $projectId])?>>
                    <i class="fa fa-building"></i>
                    <span>Project Planning</span>
                </a>
            </li>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'manage', '?' => ['project_id' => $projectId]]) ?>>
                    <i class="fa fa-recycle"></i>
                    <span>Project Implementation</span>
                </a>
            </li>
            <?php 
                }

                if ($employeeType !== '') {
            ?>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventories', $projectId]) ?>>
                    <i class="fa fa-database"></i>
                    <span>Project Inventories</span>
                </a>
            <?php
                }

                if (in_array($employeeType, [0, 1, 2, 4], true)) {
            ?>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'IncidentReportHeaders', 'action' => 'index', '?' => ['project_id' => $projectId]]) ?>>
                    <i class="fa fa-file"></i>
                    <span>Reports</span>
                </a>
            </li>
            <?php 
                }
            ?>
        </ul>
    </div>
    <?php 
        if (in_array($employeeType, [0, 1, 2, 3], true)) {
    ?>
    <div class="col-xs-12 mt">
        <!-- start of sub tabs -->
        <ul class="nav nav-tabs">
            <li>
                <a href=<?= $this->Url->build(['controller' => 'ProjectPlanning', 'action' => 'CreateGanttChart', $projectId]) ?>>
                    <span>
                    Gantt Chart
                    </span>
                </a>
            </li>
            <li class="active">
                <a href=<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'index', '?' => ['project_id' => $projectId]]) ?>>
                    <span>
                    Tasks
                    </span>
                </a>
            </li>
        </ul>  

        <!-- end of sub tabs -->
    </div>
    <?php 
        }
    ?>
</div>
<!-- end of tabs -->
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($task) ?>
        <fieldset>
            <h3><?= __('Assign Resources') ?></h3>
        <?php
            echo $this->Form->input('title', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Task'
                ],
                'disabled' => true
            ]);
            echo $this->Form->input('start_date', [
                'type' => 'text',
                'class' => 'form-control datetime-picker',
                'label' => [
                    'class' => 'mt'
                ],
                'disabled' => true
            ]);
            echo $this->Form->input('end_date', [
                'type' => 'text',
                'class' => 'form-control datetime-picker',
                'label' => [
                    'class' => 'mt'
                ],
                'disabled' => true
            ]);
        ?>
            <div class="row mt">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-4">
                            <h4><?= __('Assign Equipment Needed') ?></h4>
                        <?= $this->element('multi_select_with_input', [
                            'options' => $equipment,
                            'resource' => 'equipment',
                            'values' => $selectedEquipment
                        ]) ?>
                        </div>
                        <div class="col-xs-4">
                            <h4><?= __('Assign Manpower Needed') ?></h4>
                                <?= $this->element('multi_select_with_input', [
                                    'options' => $manpowerTypes,
                                    'resource' => 'manpower_types',
                                    'values' => $selectedManpowerTypes
                                ]) ?>
                        </div>
                        <div class="col-xs-4">
                            <h4><?= __('Assign Materials Needed') ?></h4>
                                <?= $this->element('multi_select_with_input', [
                                    'options' => $materials,
                                    'resource' => 'materials',
                                    'values' => $selectedMaterials
                                ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>