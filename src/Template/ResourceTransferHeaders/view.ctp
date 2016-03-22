<?= $this->assign('title', 'Resource Transfer'); ?>
<div class="resourceTransferHeaders view large-9 medium-8 columns content">
    <h3><?= h('Resource Transfer Number ' . $resourceTransferHeader->number) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Resource Transfer Number') ?></th>
            <td><?= h($resourceTransferHeader->number) ?></td>
        </tr>
        <tr>
            <th><?= __('Transfer From') ?></th>
            <td><?= $resourceTransferHeader->has('project_from') ? $this->Html->link($resourceTransferHeader->project_from->title, ['controller' => 'Projects', 'action' => 'view', $resourceTransferHeader->project_from->id]) : 'General' ?></td>
        </tr>
        <tr>
            <th><?= __('Transfer To') ?></th>
            <td><?= $resourceTransferHeader->has('project_to') ? $this->Html->link($resourceTransferHeader->project_to->title, ['controller' => 'Projects', 'action' => 'view', $resourceTransferHeader->project_to->id]) : 'General' ?></td>
        </tr>
        <tr>
            <th><?= __('Date Transferred') ?></th>
            <td><?= h($resourceTransferHeader->created) ?></td>
        </tr>
    </table>
    <div class="related">
        <?php if (!empty($resourceTransferHeader->equipment_transfer_details)): ?>
        <h4><?= __('Equipment Transfer Details') ?></h4>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Equipment Type') ?></th>
                <th><?= __('Equipment') ?></th>
            </tr>
            <?php foreach ($resourceTransferHeader->equipment_transfer_details as $equipmentTransferDetail): ?>
            <tr>
                <td><?= h($equipmentTransferDetail->equipment_inventory_id) ?></td>
                <td><?= h($equipmentTransferDetail->equipment_inventory['rental_receive_detail_id'] === null? 'In-house': 'Rental') ?></td>
                <td><?= h($equipmentTransferDetail->equipment_inventory->equipment->name) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($resourceTransferHeader->manpower_transfer_details)): ?>
        <h4><?= __('Manpower Transfer Details') ?></h4>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= __('Manpower Type') ?></th>
                <th><?= __('Manpower Name') ?></th>
            </tr>
            <?php foreach ($resourceTransferHeader->manpower_transfer_details as $manpowerTransferDetails): ?>
            <tr>
                <td><?= h($manpowerTransferDetails->manpower->manpower_type->title) ?></td>
                <td><?= h($manpowerTransferDetails->manpower->name) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($resourceTransferHeader->material_transfer_details)): ?>
        <h4><?= __('Material Transfer Details') ?></h4>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= __('Material Name') ?></th>
                <th><?= __('Unit Measure') ?></th>
                <th><?= __('Quantity') ?></th>
            </tr>
            <?php foreach ($resourceTransferHeader->material_transfer_details as $materialTransferDetails): ?>
            <tr>
                <td><?= h($materialTransferDetails->material->name) ?></td>
                <td><?= h($materialTransferDetails->material->unit_measure) ?></td>
                <td><?= h($materialTransferDetails->quantity) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
