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
//            echo $this->Form->input('equipment._ids', [
//                'options' => $equipment,
//                'label' => ['class' => 'mt'],
//                'class' => 'form-control'
//            ]);

//            echo $this->Form->input('manpower._ids', [
//                'options' => $manpower,
//                'label' => ['class' => 'mt'],
//                'class' => 'form-control'
//            ]);
//
//            echo $this->Form->input('materials._ids', [
//                'options' => $materials,
//                'label' => ['class' => 'mt'],
//                'class' => 'form-control'
//            ]);
        ?>
            <div class="row mt">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-4">
                            <legend><h4><i class="fa fa-angle-right"></i> <?= __('Assign Equipment') ?></h4></legend>
                            <div class="content-panel" style="text-align: center;">
                                <table style="margin: auto;">
                                    <tr>
                                        <td style="padding-right: 20px;">
                                            <?= $this->Form->input('equipment_list', [
                                                'label' => false,
                                                'type' => 'select',
                                                'class' => 'chosen resource form-control',
                                                'options' => $equipment
                                            ]) ?>
                                        </td>
                                        <td>
                                            <label> Quantity Needed: </label>
                                            <input type="text" class='number-only resource-quantity' style="width: 40px;">
                                            <img src="/img/add.png" alt="Add" style="vertical-align: middle;"
                                                 class="add-button">
                                        </td>
                                    </tr>
                                </table>
                                <ul class="options mt" style="margin: 20px auto;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <legend><h4><i class="fa fa-angle-right"></i> <?= __('Assign Manpower') ?></h4></legend>
                            <div class="content-panel">

                            </div>
                        </div>
                        <div class="col-xs-4">
                            <legend><h4><i class="fa fa-angle-right"></i> <?= __('Assign Materials') ?></h4></legend>
                            <div class="content-panel">

                            </div>
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