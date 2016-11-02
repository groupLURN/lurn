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

                <div class="row mt">
        			<div class="col-md-6 col-sm-6 mb">
        				<div class="white-panel donut-chart" >
        					<div class="white-header">
        						<h3><p class="text-success">RECENT ACTIVITY</p></h3>
        					</div>

                            <div class="scroll-wrapper dashboard-card">
                                <?php foreach ($projects as $project): ?>
                                <a href=<?= ($this->Url->build(['controller' => 'tasks', 'action' => 'view/'.$project->latestTaskId, 'project_id' => $project->id ]))?>>
                                <div class="row">
                                    <div class="panel">            
                                        <div class="white-header"> 
                                            <h4> <?= h($project->title) ?></h4>  
                                        </div>
                                        <div class="white-panel dashboard-card-content">
                                            <canvas id="recent-<?= h($project->title) ?>" height="130" width="130"></canvas>
                                            <script>
                                                var doughnutData = [
                                                    {
                                                        value : <?= ceil($project->progress) ?>,
                                                        color:"#68dff0"
                                                    },
                                                    {
                                                        value: <?= 100-ceil($project->progress) ?>,
                                                        color : "#fdfdfd"
                                                    }
                                                ];
                                                var myDoughnut = new Chart(document.getElementById("recent-<?= h($project->title) ?>").getContext("2d")).Doughnut(doughnutData);
                                            </script>   
                                            <div class="col-sm-6 col-xs-6 goleft">
                                                <p>
                                                    Progress: <?= $project->progress ?>%<br><br>
                                                    Recent Update<br> 
                                                    Milestone: <?= h($project->latestMilestone) ?><br>
                                                    Task: <?= h($project->latestTask) ?><br>
                                                    Date: <?= h(strcmp($project->updatedDate, "N/A") == 0 ? $project->updatedDate : date_format($project->updatedDate,"F d, Y")) ?>
                                                </p>
                                            </div>           
                                        </div>           
                                    </div> 
                                </div> 
                                </a>                               
                                <?php endforeach; ?>
                            </div>


                        </div><!--grey-panel -->
                    </div><!-- /col-md-4-->


                    <div class="col-md-6 col-sm-6 mb">
                    	<div class="white-panel">
                    		<div class="white-header">
                    			<h3><p class="text-danger">DUE PROJECTS</p></h3>
                    		</div>
                    		<?php if (sizeof($dueProjects) == 0): ?>
                    			<div> <h3> No Projects On Due Today </h3> </div>
                    		<?php endif; ?>
                            <div class="scroll-wrapper dashboard-card">
                                
                            <?php foreach ($dueProjects as $project): ?>

                                <a href=<?= ($this->Url->build(['controller' => 'projects', 'action' => 'view/'. $project->id ]))?>>
                                <div class="row">
                                    <div class="panel ">      
                                        <div class="white-header"> 
                                        <h4> <?= h($project->title) ?></h4>  
                                        </div>
                                        <div class="white-panel  dashboard-card-content">
                                            <canvas id="due-<?= h($project->title) ?>" height="130" width="130"></canvas>
                                            <script>
                                                var doughnutData = [
                                                    {
                                                        value : <?= ceil($project->progress) ?>,
                                                        color:"#68dff0"
                                                    },
                                                    {
                                                        value: <?= 100-ceil($project->progress) ?>,
                                                        color : "#fdfdfd"
                                                    }
                                                ];
                                                var myDoughnut = new Chart(document.getElementById("due-<?= h($project->title) ?>").getContext("2d")).Doughnut(doughnutData);
                                            </script>   
                                            <div class="col-sm-6 col-xs-6 goleft">
                                                <p>
                                                    Progress: <?= $project->progress ?>%<br><br>
                                                    Due date:<br><?= h(date_format($project->end_date,"F d, Y")) ?>
                                                </p>
                                            </div>                     
                                        </div>           
                                    </div>    
                                </div>           
                                </a>                 
                            <?php endforeach; ?>
                            </div>
                    	</div>
                    </div><!-- /col-md-4 -->
                </div><!-- /row -->
            </div><!-- /col-lg-9 END SECTION MIDDLE -->


        <!--RIGHT SIDEBAR CONTENT-->

            <div class="col-lg-3 ds">
                <!-- NOTIFICATIONS -->
                <div id="notifications">
                <?php 
                    $max = count($notifications) < 4 ? count($notifications) : 4;
                    if($max > 0) {
                        ?>
                        
                        <h3>NOTIFICATIONS</h3>

                        <?php
                    }
                    for ($i=0; $i < $max; $i++) { 
                 ?>
                    <div class="notification">
                        <a href=<?= $this->Url->build('/').$notifications[$i]['link']  ?>>
                            <p><muted><?= date_format($notifications[$i]['created'], 'F d, Y - g:ia')?></muted><br/>                                 
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



