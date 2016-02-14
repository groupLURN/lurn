<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Manpower'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Manpower Types'), ['controller' => 'ManpowerTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Manpower Type'), ['controller' => 'ManpowerTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="manpower index large-9 medium-8 columns content">
    <h3><?= __('Manpower') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('manpower_type_id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($manpower as $manpower): ?>
            <tr>
                <td><?= $this->Number->format($manpower->id) ?></td>
                <td><?= $manpower->has('manpower_type') ? $this->Html->link($manpower->manpower_type->title, ['controller' => 'ManpowerTypes', 'action' => 'view', $manpower->manpower_type->id]) : '' ?></td>
                <td><?= h($manpower->name) ?></td>
                <td><?= h($manpower->created) ?></td>
                <td><?= h($manpower->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $manpower->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $manpower->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $manpower->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manpower->id)]) ?>
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
