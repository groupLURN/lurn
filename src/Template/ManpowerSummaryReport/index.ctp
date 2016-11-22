<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Manpower Summary Report') ?>
<div class="row mt">
    <div class="col-xs-12">

        <?= $this->Form->button('<i class="fa fa-save"></i> Save as PDF', 
            array('onclick' => "location.href='" . $this->Url->build('/manpower-summary-report/view/'.$project->id.'/1.pdf')."'", 'class' => 'btn btn-primary')); ?>
        <?= $this->Form->button('<i class="fa fa-print"></i> Print', 
            array('onclick' => "location.href='" . $this->Url->build('/manpower-summary-report/view/'.$project->id.'/0.pdf')."'", 'class' => 'btn btn-warning')); ?>
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


                                $duration += $taskDuration->d;
                            }

                            echo $duration;
                        ?>
                        </td>
                        <td class="text-center"><?= date_format($milestone->start_date,"F d, Y") ?></td>
                        <td class="text-center"><?= date_format($milestone->end_date > $milestone->modified ? $milestone->end_date : $milestone->modified,"F d, Y")  ?></td>
                        <td></td>
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
                </tbody>
            </table>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div>