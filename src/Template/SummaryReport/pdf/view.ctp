<?= $this->assign('title', 'Equipment Summary Report') ?>

<div class="mt">
    <h4>Equipment</h4>
</div>
<table class="table report summary-report">
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


                    $duration += $taskDuration->d;
                }

                echo $duration;
            ?>
            </td>
            <td class="text-center"><?= date_format($milestone->start_date,"F d, Y") ?></td>
            <td class="text-center"><?= date_format($milestone->end_date > $milestone->modified ? $milestone->end_date : $milestone->modified,"F d, Y")  ?></td>
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

                    echo $duration->d;
                ?>
                </td>
                <td class="text-center"><?= date_format($task->start_date,"F d, Y") ?></td>
                <td class="text-center"><?= date_format($task->end_date > $task->modified ? $task->end_date : $task->modified,"F d, Y")  ?></td>
                <td></td>
                <?php foreach ($equipment as $key => $value) { ?>
                    <td class="text-center"><?= isset($task->equipment[$key]->quantity)? $task->equipment[$key]->quantity : '' ?></th>
                <?php }?>
            </tr>
        <?php 

            $taskIndex++;
            }

            $milestoneIndex++;
        }
    ?>
</table>
<div class="mt">
    <h4>Materials</h4>
</div>
<table class="table report summary-report">
    <tr>
        <th class="text-center" colspan="6"></th>
        <th class="text-center" colspan=<?= count($materials)?>><?= __('Total Quantity')?></th>
    </tr>
    <tr>
        <th class="text-center"></th>
        <th class="text-center"><?= __('Activity Description') ?></th>
        <th class="text-center"><?= __('Duration (Days)') ?></th>
        <th class="text-center"><?= __('Start Date') ?></th>
        <th class="text-center"><?= __('Finish Date')?></th>
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


                    $duration += $taskDuration->d;
                }

                echo $duration;
            ?>
            </td>
            <td class="text-center"><?= date_format($milestone->start_date,"F d, Y") ?></td>
            <td class="text-center"><?= date_format($milestone->end_date > $milestone->modified ? $milestone->end_date : $milestone->modified,"F d, Y")  ?></td>
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

                    echo $duration->d;
                ?>
                </td>
                <td class="text-center"><?= date_format($task->start_date,"F d, Y") ?></td>
                <td class="text-center"><?= date_format($task->end_date > $task->modified ? $task->end_date : $task->modified,"F d, Y")  ?></td>
                <td></td>
                <?php foreach ($materials as $key => $value) { ?>
                    <td class="text-center"><?= isset($task->materials[$key]->quantity)? $task->materials[$key]->quantity : '' ?></th>
                <?php }?>
            </tr>
        <?php 

            $taskIndex++;
            }

            $milestoneIndex++;
        }
    ?>
</table>
<div class="mt">
    <h4>Manpower</h4>
</div>
<table class="table report summary-report">
    <tr>
        <th class="text-center" colspan="6"></th>
        <th class="text-center" colspan=<?= count($manpower)-2?>><?= __('Manpower')?></th>
    </tr>
    <tr>
        <th class="text-center" colspan="6"></th>
        <th class="text-center" colspan=<?= $manpower['skilledWorkers']?>><?= __('Skilled Workers')?></th>
        <th class="text-center" colspan=<?= $manpower['laborers']?>><?= __('Laborers')?></th>
    </tr>
    <tr>
        <th class="text-center"></th>
        <th class="text-center"><?= __('Activity Description') ?></th>
        <th class="text-center"><?= __('Duration (Days)') ?></th>
        <th class="text-center"><?= __('Start Date') ?></th>
        <th class="text-center"><?= __('Finish Date')?></th>
        <th class="text-center rotate"><div><span><?= __('Name')?></span></div></th>
        <?php foreach ($manpower as $person) { 
            if(isset($person->name)){
                if($person->manpower_type_id === 1){
            ?>

            <th class="rotate"><div><span><?= $person->name?></span></div></th>
        <?php 
                }
            }
        }?>
        <?php foreach ($manpower as $person) { 
            if(isset($person->name)){
                if($person->manpower_type_id === 2){
            ?>

            <th class="rotate"><div><span><?= $person->name?></span></div></th>
        <?php 
                }
            }
        }?>
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


                    $duration += $taskDuration->d;
                }

                echo $duration;
            ?>
            </td>
            <td class="text-center"><?= date_format($milestone->start_date,"F d, Y") ?></td>
            <td class="text-center"><?= date_format($milestone->end_date > $milestone->modified ? $milestone->end_date : $milestone->modified,"F d, Y")  ?></td>
            <td></td>
            <td class="text-center" colspan=<?= count($manpower)-2?>></td>
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

                    echo $duration->d;
                ?>
                </td>
                <td class="text-center"><?= date_format($task->start_date,"F d, Y") ?></td>
                <td class="text-center"><?= date_format($task->end_date > $task->modified ? $task->end_date : $task->modified,"F d, Y")  ?></td>
                <td></td>
                <?php foreach ($manpower as $key => $value) { 
                    if($key != 'laborers' && $key != 'skilledWorkers'){
                ?>
                    <td class="text-center"><?= isset($task->manpower[$key])? '&times;' : '' ?></th>
                <?php 
                    }
                }?>
            </tr>
        <?php 

            $taskIndex++;
            }

            $milestoneIndex++;
        }
    ?>
</table>