<?= $this->assign('title', 'Equipment General Inventory') ?>
<div class="equipment view large-9 medium-8 columns content">
    <h3><?= h($summary->name) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Equipment Name') ?></th>
            <td><?= h($summary->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Available Quantity') ?></th>
            <td><?= h($summary->available_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Unavailable Quantity') ?></th>
            <td><?= h($summary->unavailable_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Total Quantity') ?></th>
            <td><?= h($summary->available_quantity + $summary->unavailable_quantity) ?></td>
        </tr>
    </table>
</div>

<div class="related">
    <h3><?= __('Track Equipment') ?></h3>
    <?php if (!empty($equipment->equipment_project_inventories)): ?>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= __('Project') ?></th>
                <th><?= __('Client') ?></th>
                <th><?= __('Project Manager') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
                <th><?= __('Project Status') ?></th>
                <th><?= __('Quantity Assigned') ?></th>
            </tr>
            <?php foreach ($equipment->equipment_project_inventories as $projectInventory): ?>
                <tr>
                    <td><?= $this->Html->link($projectInventory->project->title, ['controller' => 'projects', 'action' => 'view', $projectInventory->project->id]) ?></td>
                    <td><?= $this->Html->link($projectInventory->project->client->company_name, ['controller' => 'clients', 'action' => 'view', $projectInventory->project->client_id]) ?></td>
                    <td><?= $this->Html->link($projectInventory->project->employee->name, ['controller' => 'employees', 'action' => 'view', $projectInventory->project->employee->id]) ?></td>
                    <td><?= h($projectInventory->project->start_date) ?></td>
                    <td><?= h($projectInventory->project->end_date) ?></td>
                    <td><?= h($projectInventory->project->project_status->title) ?></td>
                    <td><?= $this->Number->format($projectInventory->quantity) ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>