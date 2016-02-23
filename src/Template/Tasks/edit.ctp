<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $task->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $task->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Milestones'), ['controller' => 'Milestones', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Milestone'), ['controller' => 'Milestones', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Equipment'), ['controller' => 'Equipment', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Equipment'), ['controller' => 'Equipment', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Manpower'), ['controller' => 'Manpower', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Manpower'), ['controller' => 'Manpower', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materials'), ['controller' => 'Materials', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Material'), ['controller' => 'Materials', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tasks form large-9 medium-8 columns content">
    <?= $this->Form->create($task) ?>
    <fieldset>
        <legend><?= __('Edit Task') ?></legend>
        <?php
            echo $this->Form->input('milestone_id', ['options' => $milestones]);
            echo $this->Form->input('title');
            echo $this->Form->input('is_finished');
            echo $this->Form->input('start_date');
            echo $this->Form->input('end_date');
            echo $this->Form->input('equipment._ids', ['options' => $equipment]);
            echo $this->Form->input('manpower._ids', ['options' => $manpower]);
            echo $this->Form->input('materials._ids', ['options' => $materials]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
