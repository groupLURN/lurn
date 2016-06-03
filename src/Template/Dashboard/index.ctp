<?php

$this->Html->scriptStart(['block' => 'script-inline', 'safe' => false]);

echo <<<EOD
    $(document).ready(function () {
        var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'Welcome to Dashgum!',
            // (string | mandatory) the text inside the notification
            text: 'Hover me to enable the Close Button. You can hide the left sidebar clicking on the button next to the logo. Free version for <a href="http://blacktie.co" target="_blank" style="color:#ffd777">BlackTie.co</a>.',
            // (string | optional) the image to display on the left
            image: '/cakephp_3_2/lurn/img/ui-sam.jpg',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: true,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            class_name: 'my-sticky-class'
        });

        return false;
    });

//    $(document).ready(function () {
//        $("#date-popover").popover({html: true, trigger: "manual"});
//        $("#date-popover").hide();
//        $("#date-popover").click(function (e) {
//            $(this).hide();
//        });
//
//        $("#my-calendar").zabuto_calendar({
//            action: function () {
//            return myDateFunction(this.id, false);
//        },
//            action_nav: function () {
//            return myNavFunction(this.id);
//        },
//            ajax: {
//            url: "show_data.php?action=1",
//                modal: true
//            },
//            legend: [
//                {type: "text", label: "Special event", badge: "00"},
//                {type: "block", label: "Regular event", }
//            ]
//        });
//    });


    function myNavFunction(id) {
        $("#date-popover").hide();
        var nav = $("#" + id).data("navigation");
        var to = $("#" + id).data("to");
        console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
    }

EOD;
$this->Html->scriptEnd();
?>

    <!-- **********************************************************************************************************************************************************
    MAIN CONTENT
    *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">

            <div class="apb">
                    <h6 class="apd">DASHBOARD</h6>
                    <h2 class="apc">OVERVIEW</h2>
            </div>

           <!--  <div class="anv alg ala">
                <h3 class="anw anx"> Quick Stats </h3>
            </div> -->
            <hr class="style-eight">
            <div class="row">
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
                        <div class="col-md-4 col-sm-4 mb">
                            <div class="white-panel pn donut-chart">
                                <div class="white-header">
                                    <h3><p class="text-success">RECENT <br> ACTIVITY</p></h3>
                                </div>
                                <!-- <div class="row"> -->
                                  <!--   <div class="col-sm-6 col-xs-6 goleft">
                                        <p><i class="fa fa-database"></i> 70%</p>
                                    </div> -->
                                    <div class="row">
                                        <div class="panel panel-info">       
                                            <h5> PROJECT 1</h5>    
                                            <div class="white-panel pn donut-chart">
                                                <div class="white-header">      
                                                    <h5> Title1 </h5>
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
                                                    <h5> Title2 </h5>
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
                                                        <h5> Title3 </h5>
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


                        <div class="col-md-4 col-sm-4 mb">
                            <div class="white-panel pn">
                                <div class="white-header">
                                    <h3><p class="text-danger">DUE <br> TODAY</p></h3>
                                </div>
                                <div class="row">
                                        <div class="panel panel-info">       
                                            <h5> PROJECT 4</h5>    
                                            <div class="white-panel pn donut-chart">
                                                <div class="white-header">      
                                                    <h5> Title4 </h5>
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
                                                    <h5> Title5 </h5>
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

                        <div class="col-md-4 mb">
                            <!-- WHITE PANEL - TOP USER -->
                            <div class="white-panel pn">
                                <div class="white-header">
                                    <h3><p class="text-warning">UPCOMING <br> EVENT</p></h3>
                                </div>  
                                 <div class="row">
                                        <div class="panel panel-info">       
                                            <h5> PROJECT 6</h5>    
                                            <div class="white-panel pn donut-chart">
                                                <div class="white-header">      
                                                    <h5> Title6 </h5>
                                                </div>
                                            </div>           
                                        </div>    
                                    </div>
                                 <div class="row">
                                        <div class="panel panel-info">       
                                            <h5> PROJECT 7</h5>    
                                            <div class="white-panel pn donut-chart">
                                                <div class="white-header">      
                                                    <h5> Title7 </h5>
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

                    <!-- USERS ONLINE SECTION -->
                    <h3>TEAM MEMBERS</h3>
                    <!-- First Member -->
                    <div class="desc">
                        <div class="thumb">
                            <img class="img-circle" src=<?= $this->Url->build(['controller' => 'img/ui-divya.jpg', 'action' => 'index']) ?> width="35px" height="35px" align="">
                        </div>
                        <div class="details">
                            <p><a href="#">DIVYA MANIAN</a><br/>
                                <muted>Available</muted>
                            </p>
                        </div>
                    </div>
                    <!-- Second Member -->
                    <div class="desc">
                        <div class="thumb">
                            <img class="img-circle"  src=<?= $this->Url->build(['controller' => 'img/ui-sherman.jpg', 'action' => 'index']) ?> width="35px" height="35px" align="">
                        </div>
                        <div class="details">
                            <p><a href="#">DJ SHERMAN</a><br/>
                                <muted>I am Busy</muted>
                            </p>
                        </div>
                    </div>
                    <!-- Third Member -->
                    <div class="desc">
                        <div class="thumb">
                            <img class="img-circle" src=<?= $this->Url->build(['controller' => 'img/ui-danro.jpg', 'action' => 'index']) ?> width="35px" height="35px" align="">
                        </div>
                        <div class="details">
                            <p><a href="#">DAN ROGERS</a><br/>
                                <muted>Available</muted>
                            </p>
                        </div>
                    </div>
                    <!-- Fourth Member -->
                    <div class="desc">
                        <div class="thumb">
                            <img class="img-circle" src=<?= $this->Url->build(['controller' => 'img/ui-zac.jpg', 'action' => 'index']) ?> width="35px" height="35px" align="">
                        </div>
                        <div class="details">
                            <p><a href="#">Zac Sniders</a><br/>
                                <muted>Available</muted>
                            </p>
                        </div>
                    </div>
                    <!-- Fifth Member -->
                    <div class="desc">
                        <div class="thumb">
                            <img class="img-circle" src=<?= $this->Url->build(['controller' => 'img/ui-sam.jpg', 'action' => 'index']) ?> width="35px" height="35px" align="">
                        </div>
                        <div class="details">
                            <p><a href="#">Marcel Newman</a><br/>
                                <muted>Available</muted>
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
            2014 - Alvarez.is
            <a href="index.html#" class="go-top">
                <i class="fa fa-angle-up"></i>
            </a>
        </div>
    </footer>
    <!--footer end-->
</section>


