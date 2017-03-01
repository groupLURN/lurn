<?php

// This uses the default favicon.ico icon.
$this->Html->meta('icon', null, ['block' => true]);
// Third Party CSS
$this->Html->css('/bower_components/bootstrap/dist/css/bootstrap.min', ['block' => true]);
$this->Html->css('/bower_components/font-awesome/css/font-awesome.min', ['block' => true]);
$this->Html->css('/non_bower_components/dashgum/style', ['block' => true]);
$this->Html->css('/non_bower_components/dashgum/style-responsive', ['block' => true]);

// User defined Javascript
$this->Html->css('custom', ['block' => true]);

// Third Party Script
$this->Html->script('/bower_components/jquery/dist/jquery.min', ['block' => true]);
$this->Html->script('/bower_components/bootstrap/dist/js/bootstrap.min', ['block' => true]);
$this->Html->script('/non_bower_components/jquery.backstretch/jquery.backstretch.min', ['block' => true]);

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
<?= $this->Flash->render('auth') ?>
<?= $this->Flash->render('success') ?>
<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
<?= $this->fetch('script') ?>
<?= $this->fetch('script-inline') ?>
</body>
</html>