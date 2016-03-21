<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Resource Request Header'), ['action' => 'edit', $resourceRequestHeader->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Resource Request Header'), ['action' => 'delete', $resourceRequestHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $resourceRequestHeader->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Resource Request Headers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Resource Request Header'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Resource Request Details'), ['controller' => 'ResourceRequestDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Resource Request Detail'), ['controller' => 'ResourceRequestDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="resourceRequestHeaders view large-9 medium-8 columns content">
    <h3><?= h($resourceRequestHeader->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Project') ?></th>
            <td><?= $resourceRequestHeader->has('project') ? $this->Html->link($resourceRequestHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $resourceRequestHeader->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($resourceRequestHeader->id) ?></td>
        </tr>
        <tr>
            <th><?= __('From Project Id') ?></th>
            <td><?= $this->Number->format($resourceRequestHeader->from_project_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Required Date') ?></th>
            <td><?= h($resourceRequestHeader->required_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($resourceRequestHeader->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($resourceRequestHeader->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Resource Request Details') ?></h4>
        <?php if (!empty($resourceRequestHeader->resource_request_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Resource Request Header Id') ?></th>
                <th><?= __('Equipment Id') ?></th>
                <th><?= __('Material Id') ?></th>
                <th><?= __('Manpower Type Id') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($resourceRequestHeader->resource_request_details as $resourceRequestDetails): ?>
            <tr>
                <td><?= h($resourceRequestDetails->id) ?></td>
                <td><?= h($resourceRequestDetails->resource_request_header_id) ?></td>
                <td><?= h($resourceRequestDetails->equipment_id) ?></td>
                <td><?= h($resourceRequestDetails->material_id) ?></td>
                <td><?= h($resourceRequestDetails->manpower_type_id) ?></td>
                <td><?= h($resourceRequestDetails->quantity) ?></td>
                <td><?= h($resourceRequestDetails->created) ?></td>
                <td><?= h($resourceRequestDetails->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ResourceRequestDetails', 'action' => 'view', $resourceRequestDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ResourceRequestDetails', 'action' => 'edit', $resourceRequestDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ResourceRequestDetails', 'action' => 'delete', $resourceRequestDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $resourceRequestDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
