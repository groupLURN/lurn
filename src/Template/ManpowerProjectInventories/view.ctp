<?= $this->assign('title', 'Manpower Project Inventory') ?>
<?= $this->Html->script('tasks', ['block' => 'script-end']) ?>
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
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'MaterialsProjectInventories', 'action' => 'index', $projectId]) ?>>
                    <span>
                    Materials Inventory
                    </span>
                    </a>
                </li>
                <li class="active">
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

<div class="manpower view large-9 medium-8 columns content">
    <h3><?= h($summary->manpower_type->title) ?></h3>
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
        <h4><?= __('Track Available Manpower') ?></h4>
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
        <h4><?= __('Track Unavailable Manpower') ?></h4>
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