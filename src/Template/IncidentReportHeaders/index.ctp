<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Incident Reports') ?>
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
            <li>
                <a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventories', 'action' => 'index', 'action' => '/', $projectId]) ?>>
                    <i class="fa fa-database"></i>
                    <span>Project Inventories</span>
                </a>
            <?php
                }

                if (in_array($employeeType, [0, 1, 2, 4], true)) {
            ?>
            <li class="active">
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
                <li class="active">
                    <a href=<?= $this->Url->build(['controller' => 'IncidentReportHeaders', 'action' => 'index', '?' => ['project_id' => $projectId]]) ?>>
                        <span>
                        Incident Reports
                        </span>
                    </a>
                </li>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventoryReport', 'action' => 'index', $projectId]) ?>>
                        <span>
                        Equipment Inventory Report
                        </span>
                    </a>
                </li>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'MaterialsProjectInventoryReport', 'action' => 'index', $projectId]) ?>>
                        <span>
                        Materials Inventory Report
                        </span>
                    </a>
                </li>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'ManpowerProjectInventoryReport', 'action' => 'index', $projectId]) ?>>
                        <span>
                        Manpower Inventory Report
                        </span>
                    </a>
                </li>
                <?php 
                    if ($isFinished == 1) {
                ?>
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'SummaryReport', 'action' => 'index', $projectId]) ?>>
                            <span>
                            Summary Report
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'EquipmentSummaryReport', 'action' => 'index', $projectId]) ?>>
                            <span>
                            Equipment Summary Report
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'MaterialsSummaryReport', 'action' => 'index', $projectId]) ?>>
                            <span>
                            Materials Summary Report
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'ManpowerSummaryReport', 'action' => 'index', $projectId]) ?>>
                            <span>
                            Manpower Summary Report
                            </span>
                        </a>
                    </li>
                <?php 
                    }
                ?>
                </ul>
        <!-- end of sub tabs -->
    </div>
</div>
<!-- end of tabs -->

<?php
    if (in_array($employeeType, [0, 1, 2, 4], true)) {
?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('Create Incident Report'), ['action' => 'add', '?' => ['project_id' => $projectId]]); ?>
    </div>
</div>
<?php
    }
?>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i> <?= __('Incident Reports') ?> </h4>
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('project_id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('project_engineer') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($incidentReportHeaders as $incidentReportHeader): ?>
                    <tr>
                        <td><?= $this->Number->format($incidentReportHeader->id) ?></td>
                        <td><?= $this->Html->link($incidentReportHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $incidentReportHeader->project->id]) ?></td>
                        <td><?= h($incidentReportHeader->project_engineer->name) ?></td>
                        <td><?= h($incidentReportHeader->type_full) ?></td>
                        <td><?= h(date_format($incidentReportHeader->date,"F d, Y"))?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $incidentReportHeader->id,'?' => ['project_id' => $projectId]]); ?>

                            <?php
                                if (in_array($employeeType, [0, 1, 2, 4], true)) {
                                    echo $this->dataTableEditButton(__('Edit'), ['action' => 'edit', $incidentReportHeader->id,'?' => ['project_id' => $projectId]]); 
                                    echo ' ';
                                    echo $this->dataTableDeleteButton(__('Delete'),
                                        ['action' => 'delete', $incidentReportHeader->id, '?' => ['project_id' => $projectId]],
                                        __('Are you sure you want to delete invident report {0}?', $incidentReportHeader->id)
                                    );
                                }
                            ?>
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
    </div>
</div>
