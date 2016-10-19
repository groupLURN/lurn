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
                                <div class="row">
                                    <div class="panel">            
                                        <div class="white-header"> 
                                            <h4> <?= h($project->title) ?></h4>  
                                        </div>
                                        <div class="white-panel dashboard-card-content">
                                            <canvas id="<?= h($project->title) ?>" height="150" width="150"></canvas>
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
                                                var myDoughnut = new Chart(document.getElementById("<?= h($project->title) ?>").getContext("2d")).Doughnut(doughnutData);
                                            </script>   
                                            <div class="col-sm-6 col-xs-6 goleft">
                                                <p>
                                                    Progress: <?= $project->progress ?>%<br><br>
                                                    Recent Update<br> 
                                                    Milestone: <?= h($project->latestMilestone) ?><br>
                                                    Task: <?= h($project->latestTask) ?><br>
                                                    Date: <?= h($project->updateDate) ?>
                                                </p>
                                            </div>           
                                        </div>           
                                    </div>    
                                </div>                             
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
                                <div class="row">
                                    <div class="panel ">      
                                        <div class="white-header"> 
                                        <h4> <?= h($project->title) ?></h4>  
                                        </div>
                                        <div class="white-panel  dashboard-card-content">
                                            <!--<div class="white-header">      
                                                <h5> Milestone 1 </h5>
                                            </div>-->
                                            <!--
                                            <canvas id="<?= h($project->title) ?> due" height="100" width="100"></canvas>
                                            <script>
                                                var doughnutData = [
                                                {
                                                    value: 30,
                                                    color:"#68dff0"
                                                },
                                                {
                                                    value : 70,
                                                    color : "#fdfdfd"
                                                }
                                                ];
                                                var myDoughnut = new Chart(document.getElementById("<?= h($project->title) ?> due").getContext("2d")).Doughnut(doughnutData);
                                            </script>
                                            -->   
                                            <div class="col-sm-6 col-xs-6 goleft">
                                                <p>
                                                    Due date:<br><?= h($project->end_date) ?>
                                                </p>
                                            </div>                      
                                        </div>           
                                    </div>    
                                </div>                            
                            <?php endforeach; ?>
                            </div>
                    	</div>
                    </div><!-- /col-md-4 -->
                </div><!-- /row -->
            </div><!-- /col-lg-9 END SECTION MIDDLE -->


        <!-- **********************************************************************************************************************************************************
        RIGHT SIDEBAR CONTENT
        *********************************************************************************************************************************************************** -->

            <div class="col-lg-3 ds">
            	<!--COMPLETED ACTIONS DONUTS CHART-->
            	<h3>NOTIFICATIONS</h3>

            	<!-- First Action -->
            	<div class="desc">
            		<div class="thumb">
            			<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
            		</div>
            		<div class="details">
            			<p><muted>2 Minutes Ago</muted><br/>
            				<a href="#">James Brown</a> subscribed to your newsletter.<br/>
            			</p>
            		</div>
            	</div>

            	<!-- CALENDAR-->
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



