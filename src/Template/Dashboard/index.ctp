<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->
<!--main content start-->
<section >
	<section class="wrapper">

		<div class="apb">
			<!--<h6 class="apd">DASHBOARD</h6>-->
			<h2 class="apc">OVERVIEW</h2>
		</div>

        <hr class="style-eight">
        <div class="row">
        	<div class="col-lg-9 main-chart">     

                <table class="table table-striped table-advance table-hover">
                    <h4><?= __('Projects') ?> </h4>
                    <hr>
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('title') ?></th>
                            <th><?= $this->Paginator->sort('project_manager_id') ?></th>
                            <th><?= $this->Paginator->sort('start_date') ?></th>
                            <th><?= $this->Paginator->sort('end_date') ?></th>
                            <th>Progress</th>
                            <th><?= $this->Paginator->sort('phase') ?></th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><?= h($project->title) ?></td>
                                <td><?= $project->has('employee') ? $this->Html->link($project->employee->name, ['controller' => 'Employees', 'action' => 'view', $project->employee->id]) : '' ?></td>
                                <td><?= h(isset($project->start_date) ? date_format($project->start_date, 'F d, Y') : '') ?></td>
                                <td><?= h(isset($project->end_date) ? date_format($project->end_date, 'F d, Y') : '') ?></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                        aria-valuenow="<?=$project->progress ?>"
                                        aria-valuemin="0" aria-valuemax="100" style="margin-right: -<?=$project->progress ?>%;
                                        width: <?=$project->progress ?>%">
                                    </div>
                                    <div style="text-align:center; color:black;"><?= h(number_format($project->progress, 2)).'% Complete'?></div>
                                </div>
                            </td>
                            <td><?= h($project->project_phase->name) ?></td>
                            <td><?= h($project->status) ?></td>
                            <td class="actions">
                                <?php 
                                    if (in_array($project->id, $assignedProjects) 
                                    && $employeeType == 2 
                                    || in_array($employeeType, [0, 1], true))
                                    {
                                        echo $this->dataTableManageButton(__('Manage'), ['controller' => 'ProjectOverview', 'action' => 'index', $project->id]);  
                                    }
                                ?>
                                <?= $this->dataTableViewButton(__('View'), ['controller' => 'Projects', 'action' => 'view', $project->id]); ?>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>
                </div>
            </div><!-- /col-lg-9 END SECTION MIDDLE -->


            <!--RIGHT SIDEBAR CONTENT-->

            <div class="col-lg-3 ds">
                <!-- NOTIFICATIONS -->
                <h3>NOTIFICATIONS</h3>
                <div id="notifications"  class="scroll-wrapper">
                    <?php 
                    $max = count($notifications) > 30 ? 30 : count($notifications);
                    //$max = count($notifications);
                    if($max == 0) {
                        ?>
                        <div class="notification">
                            <p>
                                NO NOTIFICATIONS<br/>
                            </p>
                        </div>                        
                        <?php
                    }
                    for ($i=0; $i < $max; $i++) { 
                       ?>
                       <div class="notification <?= $notifications[$i]['unread'] == true ? 'unread':''?>">
                        <a href=<?= $this->Url->build('/').$notifications[$i]['link']  ?>>

                            <p>
                                <muted><?= date_format($notifications[$i]['created'], 'F d, Y - g:ia')?></muted>
                                <br/>                                 
                                <?= $notifications[$i]['message']?>
                            </p>
                        </a>
                    </div>
                    <?php   
                }
                ?>
            </div>

            <!-- CALENDAR-->
            <a href=<?= $this->Url->build(['controller' => 'events', 'action' => 'index']) ?>>
              <div class="panel green-panel ">
                 <div class="panel-body">
                     <table id="calendar">
                        <tr>
                            <th colspan="7" class="month-year"><?= $calendar['month']?> <?= $calendar['year']?></th>
                        </tr>  
                        <tr>
                            <?php foreach ($calendar['dayNames'] as $day): ?>
                               <th class="day-name"><?= $day?></th>
                           <?php endforeach;?>
                       </tr>   
                       <?php for ($week=0; $week < $calendar['noOfWeeks']; $week++){?>
                       <tr>
                        <?php for ($day=0; $day < 7; $day++){?>
                        <td class="
                        <?php 

                        if (isset($calendar['days'][$week][$day]) && $calendar['currentDay'] == $calendar['days'][$week][$day]) {
                            echo 'current';
                        }

                        if (isset($calendar['events'][$week][$day])) {
                            if(isset($calendar['days'][$week][$day]) && $calendar['currentDay'] == $calendar['days'][$week][$day]){
                                echo '-';
                            } else {
                                echo ' ';
                            }
                            echo 'event';
                        }

                        if (isset($calendar['days'][$week][$day])) {
                            echo ' day'; 
                        }

                        ?>  ">
                        <?php 
                        if (isset($calendar['days'][$week][$day])) {
                            echo $calendar['days'][$week][$day]; 
                        }

                        ?>                                            
                    </td>     
                    <?php }?>  
                </tr>
                <?php }?>
            </table>
        </div>
    </div><!-- / calendar -->
</a>
</div><!-- /col-lg-3 -->
</div>
</section>
</section>

<!--main content end-->
<!--footer start-->
<footer class="site-footer">
	<div class="text-center">
		LURN
		<a href="#" class="go-top">
			<i class="fa fa-angle-up"></i>
		</a>
	</div>
</footer>
<!--footer end-->
</section>



