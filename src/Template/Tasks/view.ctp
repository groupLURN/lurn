<div class="tasks view large-9 medium-8 columns content">
    <h3><?= h($task->title) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Milestone') ?></th>
            <td><?= h($task->milestone->title); ?></td>
        </tr>
        <tr>
            <th><?= __('Task') ?></th>
            <td><?= h($task->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Date') ?></th>
            <td><?= h($task->start_date) ?></td>
        </tr>
        <tr>
            <th><?= __('End Date') ?></th>
            <td><?= h($task->end_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $task->status; ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Assigned Equipment') ?></h4>
        <?php if (!empty($task->equipment)): ?>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Quantity Needed') ?></th>
                </tr>
                <?php foreach ($task->equipment as $equipment): ?>
                    <tr>
                        <td><?= h($equipment->name) ?></td>
                        <th><?= h($equipment->_joinData->quantity) ?></th>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Assigned Manpower') ?></h4>
        <?php if (!empty($task->manpower)): ?>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Manpower Type') ?></th>
                    <th><?= __('Name') ?></th>
                </tr>
                <?php foreach ($task->manpower as $manpower): ?>
                    <tr>
                        <td><?= h($manpower->manpower_type->title) ?></td>
                        <td><?= h($manpower->name) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Assigned Materials') ?></h4>
        <?php if (!empty($task->materials)): ?>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Unit Measure') ?></th>
                    <th><?= __('Quantity Needed') ?></th>
                </tr>
                <?php foreach ($task->materials as $materials): ?>
                    <tr>
                        <td><?= h($materials->name) ?></td>
                        <td><?= h($materials->unit_measure) ?></td>
                        <td><?= h($materials->_joinData->quantity) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>
<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Task'), ['action' => 'edit', $task->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Task'), ['action' => 'delete', $task->id], ['confirm' => __('Are you sure you want to delete # {0}?', $task->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tasks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Task'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Milestones'), ['controller' => 'Milestones', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Milestone'), ['controller' => 'Milestones', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Equipment'), ['controller' => 'Equipment', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Equipment'), ['controller' => 'Equipment', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Manpower'), ['controller' => 'Manpower', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Manpower'), ['controller' => 'Manpower', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Materials'), ['controller' => 'Materials', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Material'), ['controller' => 'Materials', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tasks view large-9 medium-8 columns content">
    <h3><?= h($task->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($task->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Milestone') ?></th>
            <td><?= $task->has('milestone') ? $this->Html->link($task->milestone->title, ['controller' => 'Milestones', 'action' => 'view', $task->milestone->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($task->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Date') ?></th>
            <td><?= h($task->start_date) ?></td>
        </tr>
        <tr>
            <th><?= __('End Date') ?></th>
            <td><?= h($task->end_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($task->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($task->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Is Finished') ?></th>
            <td><?= $task->is_finished ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Equipment') ?></h4>
        <?php if (!empty($task->equipment)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($task->equipment as $equipment): ?>
            <tr>
                <td><?= h($equipment->id) ?></td>
                <td><?= h($equipment->name) ?></td>
                <td><?= h($equipment->created) ?></td>
                <td><?= h($equipment->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Equipment', 'action' => 'view', $equipment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Equipment', 'action' => 'edit', $equipment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Equipment', 'action' => 'delete', $equipment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipment->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Manpower') ?></h4>
        <?php if (!empty($task->manpower)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Manpower Type Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($task->manpower as $manpower): ?>
            <tr>
                <td><?= h($manpower->id) ?></td>
                <td><?= h($manpower->manpower_type_id) ?></td>
                <td><?= h($manpower->name) ?></td>
                <td><?= h($manpower->created) ?></td>
                <td><?= h($manpower->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Manpower', 'action' => 'view', $manpower->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Manpower', 'action' => 'edit', $manpower->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Manpower', 'action' => 'delete', $manpower->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manpower->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Materials') ?></h4>
        <?php if (!empty($task->materials)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Unit Measure') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($task->materials as $materials): ?>
            <tr>
                <td><?= h($materials->id) ?></td>
                <td><?= h($materials->name) ?></td>
                <td><?= h($materials->unit_measure) ?></td>
                <td><?= h($materials->created) ?></td>
                <td><?= h($materials->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Materials', 'action' => 'view', $materials->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Materials', 'action' => 'edit', $materials->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Materials', 'action' => 'delete', $materials->id], ['confirm' => __('Are you sure you want to delete # {0}?', $materials->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
