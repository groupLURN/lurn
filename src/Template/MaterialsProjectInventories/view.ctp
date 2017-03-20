<?= $this->assign('title', 'Material Project Inventory') ?>

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
                <a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventories', 'action' => 'index', $projectId]) ?>>
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

<div class="material view large-9 medium-8 columns content">
    <h3><?= h($summary->name) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Material Name') ?></th>
            <td><?= h($summary->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Unit Measure') ?></th>
            <td><?= h($summary->unit_measure) ?></td>
        </tr>
        <tr>
            <th><?= __('Available Quantity') ?></th>
            <td><?= h($summary->available_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Unavailable Quantity') ?></th>
            <td><?= h($summary->unavailable_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Total Quantity') ?></th>
            <td><?= h($summary->available_quantity + $summary->unavailable_quantity) ?></td>
        </tr>
    </table>
</div>

<div class="related">
    <h4><?= __('Track Unavailable Materials') ?></h4>
    <?php if (!empty($material->materials_task_inventories)): ?>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= h('Milestone') ?></th>
                <th><?= h('Task') ?></th>
                <th><?= h('Start Date') ?></th>
                <th><?= h('End Date') ?></th>
                <th>Status</th>
                <th><?= __('Quantity Assigned') ?></th>
            </tr>
            <?php foreach ($material->materials_task_inventories as $taskInventory): ?>
                <tr>
                    <td><?= h($taskInventory->task->milestone->title) ?></td>
                    <td><?= h($taskInventory->task->title) ?></td>
                    <td><?= h($taskInventory->task->start_date) ?></td>
                    <td><?= h($taskInventory->task->end_date) ?></td>
                    <td>
                        <span class='task-status <?=str_replace(' ', '-', strtolower($taskInventory->task->status))?>'>
                            <?= h($taskInventory->task->status) ?>
                        </span>
                    </td>
                    <td><?= $this->Number->format($taskInventory->quantity) ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>