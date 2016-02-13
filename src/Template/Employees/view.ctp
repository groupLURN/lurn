<div class="employees view large-9 medium-8 columns content">
    <h3><?= h($employee->name) ?></h3>
    <table class="vertical-table table table-striped">
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
</div>
