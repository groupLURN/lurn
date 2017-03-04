<?php

use Cake\Core\Configure;

$webRoot = Configure::read('App.wwwRoot');

// This uses the default favicon.ico icon.
$this->Html->meta('icon', null, ['block' => true]);

// User-defined CSS
$this->Html->css('pdf', ['block' => true, 'fullBase' => true]);
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
</head>

<body>

<div class="header">
    <?= $this->Html->image('logo.jpg', array('fullBase' => true, 'class' => 'float-right')) ?>
    <h3 class="text-left">
        <?php foreach ($projects as $project): ?>
        <?= $project->title ?><br>
        <?= $project->client_name ?><br>
        <?= $this->fetch('title') ?><br>
        J.I. Espino Construction<br>
        <?= $project->manager_name ?><br>
        <?= $project->location ?>
        <?php endforeach; ?>
    </h3>
    <br>
    <h3 class="text-left">* As of <?= $currentDate ?></h3>
    <br>
</div>

<div class="page-break body">
    <?= $this->fetch('content'); ?>
</div>

<div class="header">
    <?= $this->Html->image('logo.jpg', array('fullBase' => true, 'class' => 'float-right')) ?>
    <h3 class="text-left">
        <?php foreach ($projects as $project): ?>
        <?= $project->title ?><br>
        <?= $project->client_name ?><br>
        <?= $this->fetch('title') ?><br>
        J.I. Espino Construction<br>
        <?= $project->manager_name ?><br>
        <?= $project->location ?>
        <?php endforeach; ?>
    </h3>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="footer">
    <div>
        <h2><i>Authorized By:</i></h2>
        <div class="signatory">
            <div>________________________________________</div>
            <div><i class="text">Signature over printed name</i><div>
        </div>
        <div class="signatory">
            <div>________________________________________</div>
            <div><i class="text">Position in the company</i></div>
        </div>
    </div>
</div>

</body>
</html>
