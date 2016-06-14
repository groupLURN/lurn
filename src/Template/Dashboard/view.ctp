<div class="col-lg-9 main-chart">
                        
                   <!--  <div class="row mtbox">
                        <div class="col-md-2 col-sm-2 col-md-offset-1 box0">
                            <div class="box1">
                                <span class="li_heart"></span>
                                <h3>933</h3>
                            </div>
                            <p>933 People liked your page the last 24hs. Whoohoo!</p>
                        </div>
                        <div class="col-md-2 col-sm-2 box0">
                            <div class="box1">
                                <span class="li_cloud"></span>
                                <h3>+48</h3>
                            </div>
                            <p>48 New files were added in your cloud storage.</p>
                        </div>
                        <div class="col-md-2 col-sm-2 box0">
                            <div class="box1">
                                <span class="li_stack"></span>
                                <h3>23</h3>
                            </div>
                            <p>You have 23 unread messages in your inbox.</p>
                        </div>
                        <div class="col-md-2 col-sm-2 box0">
                            <div class="box1">
                                <span class="li_news"></span>
                                <h3>+10</h3>
                            </div>
                            <p>More than 10 news were added in your reader.</p>
                        </div>
                        <div class="col-md-2 col-sm-2 box0">
                            <div class="box1">
                                <span class="li_data"></span>
                                <h3>OK!</h3>
                            </div>
                            <p>Your server is working perfectly. Relax & enjoy.</p>
                        </div>

                    </div><!-- /row mt -->
                    

                    <div class="row mt">
                        <!-- SERVER STATUS PANELS -->
                        <div class="col-md-4 col-sm-4 mb"  style="overflow-y: auto; height:600px" >
                            <div class="white-panel pn donut-chart" >
                                <div class="white-header">
                                    <h3><p class="text-success">RECENT ACTIVITY</p></h3>
                                </div>
                                <!-- <div class="row"> -->
                                  <!--   <div class="col-sm-6 col-xs-6 goleft">
                                        <p><i class="fa fa-database"></i> 70%</p>

                                    </div> -->
                                    <?php foreach ($projects as $project): ?>
                                    <td><?= h($project->title) ?></td>   
                                    <?php endforeach; ?>
                                    <div class="row">
                                        <div class="panel panel-info">       
                                            <h5> PROJECT 1</h5>    
                                            <div class="white-panel pn donut-chart">
                                                <div class="white-header">      
                                                    <h5> Milestone 1 </h5>
                                                </div>
                                                 <canvas id="serverstatus01" height="120" width="120"></canvas>
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
                                                                            var myDoughnut = new Chart(document.getElementById("serverstatus01").getContext("2d")).Doughnut(doughnutData);
                                                    </script>                     
                                            </div>           
                                        </div>    
                                    </div>
                                <!-- </div> -->
                                <!-- <canvas id="serverstatus01" height="120" width="120"></canvas>
                                <script>
                                                                        var doughnutData = [
                                                                            {
                                                                                value: 70,
                                                                                color:"#68dff0"
                                                                            },
                                                                            {
                                                                                value : 30,
                                                                                color : "#fdfdfd"
                                                                            }
                                                                        ];
                                                                        var myDoughnut = new Chart(document.getElementById("serverstatus01").getContext("2d")).Doughnut(doughnutData);
                                </script>    -->
                                <!-- <div class="row"> -->
                                    <div class="row">
                                        <div class="panel panel-info">       
                                            <h5> PROJECT 2</h5>    
                                            <div class="white-panel pn donut-chart">
                                                <div class="white-header">      
                                                    <h5> Milestone 2 </h5>
                                                </div>
                                                 <canvas id="serverstatus02" height="120" width="120"></canvas>
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
                                                                        var myDoughnut = new Chart(document.getElementById("serverstatus02").getContext("2d")).Doughnut(doughnutData);
                                                    </script>                     
                                            </div>           
                                        </div>    
                                    </div>    
                               <!--  </div>     -->
                                    <div class="row">
                                            <div class="panel panel-info">       
                                                <h5> PROJECT 3</h5>    
                                                <div class="white-panel pn donut-chart">
                                                    <div class="white-header">      
                                                        <h5> Milestone 3 </h5>
                                                    </div>
                                                     <canvas id="serverstatus03" height="120" width="120"></canvas>
                                                    <script>
                                                                            var doughnutData = [
                                                                                {
                                                                                    value: 50,
                                                                                    color:"#68dff0"
                                                                                },
                                                                                {
                                                                                    value : 50,
                                                                                    color : "#fdfdfd"
                                                                                }
                                                                            ];
                                                                            var myDoughnut = new Chart(document.getElementById("serverstatus03").getContext("2d")).Doughnut(doughnutData);
                                                    </script>                     
                                                </div>           
                                            </div>    
                                        </div>
                            </div><! --/grey-panel -->
                        </div><!-- /col-md-4-->


                        <div class="col-md-4 col-sm-4 mb"  style="overflow-y: auto; height:600px" >
                            <div class="white-panel pn">
                                <div class="white-header">
                                    <h3><p class="text-danger">DUE TODAY</p></h3>
                                </div>
                                <div class="row">
                                        <div class="panel panel-info">       
                                            <h5> PROJECT 4</h5>    
                                            <div class="white-panel pn donut-chart">
                                                <div class="white-header">      
                                                    <h5> Milestone 4 </h5>
                                                </div>
                                                 <canvas id="serverstatus04" height="120" width="120"></canvas>
                                                    <script>
                                                                            var doughnutData = [
                                                                                {
                                                                                    value: 100,
                                                                                    color:"#68dff0"
                                                                                },
                                                                                {
                                                                                    value : 0,
                                                                                    color : "#fdfdfd"
                                                                                }
                                                                            ];
                                                                            var myDoughnut = new Chart(document.getElementById("serverstatus04").getContext("2d")).Doughnut(doughnutData);
                                                    </script>                     
                                            </div>           
                                        </div>    
                                    </div>
                                     <div class="row">
                                        <div class="panel panel-info">       
                                            <h5> PROJECT 4</h5>    
                                            <div class="white-panel pn donut-chart">
                                                <div class="white-header">      
                                                    <h5> Milestone 5 </h5>
                                                </div>
                                                 <canvas id="serverstatus05" height="120" width="120"></canvas>
                                                    <script>
                                                                            var doughnutData = [
                                                                                {
                                                                                    value: 88,
                                                                                    color:"#68dff0"
                                                                                },
                                                                                {
                                                                                    value : 12,
                                                                                    color : "#fdfdfd"
                                                                                }
                                                                            ];
                                                                            var myDoughnut = new Chart(document.getElementById("serverstatus05").getContext("2d")).Doughnut(doughnutData);
                                                    </script>                     
                                            </div>           
                                        </div>    
                                    </div>                             
                            </div>
                        </div><!-- /col-md-4 -->

                        <div class="col-md-4 mb"  style="overflow-y: auto; height:600px" >
                            <!-- WHITE PANEL - TOP USER -->
                            <div class="white-panel pn">
                                <div class="white-header">
                                    <h3><p class="text-warning">UPCOMING EVENT</p></h3>
                                </div>  
                                 <div class="row">
                                        <div class="panel panel-info">       
                                            <h5> PROJECT 6</h5>    
                                            <div class="white-panel pn donut-chart">
                                                <div class="white-header">      
                                                    <h5> Milestone 6 </h5>
                                                </div>
                                            </div>           
                                        </div>    
                                    </div>
                                 <div class="row">
                                        <div class="panel panel-info">       
                                            <h5> PROJECT 7</h5>    
                                            <div class="white-panel pn donut-chart">
                                                <div class="white-header">      
                                                    <h5> Milestone 7 </h5>
                                                </div>
                                            </div>           
                                        </div>    
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
                    <!-- Second Action -->
                    <div class="desc">
                        <div class="thumb">
                            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <div class="details">
                            <p><muted>3 Hours Ago</muted><br/>
                                <a href="#">Diana Kennedy</a> purchased a year subscription.<br/>
                            </p>
                        </div>
                    </div>
                    <!-- Third Action -->
                    <div class="desc">
                        <div class="thumb">
                            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <div class="details">
                            <p><muted>7 Hours Ago</muted><br/>
                                <a href="#">Brandon Page</a> purchased a year subscription.<br/>
                            </p>
                        </div>
                    </div>
                    <!-- Fourth Action -->
                    <div class="desc">
                        <div class="thumb">
                            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <div class="details">
                            <p><muted>11 Hours Ago</muted><br/>
                                <a href="#">Mark Twain</a> commented your post.<br/>
                            </p>
                        </div>
                    </div>
                    <!-- Fifth Action -->
                    <div class="desc">
                        <div class="thumb">
                            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <div class="details">
                            <p><muted>18 Hours Ago</muted><br/>
                                <a href="#">Daniel Pratt</a> purchased a wallet in your store.<br/>
                            </p>
                        </div>
                    </div>

                    <!-- CALENDAR-->
                   
                    

                </div><!-- /col-lg-3 -->