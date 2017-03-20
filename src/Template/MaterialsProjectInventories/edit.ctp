<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Materials Project Inventory') ?>
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
            <li>
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
            <li class="active">
                <a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventories', 'action' => 'index', 'action' => '/', $projectId]) ?>>
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
    <div class="col-xs-12 mt">
        <!-- start of sub tabs -->
            <ul class="nav nav-tabs">
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventories', 'action' => 'index', $projectId]) ?>>
                    <span>
                    Equipment Inventory
                    </span>
                    </a>
                </li>
                <li class="active">
                    <a href=<?= $this->Url->build(['controller' => 'MaterialsProjectInventories', 'action' => 'index', $projectId]) ?>>
                    <span>
                    Materials Inventory
                    </span>
                    </a>
                </li>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'ManpowerProjectInventories', 'action' => 'index', $projectId]) ?>>
                    <span>
                    Manpower Inventory
                    </span>
                    </a>
                </li>
            </ul>

        <!-- end of sub tabs -->
    </div>
</div>
<!-- end of tabs -->

<div class="row">
    <div class="col-md-12">
        <?= $this->Form->create($materialsProjectInventory) ?>
        <fieldset>
            <h3><?= __('Adjust Inventory') ?></h3>        
            <?php

            echo $this->Form->input('quantity', [
                'type' => 'text',
                'class' => 'form-control number-only',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Available Quantity'
                ],
            ]);

            ?>
        </fieldset>

        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>