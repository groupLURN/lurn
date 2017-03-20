<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Equipment Summary Report') ?>
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
                <li>
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
                    <li class="active">
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
<div class="row mt">
    <div class="col-xs-12">

        <?= $this->Form->button('<i class="fa fa-save"></i> Save as PDF', 
            ['onclick' => "location.href='" 
            . $this->Url->build(['action' => 'view', $project->id, '1.pdf'])
            . "'", 'class' => 'btn btn-primary']); ?>
        <?= $this->Form->button('<i class="fa fa-print"></i> Print', 
            ['onclick' => "location.href='"
            . $this->Url->build(['action' => 'view', $project->id, '0.pdf'])
            . "'", 'class' => 'btn btn-warning']); ?>
        </div>
    </div>
</div>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel" style="padding:20px">
            <?= $this->Html->image('logo.jpg', array('class' => 'float-right')) ?>
            <h5>
                <?= h($project->title) ?><br>
                <?= $project->has('client') ? $this->Html->link($project->client->company_name, ['controller' => 'Clients', 'action' => 'view', $project->client->id]) : '' ?><br>
                <?= $this->fetch('title') ?><br>
                J.I. Espino Construction<br>
                <?= $this->Html->link($project->employee->name, ['controller' => 'employees', 'action' => 'view', $project->employee->id]) ?><br>
                <?= h($project->location) ?><br>
            </h5>
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" colspan="6"></th>
                        <th class="text-center" colspan=<?= count($equipment)?>><?= __('Total Quantity')?></th>
                    </tr>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center"><?= __('Activity Description') ?></th>
                        <th class="text-center"><?= __('Duration (Days)') ?></th>
                        <th class="text-center"><?= __('Start Date') ?></th>
                        <th class="text-center"><?= __('Finish Date')?></th>
                        <th class="text-center rotate"><div><span><?= __('Equipment Used')?></th>
                        <?php foreach ($equipment as $equipmentName) { ?>
                        <th class="rotate"><div><span><?= $equipmentName->name?></span></div></th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $milestoneIndex = 'A';
                    foreach ($project->milestones as $milestone){
                        ?>
                        <tr>
                            <td class="text-left"><?= $milestoneIndex ?></td>
                            <td class="text-left"><?= $milestone->title ?></td>
                            <td class="text-center">
                                <?php
                                $duration = 0;

                                foreach ($milestone->tasks as $task){                                
                                    $date1 = null;

                                    $date2 = $task->start_date;
                                    if($task->end_date > $task->modified){
                                        $date1 = new DateTime($task->end_date);
                                    } else {
                                        $date1 = new DateTime($task->modified);
                                    }

                                    $taskDuration = date_diff($date1,$date2);


                                    $duration += $taskDuration->days;
                                }

                                echo $duration;
                                ?>
                            </td>
                            <td class="text-center"><?= date_format($milestone->start_date,"F d, Y") ?></td>
                            <td class="text-center">

                                <?php
                                $endDate = null;

                                foreach ($milestone->tasks as $task){

                                    if($endDate !== null || $task->end_date > $task->modified){
                                        $endDate = new DateTime($task->end_date);
                                    } else {
                                        $endDate = new DateTime($task->modified);
                                    }
                                }

                                echo date_format($endDate,"F d, Y");
                                ?>
                            </td>
                            <td></td>
                        </tr>

                        <?php 
                        $taskIndex = 1;
                        foreach ($milestone->tasks as $task){
                            ?>
                            <tr>
                                <td class="text-right"><?= $taskIndex ?></td>
                                <td class="text-left"><?= $task->title ?></td>
                                <td class="text-center">
                                    <?php
                                    $date1 = null;

                                    $date2 = $task->start_date;
                                    if($task->end_date > $task->modified){
                                        $date1 = new DateTime($task->end_date);
                                    } else {
                                        $date1 = new DateTime($task->modified);
                                    }

                                    $duration = date_diff($date1,$date2);

                                    echo $duration->days;
                                    ?>
                                </td>
                                <td class="text-center"><?= date_format($task->start_date,"F d, Y") ?></td>
                                <td class="text-center"><?= date_format($task->end_date > $task->modified ? $task->end_date : $task->modified,"F d, Y")  ?></td>
                                <td></td>
                                <?php foreach ($equipment as $key => $value) { ?>
                                <td class="text-center"><?= isset($task->equipment[$key]->quantity)? $task->equipment[$key]->quantity : '' ?></td>
                                    <?php }?>
                                </tr>
                                <?php 

                                $taskIndex++;
                            }

                            $milestoneIndex++;
                        }
                        ?>
                    </tbody>
                </table>
            </div><!-- /content-panel -->
        </div><!-- /col-md-12 -->
    </div>