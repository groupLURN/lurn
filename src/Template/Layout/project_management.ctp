<?php
$this->extend('/Layout/default');

// Third Party CSS
$this->Html->css('/bower_components/gantt/codebase/dhtmlxgantt', ['block' => true]);
// User-defined CSS
$this->Html->css('gantt-chart', ['block' => true]);

// Third Party Script
$this->Html->script('/bower_components/gantt/codebase/sources/dhtmlxgantt', ['block' => 'script-end']);
// User-defined Script
$this->Html->script('gantt-chart', ['block' => 'script-end']);

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
</li>
<?php $this->end(); ?>
<?= $this->fetch('content'); ?>
