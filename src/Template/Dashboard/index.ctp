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
        			<div class="col-md-4 col-sm-4 mb">
        				<div class="white-panel donut-chart" >
        					<div class="white-header">
        						<h3><p class="text-success">RECENT ACTIVITY</p></h3>
        					</div>

                        <div class="scroll-wrapper dashboard-card">
                            <!--
                            <?php foreach ($projects as $project): ?>
                            <div class="row">
                                <div class="panel panel-info">       
                                    <h5> <?= h($project->title) ?></h5>    
                                    <div class="white-panel pn donut-chart">
                                        <div class="white-header">      
                                            <h5> Milestone 1 </h5>
                                        </div>
                                         <canvas id="<?= h($project->title) ?>" height="100" width="100"></canvas>
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
                                                                    var myDoughnut = new Chart(document.getElementById("<?= h($project->title) ?>").getContext("2d")).Doughnut(doughnutData);
                                            </script>   
                                            <div class="col-sm-6 col-xs-6 goleft">
                                                     <p>70%</p></br>
                                                     <p><?= h($project->modified) ?> </p>
                                            </div>           
                                    </div>           
                                </div>    
                            </div>                             
                            <?php endforeach; ?>

                        -->
                        </div>


                    </div><!--grey-panel -->
                </div><!-- /col-md-4-->


                <div class="col-md-4 col-sm-4 mb">
                	<div class="white-panel">
                		<div class="white-header">
                			<h3><p class="text-danger">DUE PROJECTS</p></h3>
                		</div>
                		<?php if (sizeof($duestoday) == 0): ?>
                			<div> <h3> No Projects On Due Today </h3> </div>
                		<?php endif; ?>
                        <div class="scroll-wrapper dashboard-card">
                            
                        <?php foreach ($duestoday as $project): ?>
                            <div class="row">
                                <div class="panel panel-info">      
                        <div class="white-header"> 
                                    <h4> <?= h($project->title) ?></h4>  
                                    </div>
                                    <div class="white-panel pn donut-chart">
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
                                            <!--<p>70%</p></br>-->
                                            <p>
                                            Last modified:<br> <?= h($project->modified) ?> <br>
                                            End date:<br><?= h($project->end_date) ?>
                                            </p>
                                        </div>                      
                                    </div>           
                                </div>    
                            </div>                            
                        <?php endforeach; ?>

                        </div>

                	</div>
                </div><!-- /col-md-4 -->

                <div class="col-md-4 mb">
                	<div class="white-panel">
                		<div class="white-header">
                			<h3><p class="text-warning">UPCOMING EVENTS</p></h3>
                		</div>  
                        <div class="scroll-wrapper dashboard-card">
                		<!--
                		<?php foreach ($milestoneslist as $milestone): ?>
                			<div class="row">
                				<div class="panel panel-info">       
                					<h5>PROJECT TITLE</h5>    
                					<div class="white-panel pn donut-chart">
                						<div class="white-header">      
                							<h5> <?= h($milestone->start_date) ?> </h5>
                						</div>
                						<div> <h3><?= h($milestone->title) ?></h3> </div>
                					</div>           
                				</div>    
                			</div>                             
                		<?php endforeach; ?>
						-->
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
            	<div id="calendar" class="mb">
            		<div class="panel green-panel no-margin">
            			<div class="panel-body">
            				<div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
            					<div class="arrow"></div>
            					<h3 class="popover-title" style="disadding: none;"></h3>
            					<div id="date-popover-content" class="popover-content"></div>
            				</div>
            				<div id="my-calendar"></div>
            			</div>
            		</div>
            	</div><!-- / calendar -->


            </div><!-- /col-lg-3 -->
        </div><! --/row -->
    </section>
</section>

<!--main content end-->
<!--footer start-->
<footer class="site-footer">
	<div class="text-center">
		LURN
		<a href="index.html#" class="go-top">
			<i class="fa fa-angle-up"></i>
		</a>
	</div>
</footer>
<!--footer end-->
</section>



