<div class="projects view large-9 medium-8 columns content">
    <h3><?= h($project->title) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($project->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= $this->Text->autoParagraph(h($project->description)); ?></td>
        </tr>
        <tr>
            <th><?= __('Location') ?></th>
            <td><?= h($project->location) ?></td>
        </tr>
        <tr>
            <th><?= __('Client') ?></th>
            <td><?= $project->has('client') ? $this->Html->link($project->client->company_name, ['controller' => 'Clients', 'action' => 'view', $project->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Project Status') ?></th>
            <td><?= h($project->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Project Manager') ?></th>
            <td><?= $this->Html->link($project->employee->name, ['controller' => 'employees', 'action' => 'view', $project->employee->id]) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Date') ?></th>
            <td><?= h($project->start_date) ?></td>
        </tr>
        <tr>
            <th><?= __('End Date') ?></th>
            <td><?= h($project->end_date) ?></td>
        </tr>
    </table>

    <div class="related">
        <h3><?= __('Core Team') ?></h3>
        <?php if (!empty($project->employees_join)): ?>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Employee Type') ?></th>
                    <th><?= __('Employment Date') ?></th>
                    <th><?= __('Termination Date') ?></th>
                </tr>
                <?php foreach ($project->employees_join as $employees_join): ?>
                    <tr>
                        <td><?= h($employees_join->name) ?></td>
                        <td><?= $this->Html->link($employees_join->employee_type->title, ['controller' => 'employees', 'action' => 'view', $employees_join->id]) ?></td>
                        <td><?= h($employees_join->employment_date) ?></td>
                        <td><?= h($employees_join->termination_date) ?></td>
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
        <li><?= $this->Html->link(__('Edit Project'), ['action' => 'edit', $project->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Project'), ['action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Project Statuses'), ['controller' => 'ProjectStatuses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Status'), ['controller' => 'ProjectStatuses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="projects view large-9 medium-8 columns content">
    <h3><?= h($project->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Client') ?></th>
            <td><?= $project->has('project') ? $this->Html->link($project->project->company_name, ['controller' => 'Clients', 'action' => 'view', $project->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Project Status') ?></th>
            <td><?= $project->has('project_status') ? $this->Html->link($project->project_status->title, ['controller' => 'ProjectStatuses', 'action' => 'view', $project->project_status->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($project->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($project->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Project Manager Id') ?></th>
            <td><?= $this->Number->format($project->project_manager_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Date') ?></th>
            <td><?= h($project->start_date) ?></td>
        </tr>
        <tr>
            <th><?= __('End Date') ?></th>
            <td><?= h($project->end_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($project->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($project->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($project->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Employees') ?></h4>
        <?php if (!empty($project->employees_join)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Employee Type Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Employment Date') ?></th>
                <th><?= __('Termination Date') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($project->employees_join as $employees_join): ?>
            <tr>
                <td><?= h($employees_join->id) ?></td>
                <td><?= h($employees_join->user_id) ?></td>
                <td><?= h($employees_join->employee_type_id) ?></td>
                <td><?= h($employees_join->name) ?></td>
                <td><?= h($employees_join->employment_date) ?></td>
                <td><?= h($employees_join->termination_date) ?></td>
                <td><?= h($employees_join->created) ?></td>
                <td><?= h($employees_join->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Employees', 'action' => 'view', $employees_join->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Employees', 'action' => 'edit', $employees_join->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Employees', 'action' => 'delete', $employees_join->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employees_join->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
-->