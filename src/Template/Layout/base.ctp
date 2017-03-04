<?php
// This uses the default favicon.ico icon.
$this->Html->meta('icon', null, ['block' => true]);

// Third Party CSS
$this->Html->css('/bower_components/bootstrap/dist/css/bootstrap.min', ['block' => true]);
$this->Html->css('/bower_components/font-awesome/css/font-awesome.min', ['block' => true]);
$this->Html->css('/bower_components/jquery-ui/themes/base/jquery-ui.min', ['block' => true]);
$this->Html->css('/bower_components/chosen/chosen', ['block' => true]);
$this->Html->css('/non_bower_components/lineicons/style', ['block' => true]);
$this->Html->css('/non_bower_components/dashgum/style', ['block' => true]);
$this->Html->css('/non_bower_components/dashgum/style-responsive', ['block' => true]);

// User-defined CSS
$this->Html->css('custom', ['block' => true]);

// Third Party Javascript
$this->Html->script('/bower_components/bootstrap/dist/js/bootstrap.min', ['block' => true]);
$this->Html->script('/bower_components/jquery/dist/jquery.min', ['block' => 'script-header']);
$this->Html->script('/bower_components/jquery-ui/jquery-ui.min', ['block' => 'script-header']);
$this->Html->script('/bower_components/chosen/chosen.jquery', ['block' => true]);
//$this->Html->script('jquery-ui-1.9.2.custom.min', ['block' => true]);
$this->Html->script('/bower_components/jquery.scrollTo/jquery.scrollTo.min', ['block' => true]);
$this->Html->script('/bower_components/jquery.nicescroll/dist/jquery.nicescroll.min', ['block' => true]);
$this->Html->script('/bower_components/jquery.sparkline/dist/jquery.sparkline.min', ['block' => true]);
$this->Html->script('/bower_components/DateJS/build/date', ['block' => true]);

$this->Html->script('/non_bower_components/jquery.backstretch/jquery.backstretch.min', ['block' => true]);
$this->Html->script('/non_bower_components/uncategorized/jquery.dcjqaccordion.2.7', ['block' => true]);
$this->Html->script('/non_bower_components/uncategorized/common-scripts', ['block' => true]);
$this->Html->script('/non_bower_components/uncategorized/sparkline-chart', ['block' => true]);
$this->Html->script('/non_bower_components/chart-master/Chart', ['block' => 'script-header']);
$this->Html->script('custom', ['block' => true]);

$request_uri = $_SERVER['REQUEST_URI'];

if(strpos($request_uri, 'purchase-order-header') !== false) {    
    $this->Html->script('purchase-order-header', ['block' => true]);
}

if(strpos($request_uri, 'rental-request-header') !== false) {    
    $this->Html->script('rental-request-header', ['block' => true]);
}

if(strpos($request_uri, 'resource-request-header') !== false) {    
    $this->Html->script('resource-request-header', ['block' => true]);
}

if(strpos($request_uri, 'incident-report-headers') !== false) {    
    $this->Html->script('incident-report-headers', ['block' => true]);
}

if(strpos($request_uri, 'events') !== false) {    
    $this->Html->script('events', ['block' => true]);
}

if(strpos($request_uri, 'projects') !== false) {    
    $this->Html->script('project', ['block' => true]);
}
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

<body >

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
           
        </div>
        <div class="top-menu">
            <ul class="nav pull-right top-menu">
                <li><a class="logout" href=<?= $this->Url->build(['controller' => 'users', 'action' => 'logout']) ?>>Logout</a></li>
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
                <h4 class="centered">
                    <?=  $this->request->session()->read('Auth.User.username'); ?>
                </h4>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'dashboard/', 'action' => 'index']) ?>>
                        <i class="fa fa-dashboard"></i><span>Dashboard</span><span id="notification-badge" class="badge pull-right"></span>
                    </a>
                </li>
                <li >
                    <a href=<?= $this->Url->build(['controller' => 'events', 'action' => 'index']) ?>>
                        <i class="fa fa-calendar"></i><span>Events Calendar</span>
                    </a>
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

    <span id="base-link" style="display:none"><?= $this->Url->build('/') ?></span>

    <?= $this->fetch('script'); ?>
    <?= $this->fetch('script-inline'); ?>
    <?= $this->fetch('script-end'); ?>
</body>
</html>
