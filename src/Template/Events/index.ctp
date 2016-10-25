<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->
<!--main content start-->
<section >
	<section class="wrapper">

		<div class="apb">
			<h2 class="apc">EVENTS CALENDAR</h2>
		</div>

        <hr class="style-eight">
        <div class="row">
        	<div class="col-lg-12 main-chart">     
        		<!-- CALENDAR-->
        		<div class="panel green-panel ">
        			<div class="panel-body">
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

                                                ?> >
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
                                                            <a href=<?= ($this->Url->build(['controller' => 'tasks', 'action' => 'view/'.$calendar['updatedTaskIds'][$week][$day][$key], 'project_id' => $calendar['updatedProjectIds'][$week][$day][$key] ]))?>>
                                                            &gt; <?= $value ?>
                                                            </a>
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
                                                            &gt; <?= h($value) ?>
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
                            <h4 class="modal-title">Modal Header</h4>
                        </div>
                        <div class="modal-body">
                            <p>Some text in the modal.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                  
                </div>
            </div>

    </section>
</section>
