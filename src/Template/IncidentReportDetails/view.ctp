<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Incident Report Detail'), ['action' => 'edit', $incidentReportDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Incident Report Detail'), ['action' => 'delete', $incidentReportDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incidentReportDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Incident Report Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Incident Report Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Incident Report Headers'), ['controller' => 'IncidentReportHeaders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Incident Report Header'), ['controller' => 'IncidentReportHeaders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="incidentReportDetails view large-9 medium-8 columns content">
    <h3><?= h($incidentReportDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Incident Report Header') ?></th>
            <td><?= $incidentReportDetail->has('incident_report_header') ? $this->Html->link($incidentReportDetail->incident_report_header->id, ['controller' => 'IncidentReportHeaders', 'action' => 'view', $incidentReportDetail->incident_report_header->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($incidentReportDetail->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Value') ?></th>
            <td><?= h($incidentReportDetail->value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($incidentReportDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($incidentReportDetail->created) ?></td>
        </tr>
    </table>
</div>
