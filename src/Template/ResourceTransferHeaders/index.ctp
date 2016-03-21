<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Resource Transfer Header'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Resource Request Headers'), ['controller' => 'ResourceRequestHeaders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Resource Request Header'), ['controller' => 'ResourceRequestHeaders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Equipment Transfer Details'), ['controller' => 'EquipmentTransferDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Equipment Transfer Detail'), ['controller' => 'EquipmentTransferDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Manpower Transfer Details'), ['controller' => 'ManpowerTransferDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Manpower Transfer Detail'), ['controller' => 'ManpowerTransferDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Material Transfer Details'), ['controller' => 'MaterialTransferDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Material Transfer Detail'), ['controller' => 'MaterialTransferDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="resourceTransferHeaders index large-9 medium-8 columns content">
    <h3><?= __('Resource Transfer Headers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('resource_request_header_id') ?></th>
                <th><?= $this->Paginator->sort('from_project_id') ?></th>
                <th><?= $this->Paginator->sort('to_project_id') ?></th>
                <th><?= $this->Paginator->sort('received_date') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resourceTransferHeaders as $resourceTransferHeader): ?>
            <tr>
                <td><?= $this->Number->format($resourceTransferHeader->id) ?></td>
                <td><?= $resourceTransferHeader->has('resource_request_header') ? $this->Html->link($resourceTransferHeader->resource_request_header->id, ['controller' => 'ResourceRequestHeaders', 'action' => 'view', $resourceTransferHeader->resource_request_header->id]) : '' ?></td>
                <td><?= $this->Number->format($resourceTransferHeader->from_project_id) ?></td>
                <td><?= $resourceTransferHeader->has('project') ? $this->Html->link($resourceTransferHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $resourceTransferHeader->project->id]) : '' ?></td>
                <td><?= h($resourceTransferHeader->received_date) ?></td>
                <td><?= h($resourceTransferHeader->created) ?></td>
                <td><?= h($resourceTransferHeader->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $resourceTransferHeader->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $resourceTransferHeader->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $resourceTransferHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $resourceTransferHeader->id)]) ?>
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
