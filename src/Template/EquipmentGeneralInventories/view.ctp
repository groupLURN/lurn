<?= $this->Html->script('tasks.js', ['block' => 'script-end']); ?>
<?= $this->assign('title', 'Equipment General Inventory') ?>
<div class="equipment view large-9 medium-8 columns content">
    <h3><?= h($summary->name) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Equipment Name') ?></th>
            <td><?= h($summary->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Available In-house Quantity') ?></th>
            <td><?= $this->Number->format($summary->available_in_house_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Available Rented Quantity') ?></th>
            <td><?= $this->Number->format($summary->available_rented_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Unavailable In-house Quantity') ?></th>
            <td><?= $this->Number->format($summary->unavailable_in_house_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Unavailable Rented Quantity') ?></th>
            <td><?= $this->Number->format($summary->unavailable_rented_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Total Quantity') ?></th>
            <td><?= $this->Number->format($summary->available_in_house_quantity + $summary->available_rented_quantity + $summary->unavailable_in_house_quantity + $summary->unavailable_rented_quantity) ?></td>
        </tr>
    </table>
</div>

<div class="related">
    <?php if (!$availableRentedEquipmentByRental->isEmpty()): ?>
        <h3><?= __('Track Available Rental Equipment') ?></h3>
        <table class="table table-striped table-advance table-hover">
            <thead>
            <tr>
                <th><?= __('Rental Receive Number') ?></th>
                <th><?= __('Supplier') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($availableRentedEquipmentByRental as $detail): ?>
                <tr>
                    <td><?= h($detail[0]['rental_receive_detail']['rental_receive_header']['id']) ?></td>
                    <td><?= h($detail[0]['rental_receive_detail']['rental_request_detail']['rental_request_header']['supplier']['name']) ?></td>
                    <td><?= h(count($detail)) ?></td>
                    <td><?= h($detail[0]['rental_receive_detail']['start_date']) ?></td>
                    <td><?= h($detail[0]['rental_receive_detail']['end_date']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div class="related">
    <?php if (!empty($unavailableInHouseEquipment)): ?>
    <h3><?= __('Track Unavailable In-house Equipment') ?></h3>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= __('Project') ?></th>
                <th><?= __('Location') ?></th>
                <th><?= __('Client') ?></th>
                <th><?= __('Project Manager') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
                <th><?= __('Project Status') ?></th>
                <th><?= __('Quantity Assigned') ?></th>
            </tr>
            <?php foreach ($unavailableInHouseEquipment as $detail): ?>
                <tr>
                    <td><?= $this->Html->link($detail['project']->title, ['controller' => 'projects', 'action' => 'view', $detail['project']->id]) ?></td>
                    <td><?= h($detail['project']->location) ?></td>
                    <td><?= $this->Html->link($detail['project']->client->company_name, ['controller' => 'clients', 'action' => 'view', $detail['project']->client_id]) ?></td>
                    <td><?= $this->Html->link($detail['project']->employee->name, ['controller' => 'employees', 'action' => 'view', $detail['project']->employee->id]) ?></td>
                    <td><?= h($detail['project']->start_date) ?></td>
                    <td><?= h($detail['project']->end_date) ?></td>
                    <td><?= h($detail['project']->project_status->title) ?></td>
                    <td><?= $this->Number->format($detail['quantity']) ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<div class="related">
    <?php if (!empty($unavailableRentedEquipment)): ?>
        <h3><?= __('Track Unavailable Rental Equipment') ?></h3>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th></th>
                <th><?= __('Project') ?></th>
                <th><?= __('Location') ?></th>
                <th><?= __('Client') ?></th>
                <th><?= __('Project Manager') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
                <th><?= __('Project Status') ?></th>
                <th><?= __('Quantity Assigned') ?></th>
            </tr>
            <?php foreach ($unavailableRentedEquipment as $detail): ?>
                <tr>
                    <td>
                        <button data-toggle="collapse" data-target="#project-<?=$detail['project']->id?>"
                                class="btn btn-info btn-xs collapsable-button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </td>
                    <td><?= $this->Html->link($detail['project']->title, ['controller' => 'projects', 'action' => 'view', $detail['project']->id]) ?></td>
                    <td><?= h($detail['project']->location) ?></td>
                    <td><?= $this->Html->link($detail['project']->client->company_name, ['controller' => 'clients', 'action' => 'view', $detail['project']->client_id]) ?></td>
                    <td><?= $this->Html->link($detail['project']->employee->name, ['controller' => 'employees', 'action' => 'view', $detail['project']->employee->id]) ?></td>
                    <td><?= h($detail['project']->start_date) ?></td>
                    <td><?= h($detail['project']->end_date) ?></td>
                    <td><?= h($detail['project']->project_status->title) ?></td>
                    <td><?= $this->Number->format($detail['quantity']) ?> </td>
                </tr>
                <tr id="project-<?=$detail['project']->id?>" class="collapse">
                    <td colspan="3" style="padding-left: 30px">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th><?= __('Rental Receive Number') ?></th>
                                <th><?= __('Supplier') ?></th>
                                <th><?= __('Quantity') ?></th>
                                <th><?= __('Start Date') ?></th>
                                <th><?= __('End Date') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($detail['details'] as $detail): ?>
                                <tr>
                                    <td><?= h($detail[0]['rental_receive_detail']['rental_receive_header']['id']) ?></td>
                                    <td><?= h($detail[0]['rental_receive_detail']['rental_request_detail']['rental_request_header']['supplier']['name']) ?></td>
                                    <td><?= h(count($detail)) ?></td>
                                    <td><?= h($detail[0]['rental_receive_detail']['start_date']) ?></td>
                                    <td><?= h($detail[0]['rental_receive_detail']['end_date']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>