<?php
$this->assign('title', 'Create Gantt Chart');
// Third Party CSS
$this->Html->css('/bower_components/gantt/codebase/dhtmlxgantt', ['block' => true]);
// User-defined CSS
$this->Html->css('gantt-chart', ['block' => true]);

// Third Party Script
$this->Html->script('/bower_components/gantt/codebase/sources/dhtmlxgantt', ['block' => 'script-end']);
// User-defined Script
$this->Html->script('gantt-chart', ['block' => 'script-end']);
?>
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
    <div class="col-xs-12">
        <div class="content-panel">
            <div class='controls_bar'>
                <div class="row">
                    <div class="col-xs-5 col-xs-offset-1">
                        <strong> Zooming: &nbsp; </strong>
                        <label>
                            <input name='scales' onclick='zoom_tasks(this)' type='radio' value='week'>
                            <span>Hours</span></label>
                        <label>
                            <input name='scales' onclick='zoom_tasks(this)' type='radio' value='trplweek'  checked='true'>
                            <span>Days</span></label>
                        <label>
                            <input name='scales' onclick='zoom_tasks(this)' type='radio' value='month'>
                            <span>Weeks</span></label>
                        <label>
                            <input name='scales' onclick='zoom_tasks(this)' type='radio' value='year'>
                            <span>Months</span></label>
                    </div>
                    <div class="col-xs-6" hidden>
                        <div id="filter_hours">
                            <strong> Display: &nbsp; </strong>
                            <label>
                                <input name='scales_filter' onclick='set_scale_units(this)' type='radio' value='full_day'>
                                <span>Full day</span>
                            </label>
                            <label>
                                <input name='scales_filter' onclick='set_scale_units(this)' type='radio' value='work_hours'>
                                <span>Office hours</span>
                            </label>
                        </div>
                        <div id="filter_days">
                            <strong> Display: &nbsp; </strong>
                            <label>
                                <input name='scales_filter' onclick='set_scale_units(this)' type='radio' value='full_week'>
                                <span>Full week</span>
                            </label>
                            <label>
                                <input name='scales_filter' onclick='set_scale_units(this)' type='radio' value='work_week'>
                                <span>Workdays</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->create() ?>
<?= $this->Form->input('data', ['type' => 'hidden']) ?>

<div id="gantt-chart"></div>

<div class="row mt">
    <div class="col-xs-12">
        <?= $this->Form->button(__('Save Changes'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
    </div>
</div>

<?= $this->Form->end() ?>

<script>
    var __ganttData = <?= isset($ganttData)? $ganttData: 'undefined' ?>;
</script>
