<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Resource Transfer Header'), ['action' => 'edit', $resourceTransferHeader->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Resource Transfer Header'), ['action' => 'delete', $resourceTransferHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $resourceTransferHeader->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Resource Transfer Headers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Resource Transfer Header'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Resource Request Headers'), ['controller' => 'ResourceRequestHeaders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Resource Request Header'), ['controller' => 'ResourceRequestHeaders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Equipment Transfer Details'), ['controller' => 'EquipmentTransferDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Equipment Transfer Detail'), ['controller' => 'EquipmentTransferDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Manpower Transfer Details'), ['controller' => 'ManpowerTransferDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Manpower Transfer Detail'), ['controller' => 'ManpowerTransferDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Material Transfer Details'), ['controller' => 'MaterialTransferDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Material Transfer Detail'), ['controller' => 'MaterialTransferDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="resourceTransferHeaders view large-9 medium-8 columns content">
    <h3><?= h($resourceTransferHeader->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Resource Request Header') ?></th>
            <td><?= $resourceTransferHeader->has('resource_request_header') ? $this->Html->link($resourceTransferHeader->resource_request_header->id, ['controller' => 'ResourceRequestHeaders', 'action' => 'view', $resourceTransferHeader->resource_request_header->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Project') ?></th>
            <td><?= $resourceTransferHeader->has('project') ? $this->Html->link($resourceTransferHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $resourceTransferHeader->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($resourceTransferHeader->id) ?></td>
        </tr>
        <tr>
            <th><?= __('From Project Id') ?></th>
            <td><?= $this->Number->format($resourceTransferHeader->from_project_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Received Date') ?></th>
            <td><?= h($resourceTransferHeader->received_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($resourceTransferHeader->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($resourceTransferHeader->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Equipment Transfer Details') ?></h4>
        <?php if (!empty($resourceTransferHeader->equipment_transfer_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Resource Transfer Header Id') ?></th>
                <th><?= __('Equipment Inventory Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($resourceTransferHeader->equipment_transfer_details as $equipmentTransferDetails): ?>
            <tr>
                <td><?= h($equipmentTransferDetails->resource_transfer_header_id) ?></td>
                <td><?= h($equipmentTransferDetails->equipment_inventory_id) ?></td>
                <td><?= h($equipmentTransferDetails->created) ?></td>
                <td><?= h($equipmentTransferDetails->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EquipmentTransferDetails', 'action' => 'view', $equipmentTransferDetails->resource_transfer_header_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EquipmentTransferDetails', 'action' => 'edit', $equipmentTransferDetails->resource_transfer_header_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EquipmentTransferDetails', 'action' => 'delete', $equipmentTransferDetails->resource_transfer_header_id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipmentTransferDetails->resource_transfer_header_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Manpower Transfer Details') ?></h4>
        <?php if (!empty($resourceTransferHeader->manpower_transfer_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Resource Transfer Header Id') ?></th>
                <th><?= __('Manpower Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($resourceTransferHeader->manpower_transfer_details as $manpowerTransferDetails): ?>
            <tr>
                <td><?= h($manpowerTransferDetails->resource_transfer_header_id) ?></td>
                <td><?= h($manpowerTransferDetails->manpower_id) ?></td>
                <td><?= h($manpowerTransferDetails->created) ?></td>
                <td><?= h($manpowerTransferDetails->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ManpowerTransferDetails', 'action' => 'view', $manpowerTransferDetails->resource_transfer_header_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ManpowerTransferDetails', 'action' => 'edit', $manpowerTransferDetails->resource_transfer_header_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ManpowerTransferDetails', 'action' => 'delete', $manpowerTransferDetails->resource_transfer_header_id], ['confirm' => __('Are you sure you want to delete # {0}?', $manpowerTransferDetails->resource_transfer_header_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Material Transfer Details') ?></h4>
        <?php if (!empty($resourceTransferHeader->material_transfer_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Resource Transfer Header Id') ?></th>
                <th><?= __('Material Id') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($resourceTransferHeader->material_transfer_details as $materialTransferDetails): ?>
            <tr>
                <td><?= h($materialTransferDetails->resource_transfer_header_id) ?></td>
                <td><?= h($materialTransferDetails->material_id) ?></td>
                <td><?= h($materialTransferDetails->quantity) ?></td>
                <td><?= h($materialTransferDetails->created) ?></td>
                <td><?= h($materialTransferDetails->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MaterialTransferDetails', 'action' => 'view', $materialTransferDetails->resource_transfer_header_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MaterialTransferDetails', 'action' => 'edit', $materialTransferDetails->resource_transfer_header_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MaterialTransferDetails', 'action' => 'delete', $materialTransferDetails->resource_transfer_header_id], ['confirm' => __('Are you sure you want to delete # {0}?', $materialTransferDetails->resource_transfer_header_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
