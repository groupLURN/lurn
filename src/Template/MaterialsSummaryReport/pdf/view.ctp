<?= $this->assign('title', 'Materials Summary Report') ?>

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

                    echo $duration->days;
                ?>
                </td>
                <td class="text-center"><?= date_format($task->start_date,"F d, Y") ?></td>
                <td class="text-center"><?= date_format($task->end_date > $task->modified ? $task->end_date : $task->modified,"F d, Y")  ?></td>
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