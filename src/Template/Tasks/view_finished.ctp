<?= $this->Html->script('tasks.js', ['block' => 'script-end']); ?>
<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->Form->button('<i class="fa fa-save"></i> Save as PDF', 
            array('onclick' => "location.href='" . $this->Url->build('/tasks/generate-report/'.$task->id.'/1?project_id=').$projectId."'",
            'class' => 'btn btn-primary')); ?>
        <?= $this->Form->button('<i class="fa fa-print"></i> Print', 
            array('onclick' => "location.href='" . $this->Url->build('/tasks/generate-report/'.$task->id.'/0?project_id=').$projectId."'",
            'class' => 'btn btn-warning')); ?>
    </div>
</div>
<div class="row mt">

    <div class="col-md-12">
        <fieldset>
            <legend><h3></i> <?= $task->title?></h3></legend>
        <?php
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
                <legend><h4><i class="fa fa-angle-right"></i> <?= __('Equipment Consumption') ?></h4></legend>
                <?php if (!empty($task->equipment)): ?>
                    <table cellpadding="0" cellspacing="0" class="table table-striped">
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Quantity Needed') ?></th>
                            <th><?= __('Quantity Added ') ?></th>
                            <th><?= __('Quantity In-Stock ') ?></th>
                            <th><?= __('Quantity Used') ?></th>
                        </tr>
                        <?php foreach ($task->equipment as $equipment): ?>
                            <tr>
                                <td><?= h($equipment->name) ?></td>
                                <td><?= h($equipment->_joinData->quantity) ?></td>
                                <td><?= h($equipment->_joinData->quantity > $equipment->quantity_used ? 0 : $equipment->quantity_used - $equipment->_joinData->quantity) ?></td>
                                <td><?= h($equipment->quantity_in_stock) ?></td>
                                <td><?= h($equipment->quantity_used) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>No data available.</p>
                <?php endif; ?>
                <legend><h4><i class="fa fa-angle-right"></i> <?= __('Manpower Consumption') ?></h4></legend>
                <?php if (!empty($task->manpower_types)): ?>
                    <table cellpadding="0" cellspacing="0" class="table table-striped">
                        <tr>
                            <th><?= __('Manpower Type') ?></th>
                            <th><?= __('Quantity Needed') ?></th>
                            <th><?= __('Quantity Added ') ?></th>
                            <th><?= __('Quantity In-Stock ') ?></th>
                            <th><?= __('Quantity Used') ?></th>
                        </tr>
                        <?php foreach ($task->manpower_types as $manpower_type): ?>
                            <tr>
                                <td><?= h($manpower_type->title) ?></td>
                                <td><?= h($manpower_type->_joinData->quantity) ?></td>
                                <td><?= h($manpower_type->_joinData->quantity > $manpower_type->quantity_used ? 0 : $manpower_type->quantity_used - $manpower_type->_joinData->quantity) ?></td>
                                <td><?= h($manpower_type->quantity_in_stock) ?></td>
                                <td><?= h($manpower_type->quantity_used) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>No data available.</p>
                <?php endif; ?>
                <legend><h4><i class="fa fa-angle-right"></i> <?= __('Materials Consumption') ?></h4></legend>
                <?php if (!empty($task->materials)): ?>
                    <table cellpadding="0" cellspacing="0" class="table table-striped">
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Quantity Needed') ?></th>
                            <th><?= __('Quantity Added ') ?></th>
                            <th><?= __('Quantity In-Stock ') ?></th>
                            <th><?= __('Quantity Used') ?></th>
                        </tr>
                        <?php foreach ($task->materials as $material): ?>
                            <tr>
                                <td><?= h($material->name . ' ' . $material->unit_measure) ?></td>
                                <td><?= h($material->_joinData->quantity) ?></td>
                                <td><?= h($material->_joinData->quantity > $material->quantity_used ? 0 : $material->quantity_used - $material->_joinData->quantity) ?></td>
                                <td><?= h($material->quantity_in_stock) ?></td>
                                <td><?= h($material->quantity_used) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>No data available.</p>
                <?php endif; ?>
        
                <?php

                echo $this->Form->input('comments', [
                    'class' => 'form-control',
                    'label' => [
                        'class' => 'mt',
                        'text' => 'Comments'
                    ],
                    'type' => 'textarea',
                    'disabled' => true,
                    'value' => $task->comments
                ]);

                ?>
            </div>                    
        </div>
    </div>
</div>