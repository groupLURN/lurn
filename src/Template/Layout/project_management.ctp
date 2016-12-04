<?php
$this->extend('/Layout/base');
$this->start('additional-sidebar');
?>
<li class="sub-menu">
    <a href=<?= $this->Url->build(['controller' => 'ProjectOverview', $projectId]) ?>>
        <i class="fa fa-book"></i>
        <span>Project Overview</span>
    </a>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-building"></i>
        <span>Project Planning</span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'ProjectPlanning', 'action' => 'CreateGanttChart', $projectId]) ?>>Gantt Chart</a></li>
    </ul>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'index', '?' => ['project_id' => $projectId]]) ?>>Tasks</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;">
        <i class="fa fa-recycle"></i>
        <span>Project Implementation</span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'manage', '?' => ['project_id' => $projectId]]) ?>>Task Management</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-database"></i>
        <span>Project Inventories</span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventories', '?' => ['project_id' => $projectId]]) ?>>Equipment Inventory</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'MaterialsProjectInventories', '?' => ['project_id' => $projectId]]) ?>>Materials Inventory</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'ManpowerProjectInventories', '?' => ['project_id' => $projectId]]) ?>>Manpower Inventory</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-file"></i>
        <span>Inventory Reports</span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventoryReport', '?' => ['project_id' => $projectId]]) ?>>Equipment Inventory Report</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'MaterialsProjectInventoryReport', '?' => ['project_id' => $projectId]]) ?>>Materials Inventory Report</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'ManpowerProjectInventoryReport', '?' => ['project_id' => $projectId]]) ?>>Manpower Inventory Report</a></li>
    </ul>
</li>
<?php if ($project->is_finished):?>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-file"></i>
        <span>Summary Reports</span>
    </a>
        <ul class="sub">
            <li><a href=<?= $this->Url->build(['controller' => 'EquipmentSummaryReport', 'action' => 'index', $projectId]) ?>>Equipment Summary Report</a></li>
            <li><a href=<?= $this->Url->build(['controller' => 'MaterialsSummaryReport', 'action' => 'index', $projectId]) ?>>Materials Summary Report</a></li>
            <li><a href=<?= $this->Url->build(['controller' => 'ManpowerSummaryReport', 'action' => 'index', $projectId]) ?>>Manpower Summary Report</a></li>
        </ul>
</li>
<?php endif;?>

<li class="sub-menu">
    <span><a href=<?= $this->Url->build(['controller' => 'IncidentReportHeaders', 'action' => 'index', $projectId]) ?>>
    <i class="fa fa-file"></i>Incident Reports</a>
</li>

<span id="project-id"><?= $projectId ?></span>
<?php $this->end(); ?>
<?= $this->fetch('content'); ?>
