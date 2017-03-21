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

<div class="horizontal-header">
    <?= $this->Html->image('logo.jpg', array('fullBase' => true)) ?>
    <span>J.I. Espino Construction</span>
</div>

<div class="page-break body">
    <?php if (!isset($summary)): ?>
    <h3>
    <?= $project->title ?><br>
    <?= $project->client->company_name ?><br>
    <?= $project->employee->name?><br>
    <?= $project->location ?>
    </h3>
    <?php  endif; ?>
    <h3 align="center"><?= $this->fetch('title') ?></h3>    
    <?= $this->fetch('content'); ?>
</div>

<div class="horizontal-header">
    <?= $this->Html->image('logo.jpg', array('fullBase' => true)) ?>
    <span>J.I. Espino Construction</span>
</div>

<hr>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<div>
    <table class="signatory text-center">
        <tr>
            <th class="text-left" style="width: 150px;">Prepared by:</th>
            <td><?=  $userFullName ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><?=  $employeeTypeTitle ?></td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table class="signatory text-center">
        <tr>
            <th class="text-left" style="width: 150px;">Noted by:</th>
            <td>________________________________</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Signature over printed name</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>________________________________</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Position in the company</td>
        </tr>
    </table>
</div>

</body>
</html>
