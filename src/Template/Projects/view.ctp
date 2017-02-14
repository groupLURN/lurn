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
            <th><?= __('Project Phase') ?></th>
            <td><?= h($project->project_phase->name) ?></td>
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
            <td><?= h(isset($project->start_date) ? date_format($project->start_date, 'F d, Y') : '') ?></td>
        </tr>
        <tr>
            <th><?= __('End Date') ?></th>
            <td><?= h(isset($project->end_date) ? date_format($project->end_date, 'F d, Y') : '') ?></td>
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
                        <td><?= h(date_format($employees_join->employment_date, 'F d, Y')) ?></td>
                        <td><?= h(isset($employees_join->termination_date) ? date_format($employees_join->termination_date, 'F d, Y') : '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>