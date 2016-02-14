<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Manpower'), ['action' => 'edit', $manpower->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Manpower'), ['action' => 'delete', $manpower->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manpower->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Manpower'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Manpower'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Manpower Types'), ['controller' => 'ManpowerTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Manpower Type'), ['controller' => 'ManpowerTypes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="manpower view large-9 medium-8 columns content">
    <h3><?= h($manpower->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Manpower Type') ?></th>
            <td><?= $manpower->has('manpower_type') ? $this->Html->link($manpower->manpower_type->title, ['controller' => 'ManpowerTypes', 'action' => 'view', $manpower->manpower_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($manpower->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($manpower->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($manpower->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($manpower->modified) ?></td>
        </tr>
    </table>
</div>
