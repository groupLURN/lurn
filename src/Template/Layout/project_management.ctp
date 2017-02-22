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
        <li><a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventories', $projectId]) ?>>Equipment Inventory</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'MaterialsProjectInventories', $projectId]) ?>>Materials Inventory</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'ManpowerProjectInventories', $projectId]) ?>>Manpower Inventory</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-file"></i>
        <span>Inventory Reports</span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventoryReport', $projectId]) ?>>Equipment Inventory Report</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'MaterialsProjectInventoryReport', $projectId]) ?>>Materials Inventory Report</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'ManpowerProjectInventoryReport', $projectId]) ?>>Manpower Inventory Report</a></li>
    </ul>
</li>
<?php if ($isFinished == 1):?>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-file"></i>
        <span>Summary Reports</span>
    </a>
        <ul class="sub">
            <li><a href=<?= $this->Url->build(['controller' => 'SummaryReport', $projectId]) ?>>Summary Report</a></li>
            <li><a href=<?= $this->Url->build(['controller' => 'EquipmentSummaryReport', $projectId]) ?>>Equipment Summary Report</a></li>
            <li><a href=<?= $this->Url->build(['controller' => 'MaterialsSummaryReport', $projectId]) ?>>Materials Summary Report</a></li>
            <li><a href=<?= $this->Url->build(['controller' => 'ManpowerSummaryReport', $projectId]) ?>>Manpower Summary Report</a></li>
        </ul>
</li>
<?php endif;?>

<span id="project-id" style="display:none"><?= $projectId ?></span>
<?php $this->end(); ?>
<?= $this->fetch('content'); ?>
