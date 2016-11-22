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
        <?= h($project->title) ?><br>
        <?= h($project->client->company_name) ?><br>
        J.I. Espino Construction<br>
        <?= h($project->employee->name) ?><br>
        <?= h($project->location) ?><br>
    </h3>
    <br>
</div>

<div class="body">
    <?= $this->fetch('content'); ?>
</div>

</body>
</html>
