<?php

use Cake\Core\Configure;

$webRoot = Configure::read('App.wwwRoot');

// This uses the default favicon.ico icon.
$this->Html->meta('icon', null, ['block' => true]);

// User-defined CSS
$this->Html->css('pdf', ['block' => true, 'fullBase' => true]);
?>

<?= $this->assign('title', 'Certificate of Completion') ?>
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
    <?= $this->Html->image('logo.jpg', array('fullBase' => true)) ?>
    <span>J.I. Espino Construction</span>
</div>

<hr>

<div class="body"> 
    <h1 align="center">CERTICATE OF COMPLETION AND ACCEPTANCE</h1>
    <?= $this->fetch('content'); ?>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<div>
    <table class="signatory">
        <tr>
            <td>Submitted by:</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><b>JOEL I. ESPINO</b></td>
        </tr>
        <tr>
            <td>GENERAL MANAGER</td>
        </tr>
        <tr>
            <td>J.I. ESPINO CONTRUCTION </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table class="signatory">
        <tr>
            <td style="width: 450px">Validated by:</td>
            <td>Accepted by:</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><b><?= strtoupper($project->employee->name)  ?></b></td>
            <td><b><?= strtoupper($project->client->key_person)  ?></b></td>
        </tr>
            <td>Project Manager</td>
            <td>___________________________________________</td>
        </tr>
        </tr>
            <td>J.I. ESPINO CONTRUCTION </td>
            <td class="text-center">Position</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><?= $project->client->address  ?> </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table class="signatory">
        <tr>
            <td style="width: 450px">&nbsp;</td>
            <td>Noted by:</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        </tr>
            <td>&nbsp;</td>
            <td>___________________________________________</td>
        </tr>
        </tr>
            <td>&nbsp;</td>
            <td class="text-center">Name</td>
        </tr>
        </tr>
            <td>&nbsp;</td>
            <td>___________________________________________</td>
        </tr>
        </tr>
            <td>&nbsp;</td>
            <td class="text-center">Position</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><?= $project->client->address  ?> </td>
        </tr>
    </table>
</div>

</body>
</html>
