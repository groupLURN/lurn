<div class="employees view large-9 medium-8 columns content">
    <h3><?= h($employee->name) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Employee Name') ?></th>
            <td><?= h($employee->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Employee Type') ?></th>
            <td><?= $employee->has('employee_type') ? h($employee->employee_type->title) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Employment Date') ?></th>
            <td><?= h($employee->employment_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Termination Date') ?></th>
            <td><?= h($employee->termination_date) ?></td>
        </tr>
    </table>
</div>

<div class="employees view large-9 medium-8 columns content">
    <h3><?= __("User Account") ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Username') ?></th>
            <td><?= $employee->user->username ?></td>
        </tr>
    </table>
</div>
<div class="related">
    <h3><?= __('Project Assignments') ?></h3>
    <?php if (!empty($employee->projects)): ?>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= __('Title') ?></th>
                <th><?= __('Client') ?></th>
                <th><?= __('Project Manager') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
                <th><?= __('Project Status') ?></th>
            </tr>
            <?php foreach ($employee->projects as $projects): ?>
                <tr>
                    <td><?= $this->Html->link($projects->title, ['controller' => 'projects', 'action' => 'view', $projects->id]) ?></td>
                    <td><?= $this->Html->link($projects->client->company_name, ['controller' => 'clients', 'action' => 'view', $projects->client_id]) ?></td>
                    <td><?= $this->Html->link($projects->employees[0]->name, ['controller' => 'employees', 'action' => 'view', $projects->employees[0]->id]) ?></td>
                    <td><?= h($projects->start_date) ?></td>
                    <td><?= h($projects->end_date) ?></td>
                    <td><?= h($projects->project_status_id) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employee'), ['action' => 'edit', $employee->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employee'), ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employee Types'), ['controller' => 'EmployeeTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee Type'), ['controller' => 'EmployeeTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employees view large-9 medium-8 columns content">
    <h3><?= h($employee->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $employee->has('user') ? $this->Html->link($employee->user->id, ['controller' => 'Users', 'action' => 'view', $employee->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Employee Type') ?></th>
            <td><?= $employee->has('employee_type') ? $this->Html->link($employee->employee_type->title, ['controller' => 'EmployeeTypes', 'action' => 'view', $employee->employee_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($employee->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($employee->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Employment Date') ?></th>
            <td><?= h($employee->employment_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Termination Date') ?></th>
            <td><?= h($employee->termination_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($employee->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($employee->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Projects') ?></h4>
        <?php if (!empty($employee->projects)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Client Id') ?></th>
                <th><?= __('Project Manager Id') ?></th>
                <th><?= __('Project Status Id') ?></th>
                <th><?= __('Title') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($employee->projects as $projects): ?>
            <tr>
                <td><?= h($projects->id) ?></td>
                <td><?= h($projects->client_id) ?></td>
                <td><?= h($projects->project_manager_id) ?></td>
                <td><?= h($projects->project_status_id) ?></td>
                <td><?= h($projects->title) ?></td>
                <td><?= h($projects->description) ?></td>
                <td><?= h($projects->start_date) ?></td>
                <td><?= h($projects->end_date) ?></td>
                <td><?= h($projects->created) ?></td>
                <td><?= h($projects->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $projects->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Projects', 'action' => 'edit', $projects->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Projects', 'action' => 'delete', $projects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projects->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
-->