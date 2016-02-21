<?php
$this->assign('title', 'Project Planning');
$this->extend('/Layout/default');
$this->start('additional-sidebar');
?>
<li class="sub-menu">
    <a href="/project-overview/index/<?= $project_id ?>" >
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
        <li><a href="/project-planning/create-gantt-chart/<?= $project_id ?>">Create Gantt Chart</a></li>
    </ul>
    <ul class="sub">
        <li><a href="/project-planning/manage-tasks-and-resources/<?= $project_id ?>">Manage Tasks & Resources</a></li>
    </ul>
</li>
<?php $this->end(); ?>
<?= $this->fetch('content'); ?>
