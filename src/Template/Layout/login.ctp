<?php

// This uses the default favicon.ico icon.
$this->Html->meta('icon', null, ['block' => true]);
// Bootstrap core CSS
$this->Html->css('bootstrap', ['block' => true]);
// External CSS
$this->Html->css('/font-awesome/css/font-awesome', ['block' => true]);
// Custom styles for this template.
$this->Html->css('style', ['block' => true]);
$this->Html->css('style-responsive', ['block' => true]);
$this->Html->css('custom', ['block' => true]);
$this->Html->script('jquery', ['block' => true]);
$this->Html->script('bootstrap.min', ['block' => true]);
$this->Html->script('jquery.backstretch.min', ['block' => true]);

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
<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
<?= $this->fetch('script') ?>
<?= $this->fetch('script-inline') ?>
</body>
</html>