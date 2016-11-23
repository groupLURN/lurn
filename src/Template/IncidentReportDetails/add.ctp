<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Incident Report Details'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Incident Report Headers'), ['controller' => 'IncidentReportHeaders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Incident Report Header'), ['controller' => 'IncidentReportHeaders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="incidentReportDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($incidentReportDetail) ?>
    <fieldset>
        <legend><?= __('Add Incident Report Detail') ?></legend>
        <?php
            echo $this->Form->input('incident_report_header_id', ['options' => $incidentReportHeaders, 'empty' => true]);
            echo $this->Form->input('type');
            echo $this->Form->input('value');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
