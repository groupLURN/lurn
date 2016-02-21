<?php
// Third Party CSS
$this->Html->css('/non_bower_components/webix_kanban_trial/codebase/webix', ['block' => true]);
$this->Html->css('/non_bower_components/webix_kanban_trial/codebase/kanban/kanban', ['block' => true]);
$this->Html->css('/non_bower_components/webix_kanban_trial/codebase/skins/compact', ['block' => true]);
$this->Html->css('/non_bower_components/webix_kanban_trial/samples/common/style', ['block' => true]);
// User-defined CSS
$this->Html->css('kanban', ['block' => true]);

// Third Party Script
$this->Html->script('/non_bower_components/webix_kanban_trial/codebase/webix', ['block' => 'script-end']);
$this->Html->script('/non_bower_components/webix_kanban_trial/codebase/kanban/kanban', ['block' => 'script-end']);
$this->Html->script('/non_bower_components/webix_kanban_trial/samples/common/data', ['block' => 'script-end']);
$this->Html->script('/non_bower_components/webix_kanban_trial/samples/common/types', ['block' => 'script-end']);
// User-defined Script
$this->Html->script('kanban', ['block' => 'script-end']);
?>
<?= $this->Flash->render() ?>

<div id="kanban-board"></div>

<script>
    var projectId = <?= $projectId ?>;
    var kanbanColumns = <?= $kanbanColumns ?>;
    var kanbanData = <?= $kanbanData ?>;
</script>