<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->
<!-- start of tabs -->
<div class="row mt">
    <div class="col-xs-12">
        <h3>
            <!--
                <span id="project-status-badge" class="
                    <?= $project->status !== 'Delayed' ? 'hidden' : '' ?>
                ">
                    <?= $project->status === 'Delayed' ? '!' : '' ?>
                </span>
            -->
            <?= h($project->title) ?>        
        </h3>
        <ul class="nav nav-tabs mt">
            <li>
                <a href=<?= $this->Url->build(['controller' => 'ProjectOverview', $projectId])?>>
                    <i class="fa fa-book"></i>
                    <span>Project Overview</span>
                </a>      
            </li>
            <li class="active">
                <a href=<?= $this->Url->build(['controller' => 'events', 'action' => 'project-calendar', $projectId])?>>
                    <i class="fa fa-calendar"></i>
                    <span>Events Calendar</span>
                </a>
            </li>
            <?php 
                if (in_array($employeeType, [0, 1, 2, 3], true)) {
            ?>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'ProjectPlanning', 'action' => 'CreateGanttChart', $projectId])?>>
                    <i class="fa fa-building"></i>
                    <span>Project Planning</span>
                </a>
            </li>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'manage', '?' => ['project_id' => $projectId]]) ?>>
                    <i class="fa fa-recycle"></i>
                    <span>Project Implementation</span>
                </a>
            </li>
            <?php 
                }

                if ($employeeType !== '') {
            ?>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventories', $projectId]) ?>>
                    <i class="fa fa-database"></i>
                    <span>Project Inventories</span>
                </a>
            <?php
                }

                if (in_array($employeeType, [0, 1, 2, 4], true)) {
            ?>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'IncidentReportHeaders', 'action' => 'index', '?' => ['project_id' => $projectId]]) ?>>
                    <i class="fa fa-file"></i>
                    <span>Reports</span>
                </a>
            </li>
            <?php 
                }
            ?>
        </ul>
    </div>
</div>
<!-- end of tabs -->

<div class="row">
	<div class="col-lg-12 main-chart">     
		<!-- CALENDAR-->
        <div class="centered">
            <form method="get" accept-charset="utf-8" action="/projects/lurn/events">                
            <label class="mt" for="year">Year</label>
            <input name="year" class="form-control calendar-input" 
                max="2099" min="1990" step="1" id="year" value="<?= $calendar['year']?>" type="number">
            <label class="mt" for="month">Month</label>
            <input name="month" class="form-control calendar-input" 
                max="12" min="1" step="1" id="month" value="<?= $calendar['month-number']?>" type="number">

            <button class="btn btn-primary" type="submit">Change Date</button>                
            </form>
        </div>
        <div class="panel violet-panel mt">
			<table id="event-calendar">
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

                                    if (isset($calendar['dueProjects'][$week][$day]) || isset($calendar['updates'][$week][$day])) {
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

                                ?>  " 
                                <?php 

                                    if (isset($calendar['dueProjects'][$week][$day]) || isset($calendar['updates'][$week][$day])) {                                                        
                                        echo 'data-toggle="modal" data-target="#myModal" ';
                                    }

                                    if (isset($calendar['days'][$week][$day])) {
                                        echo 'data-day="'.$calendar['days'][$week][$day].'"'; 
                                    }
                                    
                                    if (isset($calendar['updates'][$week][$day])) {
                                        echo 'data-updates="'.h(json_encode($calendar['updates'][$week][$day])).'"'; 
                                    }
                                    
                                    if (isset($calendar['updatedTaskIds'][$week][$day])) {
                                        echo 'data-updates-id="'.h(json_encode($calendar['updatedTaskIds'][$week][$day])).'"'; 
                                    }

                                    if (isset($calendar['dueProjects'][$week][$day])) {
                                        echo 'data-due-projects="'.h(json_encode($calendar['dueProjects'][$week][$day])).'"'; 
                                    }

                                    if (isset($calendar['dueProjectIds'][$week][$day])) {
                                        echo 'data-due-projects-id="'.h(json_encode($calendar['dueProjectIds'][$week][$day])).'"'; 
                                    }

                                ?>
                                >
                                <div>
                                    <span>
                                    <?php 
                                        if (isset($calendar['days'][$week][$day])) {
                                            echo $calendar['days'][$week][$day]; 
                                        }

                                    ?>
                                    </span>
                                    <?php
                                        if (isset($calendar['updates'][$week][$day])) {
                                        	foreach ($calendar['updates'][$week][$day] as $key => $value) {
                                        		if($key==0){
                            		?>
                                                <br>
                                                <ul class="updates no-padding">
                                        			<li>Updates:</li>
                            					<?php 
                                        			} 
                                        		?>
                                        		<li>
                                                <?= $value ?>
                                                </li>

                                        		<?php
                                        		if($key==count($calendar['updates'][$week][$day])-1){

                                    			?>
                                        			</ul>
                                    			 <?php
                                        		}
                                        	}
                                        }

                                    ?>  
                                    <?php
                                        if (isset($calendar['dueProjects'][$week][$day])) {
                                        	foreach ($calendar['dueProjects'][$week][$day] as $key => $value) {
                                        		if($key==0){
                                        		?>
                                                <br>
                                                <ul class="due-projects no-padding">
                                        			<li>Due Projects:</li>
                                        		<?php 
                                        			} 
                                        		?>
                                        		<li>
                                                <a href=<?= ($this->Url->build(['controller' => 'projects', 'action' => 'view/'.$calendar['dueProjectIds'][$week][$day][$key] ]))?>>
                                                <?= $value ?>
                                                </a>
                                                </li>

                                        		<?php
                                        		if($key==count($calendar['dueProjects'][$week][$day])-1){

                                    			?>
                                        			</ul>
                                    			 <?php
                                        		}
                                        	}
                                        }

                                    ?>  
                                </div>
                            </td>     
                        <?php }?>  
                    </tr>
                <?php }?>
            </table>
		</div>
	</div><!-- / calendar -->
</div>

<!-- Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
    
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= $calendar['month']?> <span class="modal-day"></span></h4>
            </div>
            <div class="modal-body">
                <div class="modal-updates">
                    <h4>Updates</h4>
                    <ul class="modal-updates-list">
                    </ul>
                </div>
                <div class="modal-due-projects">
                    <h4>Due Projects</h4>
                    <ul class="modal-due-projects-list">
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
      
    </div>
</div>
