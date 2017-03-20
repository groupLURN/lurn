<?= $this->Html->script('tasks.js', ['block' => 'script-end']); ?>
<?= $this->assign('title', 'Equipment Project Inventory') ?>
<!-- start of tabs -->
<div class="row mt">
    <div class="col-xs-12">
        <h3>
            <!--
                <span id="project-status-badge" class="
                    <?= $project->status !== 'Delayed' ? 'hidden' : '' ?>
                ">
                    <?= $project->status === 'Delayed' ? '!' : '' ?>
                </span>
            -->
            <?= h($project->title) ?>        
        </h3>
        <ul class="nav nav-tabs mt">
            <li>
                <a href=<?= $this->Url->build(['controller' => 'ProjectOverview', $projectId])?>>
                    <i class="fa fa-book"></i>
                    <span>Project Overview</span>
                </a>      
            </li>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'events', 'action' => 'project-calendar', $projectId])?>>
                    <i class="fa fa-calendar"></i>
                    <span>Events Calendar</span>
                </a>
            </li>
            <?php 
                if (in_array($employeeType, [0, 1, 2, 3], true)) {
            ?>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'ProjectPlanning', 'action' => 'CreateGanttChart', $projectId])?>>
                    <i class="fa fa-building"></i>
                    <span>Project Planning</span>
                </a>
            </li>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'manage', '?' => ['project_id' => $projectId]]) ?>>
                    <i class="fa fa-recycle"></i>
                    <span>Project Implementation</span>
                </a>
            </li>
            <?php 
                }

                if ($employeeType !== '') {
            ?>
            <li class="active">
                <a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventories', $projectId]) ?>>
                    <i class="fa fa-database"></i>
                    <span>Project Inventories</span>
                </a>
            <?php
                }

                if (in_array($employeeType, [0, 1, 2, 4], true)) {
            ?>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'IncidentReportHeaders', 'action' => 'index', '?' => ['project_id' => $projectId]]) ?>>
                    <i class="fa fa-file"></i>
                    <span>Reports</span>
                </a>
            </li>
            <?php 
                }
            ?>
        </ul>
    </div>
    <div class="col-xs-12 mt">
        <!-- start of sub tabs -->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventories', 'action' => 'index', $projectId]) ?>>
                    <span>
                    Equipment Inventory
                    </span>
                    </a>
                </li>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'MaterialsProjectInventories', 'action' => 'index', $projectId]) ?>>
                    <span>
                    Materials Inventory
                    </span>
                    </a>
                </li>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'ManpowerProjectInventories', 'action' => 'index', $projectId]) ?>>
                    <span>
                    Manpower Inventory
                    </span>
                    </a>
                </li>
            </ul>

        <!-- end of sub tabs -->
    </div>
</div>
<!-- end of tabs -->
<div class="equipment view large-9 medium-8 columns content">
    <h3><?= h($summary->equipment->name) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Equipment Name') ?></th>
            <td><?= h($summary->equipment->name) ?></td>
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
        <h4><?= __('Track Available Rental Equipment') ?></h4>
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
        <h4><?= __('Track Unavailable In-house Equipment') ?></h4>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= h('Milestone') ?></th>
                <th><?= h('Task') ?></th>
                <th><?= h('Start Date') ?></th>
                <th><?= h('End Date') ?></th>
                <th>Status</th>
                <th><?= __('Quantity Assigned') ?></th>
            </tr>
            <?php foreach ($unavailableInHouseEquipment as $detail): ?>
                <tr>
                    <td><?= h($detail['task']->milestone->title) ?></td>
                    <td><?= h($detail['task']->title) ?></td>
                    <td><?= h($detail['task']->start_date) ?></td>
                    <td><?= h($detail['task']->end_date) ?></td>
                    <td>
                        <span class='task-status <?=str_replace(' ', '-', strtolower($detail['task']->status))?>'>
                            <?= h($detail['task']->status) ?>
                        </span>
                    </td>
                    <td><?= $this->Number->format($detail['quantity']) ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<div class="related">
    <?php if (!empty($unavailableRentedEquipment)): ?>
        <h4><?= __('Track Unavailable Rental Equipment') ?></h4>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th></th>
                <th><?= h('Milestone') ?></th>
                <th><?= h('Task') ?></th>
                <th><?= h('Start Date') ?></th>
                <th><?= h('End Date') ?></th>
                <th>Status</th>
                <th><?= __('Quantity Assigned') ?></th>
            </tr>
            <?php foreach ($unavailableRentedEquipment as $detail): ?>
                <tr>
                    <td>
                        <button data-toggle="collapse" data-target="#task-<?=$detail['task']->id?>"
                                class="btn btn-info btn-xs collapsable-button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </td>
                    <td><?= h($detail['task']->milestone->title) ?></td>
                    <td><?= h($detail['task']->title) ?></td>
                    <td><?= h($detail['task']->start_date) ?></td>
                    <td><?= h($detail['task']->end_date) ?></td>
                    <td>
                        <span class='task-status <?=str_replace(' ', '-', strtolower($detail['task']->status))?>'>
                            <?= h($detail['task']->status) ?>
                        </span>
                    </td>
                    <td><?= $this->Number->format($detail['quantity']) ?> </td>
                </tr>
                <tr id="task-<?=$detail['task']->id?>" class="collapse">
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

<div class="related">
    <?php if (!empty($inHouseEquipment)): ?>
        <h4><?= __('Track Equipment') ?></h4>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= h('Milestone') ?></th>
                <th><?= h('Task') ?></th>
                <th><?= h('Start Date') ?></th>
                <th><?= h('End Date') ?></th>
                <th>Status</th>
                <th><?= __('Quantity Assigned') ?></th>
            </tr>
            <?php foreach ($inHouseEquipment as $detail): ?>
                <tr>
                    <td><?= h($detail['task']->milestone->title) ?></td>
                    <td><?= h($detail['task']->title) ?></td>
                    <td><?= h($detail['task']->start_date) ?></td>
                    <td><?= h($detail['task']->end_date) ?></td>
                    <td>
                        <span class='task-status <?=str_replace(' ', '-', strtolower($detail['task']->status))?>'>
                            <?= h($detail['task']->status) ?>
                        </span>
                    </td>
                    <td><?= $this->Number->format($detail['quantity']) ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>