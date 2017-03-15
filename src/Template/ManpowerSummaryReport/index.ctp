<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Manpower Summary Report') ?>
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
                        <th class="text-center" colspan=<?= count($manpower['skilledWorkers']) + count($manpower['laborers'])?>>
                        <?= __('Manpower')?>
                            
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center"><?= __('Activity Description') ?></th>
                        <th class="text-center"><?= __('Duration (Days)') ?></th>
                        <th class="text-center"><?= __('Start Date') ?></th>
                        <th class="text-center"><?= __('Finish Date')?></th>
                        <th class="rotate"><div><span>Name</span></div></th>
                        <?php foreach ($manpower['skilledWorkers'] as $person) { 
                            if(isset($person->name)){
                                if($person->manpower_type_id === 1){
                            ?>

                            <th class="rotate"><div><span><?= $person->name?></span></div></th>
                        <?php 
                                }
                            }
                        }?>
                        <?php foreach ($manpower['laborers'] as $person) { 
                            if(isset($person->name)){
                                if($person->manpower_type_id === 2){
                            ?>

                            <th class="rotate"><div><span><?= $person->name?></span></div></th>
                        <?php 
                                }
                            }
                        }?>
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
                            <td class="text-center" colspan=<?= count($manpower['skilledWorkers']) + count($manpower['laborers']) ?>></td>
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
                                <?php 
                                    foreach ($manpower['skilledWorkers'] as $person) {
                                ?>
                                    <td>
                                    <?php     
                                        $mark = ' ';                               
                                        foreach ($task->manpower_per_task as $manpowerPerTask) {
                                            if ($person->id === $manpowerPerTask->id) {
                                                $mark = '&times;';
                                                break;
                                            }
                                        }
                                        echo $mark;
                                    ?>
                                    </td>
                                <?php
                                    }

                                    foreach ($manpower['laborers'] as $person) { 
                                ?>
                                    <td>
                                    <?php     
                                        $mark = ' ';                               
                                        foreach ($task->manpower_per_task as $manpowerPerTask) {
                                            if ($person->id === $manpowerPerTask->id) {
                                                $mark = '&times;';
                                                break;
                                            }
                                        }
                                        echo $mark;
                                    ?>
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
                </tbody>
            </table>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div>