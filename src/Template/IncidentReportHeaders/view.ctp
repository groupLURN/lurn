<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Incident Report Header'), ['action' => 'edit', $incidentReportHeader->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Incident Report Header'), ['action' => 'delete', $incidentReportHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incidentReportHeader->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Incident Report Headers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Incident Report Header'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Incident Report Details'), ['controller' => 'IncidentReportDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Incident Report Detail'), ['controller' => 'IncidentReportDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="incidentReportHeaders view large-9 medium-8 columns content">
    <h3><?= h($incidentReportHeader->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Project') ?></th>
            <td><?= $incidentReportHeader->has('project') ? $this->Html->link($incidentReportHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $incidentReportHeader->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($incidentReportHeader->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($incidentReportHeader->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Project Engineer') ?></th>
            <td><?= $this->Number->format($incidentReportHeader->project_engineer) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($incidentReportHeader->date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Incident Report Details') ?></h4>
        <?php if (!empty($incidentReportHeader->incident_report_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Incident Report Header Id') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Value') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($incidentReportHeader->incident_report_details as $incidentReportDetails): ?>
            <tr>
                <td><?= h($incidentReportDetails->id) ?></td>
                <td><?= h($incidentReportDetails->incident_report_header_id) ?></td>
                <td><?= h($incidentReportDetails->type) ?></td>
                <td><?= h($incidentReportDetails->value) ?></td>
                <td><?= h($incidentReportDetails->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'IncidentReportDetails', 'action' => 'view', $incidentReportDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'IncidentReportDetails', 'action' => 'edit', $incidentReportDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'IncidentReportDetails', 'action' => 'delete', $incidentReportDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incidentReportDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
