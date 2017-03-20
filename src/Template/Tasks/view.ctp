
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