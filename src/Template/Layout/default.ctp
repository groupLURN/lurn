<?php
// This uses the default favicon.ico icon.
$this->Html->meta('icon', null, ['block' => true]);

// Third Party CSS
$this->Html->css('/bower_components/bootstrap/dist/css/bootstrap.min', ['block' => true]);
$this->Html->css('/bower_components/font-awesome/css/font-awesome.min', ['block' => true]);
$this->Html->css('/bower_components/zabuto_calendar/zabuto_calendar.min', ['block' => true]);
$this->Html->css('/bower_components/jquery.gritter/css/jquery.gritter', ['block' => true]);
$this->Html->css('/bower_components/jquery-ui/themes/base/jquery-ui.min', ['block' => true]);
$this->Html->css('/bower_components/chosen/chosen', ['block' => true]);
$this->Html->css('/non_bower_components/lineicons/style', ['block' => true]);
$this->Html->css('/non_bower_components/dashgum/style', ['block' => true]);
$this->Html->css('/non_bower_components/dashgum/style-responsive', ['block' => true]);

// User-defined CSS
$this->Html->css('custom', ['block' => true]);

// Third Party Javascript
$this->Html->script('/bower_components/jquery/dist/jquery.min', ['block' => true]);
$this->Html->script('/bower_components/bootstrap/dist/js/bootstrap.min', ['block' => true]);
$this->Html->script('/bower_components/zabuto_calendar/zabuto_calendar.min', ['block' => true]);
$this->Html->script('/bower_components/jquery.gritter/js/jquery.gritter.min', ['block' => true]);
$this->Html->script('/bower_components/chosen/chosen.jquery', ['block' => true]);
$this->Html->script('/bower_components/jquery-ui/jquery-ui.min', ['block' => true]);
//$this->Html->script('jquery-ui-1.9.2.custom.min', ['block' => true]);
$this->Html->script('/bower_components/jquery.scrollTo/jquery.scrollTo.min', ['block' => true]);
$this->Html->script('/bower_components/jquery.nicescroll/dist/jquery.nicescroll.min', ['block' => true]);
$this->Html->script('/bower_components/jquery.sparkline/dist/jquery.sparkline.min', ['block' => true]);
$this->Html->script('/bower_components/DateJS/build/date', ['block' => true]);

$this->Html->script('/non_bower_components/jquery.backstretch/jquery.backstretch.min', ['block' => true]);
$this->Html->script('/non_bower_components/uncategorized/jquery.dcjqaccordion.2.7', ['block' => true]);
$this->Html->script('/non_bower_components/uncategorized/common-scripts', ['block' => true]);
$this->Html->script('/non_bower_components/uncategorized/gritter-conf', ['block' => true]);
$this->Html->script('/non_bower_components/uncategorized/sparkline-chart', ['block' => true]);
$this->Html->script('/non_bower_components/chart-master/Chart', ['block' => 'script-header']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script-header') ?>
</head>

<body>

    <!-- **********************************************************************************************************************************************************
    TOP BAR CONTENT & NOTIFICATIONS
    *********************************************************************************************************************************************************** -->
    <section id="container" >
        <!--header start-->
        <header class="header black-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b><?= $this->fetch('menu-title'); ?></b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- settings start -->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                            <i class="fa fa-tasks"></i>
                            <span class="badge bg-theme">4</span>
                        </a>
                        <ul class="dropdown-menu extended tasks-bar">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">You have 4 pending tasks</p>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">DashGum Admin Panel</div>
                                        <div class="percent">40%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">Database Update</div>
                                        <div class="percent">60%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">Product Development</div>
                                        <div class="percent">80%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">Payments Sent</div>
                                        <div class="percent">70%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                            <span class="sr-only">70% Complete (Important)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="external">
                                <a href="#">See All Tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- settings end -->
                    <!-- inbox dropdown start-->
                    <li id="header_inbox_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge bg-theme">5</span>
                        </a>
                        <ul class="dropdown-menu extended inbox">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">You have 5 new messages</p>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="/img/ui-zac.jpg"></span>
                                        <span class="subject">
                                        <span class="from">Zac Snider</span>
                                        <span class="time">Just now</span>
                                        </span>
                                        <span class="message">
                                            Hi mate, how is everything?
                                        </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="/img/ui-divya.jpg"></span>
                                        <span class="subject">
                                        <span class="from">Divya Manian</span>
                                        <span class="time">40 mins.</span>
                                        </span>
                                        <span class="message">
                                         Hi, I need your help with this.
                                        </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="/img/ui-danro.jpg"></span>
                                        <span class="subject">
                                        <span class="from">Dan Rogers</span>
                                        <span class="time">2 hrs.</span>
                                        </span>
                                        <span class="message">
                                            Love your new Dashboard.
                                        </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="/img/ui-sherman.jpg"></span>
                                        <span class="subject">
                                        <span class="from">Dj Sherman</span>
                                        <span class="time">4 hrs.</span>
                                        </span>
                                        <span class="message">
                                            Please, answer asap.
                                        </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">See all messages</a>
                            </li>
                        </ul>
                    </li>
                    <!-- inbox dropdown end -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="/users/logout">Logout</a></li>
                </ul>
            </div>
        </header>
        <!--header end-->

        <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
        <!--sidebar start-->
        <aside>
            <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">

                    <p class="centered"><a href="profile.html"><img src="/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
                    <h5 class="centered">Marcel Newman</h5>

                    <li class="mt">
                        <a class="active" href="/dashboard">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-desktop"></i>
                            <span><?= __('Humans & Resources')?></span>
                        </a>
                        <ul class="sub">
                            <li><a href="/clients">Clients</a></li>
                            <li><a href="/employees">Employees</a></li>
                            <li><a href="/equipment">Equipment</a></li>
                            <li><a href="/manpower">Manpower</a></li>
                            <li><a href="/materials">Materials</a></li>
                            <li><a href="/suppliers">Suppliers</a></li>
                            <li><a href="/users">Users</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-tasks"></i>
                            <span>Projects</span>
                        </a>
                        <ul class="sub">
                            <li><a  href="/projects">View Projects</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-archive"></i>
                            <span>General Inventories</span>
                        </a>
                        <ul class="sub">
                            <li><a  href="/equipment-general-inventories">Equipment Inventory</a></li>
                            <li><a  href="/materials-general-inventories">Materials Inventory</a></li>
                            <li><a  href="/manpower-general-inventories">Manpower Inventory</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-search"></i>
                            <span>Track Resources Schedule</span>
                        </a>
                        <ul class="sub">
                            <li><a  href="/track-equipment-schedule">Track Equipment</a></li>
                            <li><a  href="/track-materials-schedule">Track Materials</a></li>
                            <li><a  href="/track-manpower-schedule">Track Manpower</a></li>
                        </ul>
                    </li>
                    <?= $this->fetch('additional-sidebar') ?>
                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->

        <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <?= $this->Flash->render('auth') ?>
                <?= $this->fetch('content'); ?>
            </section>
        </section>

    <?= $this->fetch('script'); ?>
    <script>
    <?php include(WWW_ROOT . 'js\back-end.js') ?>
    <?php include(WWW_ROOT . 'js\custom.js') ?>
    </script>
    <?= $this->fetch('script-inline'); ?>
    <?= $this->fetch('script-end'); ?>
</body>
</html>
