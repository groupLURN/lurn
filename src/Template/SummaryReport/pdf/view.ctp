<?= $this->assign('title', 'Summary Report')?>
<div class="mt">
    <h4><?= __('Project Details') ?></h4>             
</div>          
<table class="table text-left reset-paragraph">
    <tr>
        <th><?= __('Title') ?></th>
        <td><?= h($project->title) ?></td>
    </tr>
    <tr>
        <th><?= __('Description') ?></th>
        <td><?= $this->Text->autoParagraph(h($project->description)); ?></td>
    </tr>
    <tr>
        <th><?= __('Location') ?></th>
        <td><?= h($project->location) ?></td>
    </tr>
    <tr>
        <th><?= __('Client') ?></th>
        <td><?= $project->has('client') ? h($project->client->company_name) : '' ?></td>
    </tr>
    <tr>
        <th><?= __('Project Manager') ?></th>
        <td><?= h($project->employee->name) ?></td>
    </tr>
    <tr>
        <th><?= __('Start Date') ?></th>
        <td><?= h(date_format($project->start_date, 'F d, Y')) ?></td>
    </tr>
    <tr>
        <th><?= __('End Date') ?></th>
        <td><?= h(date_format($project->end_date, 'F d, Y')) ?></td>
    </tr>
</table>

<div class="mt">
    <h4><?= __('Core Team') ?></h4>         
</div>     
<?php if (!empty($project->employees_join)): ?>
    <table cellpadding="0" cellspacing="0" class="table test-left">
        <tr>
            <th><?= __('Name') ?></th>
            <th><?= __('Employee Type') ?></th>
            <th><?= __('Employment Date') ?></th>
            <th><?= __('Termination Date') ?></th>
        </tr>
        <?php foreach ($project->employees_join as $employees_join): ?>
            <tr>
                <td><?= h($employees_join->name) ?></td>
                <td><?= h($employees_join->employee_type->title) ?></td>
                <td><?= h(date_format($employees_join->employment_date, 'F d, Y')) ?></td>
                <td><?= h(isset($employees_join->termination_date) ? date_format($employees_join->termination_date, 'F d, Y') : '') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<div class="page-break"> 
</div> 

<div class="mt">
    <h4><?= __('Milestones and Tasks') ?></h4>         
</div> 

<table class="table report summary-report"> 
    <tr>
        <th class="text-center"></th>
        <th class="text-center"><?= __('Activity Description') ?></th>
        <th class="text-center"><?= __('Duration (Days)') ?></th>
        <th class="text-center"><?= __('Start Date') ?></th>
        <th class="text-center"><?= __('Finish Date')?></th>
    </tr>
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
            </tr>
            <?php 

            $taskIndex++;
        }

        $milestoneIndex++;
    }
    ?>
</table>

<div class="page-break"> 
</div> 

<div class="mt">
    <h4>Equipment</h4>
</div>

<table class="table report summary-report">
    <tr>
        <th class="text-center" colspan="3"></th>
        <th class="text-center" colspan=<?= count($equipment)?>><?= __('Total Quantity')?></th>
    </tr>
    <tr>
        <th class="text-center"></th>
        <th class="text-center"><?= __('Activity Description') ?></th>
        <th class="text-center rotate"><div><span><?= __('Equipment Used')?></span></div></th>
        <?php foreach ($equipment as $equipmentName) { ?>
            <th class="rotate"><div><span><?= $equipmentName->name?></span></div></th>
        <?php }?>
    </tr>
    <?php 
        $milestoneIndex = 'A';
        foreach ($project->milestones as $milestone){
    ?>
        <tr>
            <td class="text-left"><?= $milestoneIndex ?></td>
            <td class="text-left"><?= $milestone->title ?></td>
            <td></td>            
        	<td class="text-center" colspan=<?= count($equipment)?>></td>
        </tr>

        <?php 
            $taskIndex = 1;
            foreach ($milestone->tasks as $task){
            ?>
            <tr>
                <td class="text-right"><?= $taskIndex ?></td>
                <td class="text-left"><?= $task->title ?></td>
                <td></td>
                <?php foreach ($equipment as $key => $value) { ?>
                    <td class="text-center"><?= isset($task->equipment[$key]->quantity)? $task->equipment[$key]->quantity : '' ?>
                    </td>
                <?php }?>
            </tr>
        <?php 

            $taskIndex++;
            }

            $milestoneIndex++;
        }
    ?>
</table>
<div class="page-break"> 
</div> 
<div class="mt">
    <h4>Materials</h4>
</div>
<table class="table report summary-report">
    <tr>
        <th class="text-center" colspan="3"></th>
        <th class="text-center" colspan=<?= count($materials)?>><?= __('Total Quantity')?></th>
    </tr>
    <tr>
        <th class="text-center"></th>
        <th class="text-center"><?= __('Activity Description') ?></th>
        <th class="text-center rotate"><div><span><?= __('Materials Used')?></span></div></th>
        <?php foreach ($materials as $material) { ?>
            <th class="rotate"><div><span><?= $material->name?></span></div></th>
        <?php }?>
    </tr>
    <?php 
        $milestoneIndex = 'A';
        foreach ($project->milestones as $milestone){
    ?>
        <tr>
            <td class="text-left"><?= $milestoneIndex ?></td>
            <td class="text-left"><?= $milestone->title ?></td>
            <td></td>
            <td class="text-center" colspan=<?= count($materials)?>></td>
        </tr>

        <?php 
            $taskIndex = 1;
            foreach ($milestone->tasks as $task){
            ?>
            <tr>
                <td class="text-right"><?= $taskIndex ?></td>
                <td class="text-left"><?= $task->title ?></td>
                <td></td>
                <?php foreach ($materials as $key => $value) { ?>
                    <td class="text-center"><?= isset($task->materials[$key]->quantity)? $task->materials[$key]->quantity : '' ?>
                    </td>
                <?php }?>
            </tr>
        <?php 

            $taskIndex++;
            }

            $milestoneIndex++;
        }
    ?>
</table>
<div class="page-break"> 
</div> 
<div class="mt">
    <h4>Manpower</h4>
</div>
<table class="table report summary-report">
    <tr>
        <th class="text-center" colspan="2"></th>
        <th class="text-center" colspan=<?= count($manpowerTypes)?>><?= __('Manpower')?></th>
    </tr>
    <tr>
        <th class="text-center"></th>
        <th class="text-center"><?= __('Activity Description') ?></th>
        <th class="text-center"><?= __('Skilled Workers')?></th>
        <th class="text-center"><?= __('Laborers')?></th>
    </tr>
    <?php 
    $milestoneIndex = 'A';
    foreach ($project->milestones as $milestone){
        ?>
        <tr>
            <td class="text-left"><?= $milestoneIndex ?></td>
            <td class="text-left"><?= $milestone->title ?></td>
            <td class="text-center" colspan=<?= count($manpowerTypes)?>></td>
        </tr>

        <?php 
        $taskIndex = 1;
        foreach ($milestone->tasks as $task){
            ?>
            <tr>
                <td class="text-right"><?= $taskIndex ?></td>
                <td class="text-left"><?= $task->title ?></td>
                <?php 
                foreach ($manpowerTypes as $manpowerType) { 
                    ?>
                    <td class="text-center">
                    <?= isset($task->manpower[$manpowerType->title]) ? $task->manpower[$manpowerType->title] : '&nbsp;' ?>
                    </td>
                    <?php 
                }
                ?>
            </tr>
            <?php 

            $taskIndex++;
        }

        $milestoneIndex++;
    }
    ?>
</table>