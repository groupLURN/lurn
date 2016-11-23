<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Incident Report Detail'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Incident Report Headers'), ['controller' => 'IncidentReportHeaders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Incident Report Header'), ['controller' => 'IncidentReportHeaders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="incidentReportDetails index large-9 medium-8 columns content">
    <h3><?= __('Incident Report Details') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('incident_report_header_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidentReportDetails as $incidentReportDetail): ?>
            <tr>
                <td><?= $this->Number->format($incidentReportDetail->id) ?></td>
                <td><?= $incidentReportDetail->has('incident_report_header') ? $this->Html->link($incidentReportDetail->incident_report_header->id, ['controller' => 'IncidentReportHeaders', 'action' => 'view', $incidentReportDetail->incident_report_header->id]) : '' ?></td>
                <td><?= h($incidentReportDetail->type) ?></td>
                <td><?= h($incidentReportDetail->value) ?></td>
                <td><?= h($incidentReportDetail->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $incidentReportDetail->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $incidentReportDetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $incidentReportDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incidentReportDetail->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
