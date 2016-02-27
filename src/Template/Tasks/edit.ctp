<?= $this->Html->script('tasks.js', ['block' => 'script-end']); ?>
<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($task) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Assign Resources') ?></h3></legend>
        <?php
            echo $this->Form->input('title', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Task'
                ],
                'disabled' => true
            ]);
            echo $this->Form->input('start_date', [
                'type' => 'text',
                'class' => 'form-control datetime-picker',
                'label' => [
                    'class' => 'mt'
                ],
                'disabled' => true
            ]);
            echo $this->Form->input('end_date', [
                'type' => 'text',
                'class' => 'form-control datetime-picker',
                'label' => [
                    'class' => 'mt'
                ],
                'disabled' => true
            ]);
        ?>
            <div class="row mt">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-4">
                            <legend><h4><i class="fa fa-angle-right"></i> <?= __('Assign Equipment Needed') ?></h4></legend>
                        <?= $this->element('multi_select_with_input', [
                            'options' => $equipment,
                            'resource' => 'equipment',
                            'values' => $selectedEquipment
                        ]) ?>
                        </div>
                        <div class="col-xs-4">
                            <legend><h4><i class="fa fa-angle-right"></i> <?= __('Assign Manpower Needed') ?></h4></legend>
                                <?= $this->element('multi_select_with_input', [
                                    'options' => $manpower,
                                    'resource' => 'manpower',
                                    'quantity' => false,
                                    'values' => $selectedManpower
                                ]) ?>
                        </div>
                        <div class="col-xs-4">
                            <legend><h4><i class="fa fa-angle-right"></i> <?= __('Assign Materials Needed') ?></h4></legend>
                                <?= $this->element('multi_select_with_input', [
                                    'options' => $materials,
                                    'resource' => 'materials',
                                    'values' => $selectedMaterials
                                ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>
<!--
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
-->