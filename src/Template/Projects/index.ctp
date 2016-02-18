<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('New Project'), ['action' => 'add']); ?>
    </div>
</div>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <?= $this->Form->create('Search', ['type' => 'GET']) ?>
            <h4><i class="fa fa-angle-right"></i> Filters </h4>
            <hr>
            <table class="table">
                <tbody>
                <tr>
                    <td colspan="4">
                        <div class="row mt">
                            <div class="col-xs-10">
                                <input type="text" name="title" class="form-control" placeholder="Search Project's Title"
                                       id="txt-search" <?= isset($title)? "value='" . $title . "'": ""; ?> >
                            </div>
                            <div class="col-xs-2">
                                <?= $this->Form->button(__('Search'), [
                                    'id' => 'btn-search',
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <?= $this->Form->end(); ?>
        </div><!-- --/content-panel ---->
    </div>
</div>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i> <?= __('Projects') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('client_id') ?></th>
                    <th><?= $this->Paginator->sort('project_manager_id') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('project_status_id') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><?= h($project->title) ?></td>
                        <td><?= $project->has('client') ? $this->Html->link($project->client->company_name, ['controller' => 'Clients', 'action' => 'view', $project->client->id]) : '' ?></td>
                        <td><?= $project->has('employee') ? $this->Html->link($project->employee->name, ['controller' => 'Employees', 'action' => 'view', $project->employee->id]) : '' ?></td>
                        <td><?= h($project->start_date) ?></td>
                        <td><?= h($project->end_date) ?></td>
                        <td><?= $project->has('project_status') ? $this->Html->link($project->project_status->title, ['controller' => 'ProjectStatuses', 'action' => 'view', $project->project_status->id]) : '' ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $project->id]); ?>
                            <?= $this->dataTableEditButton(__('Edit'), ['action' => 'edit', $project->id]); ?>
                            <?= $this->dataTableDeleteButton(__('Delete'),
                                ['action' => 'delete', $project->id],
                                __('Are you sure you want to delete {0}?', $project->title)
                            );
                            ?>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                </ul>
                <p><?= $this->Paginator->counter() ?></p>
            </div>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->
<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Statuses'), ['controller' => 'ProjectStatuses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Status'), ['controller' => 'ProjectStatuses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projects index large-9 medium-8 columns content">
    <h3><?= __('Projects') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('client_id') ?></th>
                <th><?= $this->Paginator->sort('project_manager_id') ?></th>
                <th><?= $this->Paginator->sort('project_status_id') ?></th>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('start_date') ?></th>
                <th><?= $this->Paginator->sort('end_date') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
            <tr>
                <td><?= $this->Number->format($project->id) ?></td>
                <td><?= $project->has('client') ? $this->Html->link($project->client->id, ['controller' => 'Clients', 'action' => 'view', $project->client->id]) : '' ?></td>
                <td><?= $project->has('employee') ? $this->Html->link($project->employee->name, ['controller' => 'Employees', 'action' => 'view', $project->employee->id]) : '' ?></td>
                <td><?= $project->has('project_status') ? $this->Html->link($project->project_status->title, ['controller' => 'ProjectStatuses', 'action' => 'view', $project->project_status->id]) : '' ?></td>
                <td><?= h($project->title) ?></td>
                <td><?= h($project->start_date) ?></td>
                <td><?= h($project->end_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $project->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $project->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
-->