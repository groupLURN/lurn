<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Resource Request Header'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Resource Request Details'), ['controller' => 'ResourceRequestDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Resource Request Detail'), ['controller' => 'ResourceRequestDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="resourceRequestHeaders index large-9 medium-8 columns content">
    <h3><?= __('Resource Request Headers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('from_project_id') ?></th>
                <th><?= $this->Paginator->sort('to_project_id') ?></th>
                <th><?= $this->Paginator->sort('required_date') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resourceRequestHeaders as $resourceRequestHeader): ?>
            <tr>
                <td><?= $this->Number->format($resourceRequestHeader->id) ?></td>
                <td><?= $this->Number->format($resourceRequestHeader->from_project_id) ?></td>
                <td><?= $resourceRequestHeader->has('project') ? $this->Html->link($resourceRequestHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $resourceRequestHeader->project->id]) : '' ?></td>
                <td><?= h($resourceRequestHeader->required_date) ?></td>
                <td><?= h($resourceRequestHeader->created) ?></td>
                <td><?= h($resourceRequestHeader->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $resourceRequestHeader->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $resourceRequestHeader->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $resourceRequestHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $resourceRequestHeader->id)]) ?>
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
