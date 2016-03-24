<?php
$this->extend('/Layout/base');
$this->start('additional-sidebar');
?>
<li class="sub-menu">
    <a href="/project-overview/index/<?= $projectId ?>" >
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
        <li><a href="/project-planning/create-gantt-chart/<?= $projectId ?>">Gantt Chart</a></li>
    </ul>
    <ul class="sub">
        <li><a href="/tasks?project_id=<?= $projectId ?>">Tasks</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;">
        <i class="fa fa-recycle"></i>
        <span>Project Implementation</span>
    </a>
    <ul class="sub">
        <li><a href="<?= $this->Url->build(['controller' => 'TaskReplenishmentHeaders', 'action' => 'index', '?' => [
                'project_id' => $projectId
            ]]) ?>">Task Management</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-database"></i>
        <span>Project Inventories</span>
    </a>
    <ul class="sub">
        <li><a  href="/equipment-project-inventories?project_id=<?= $projectId ?>">Equipment Inventory</a></li>
        <li><a  href="/materials-project-inventories?project_id=<?= $projectId ?>">Materials Inventory</a></li>
        <li><a  href="/manpower-project-inventories?project_id=<?= $projectId ?>">Manpower Inventory</a></li>
    </ul>
</li>
<?php $this->end(); ?>
<?= $this->fetch('content'); ?>
