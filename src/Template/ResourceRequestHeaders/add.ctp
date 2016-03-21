<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Resource Request Headers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Resource Request Details'), ['controller' => 'ResourceRequestDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Resource Request Detail'), ['controller' => 'ResourceRequestDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="resourceRequestHeaders form large-9 medium-8 columns content">
    <?= $this->Form->create($resourceRequestHeader) ?>
    <fieldset>
        <legend><?= __('Add Resource Request Header') ?></legend>
        <?php
            echo $this->Form->input('from_project_id');
            echo $this->Form->input('to_project_id', ['options' => $projects, 'empty' => true]);
            echo $this->Form->input('required_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
