<?= $this->Html->script('tasks.js', ['block' => 'script-end']); ?>
<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($task) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Finish Task') ?></h3></legend>
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
                            <legend><h4><i class="fa fa-angle-right"></i> <?= __('Equipment Consumption') ?></h4></legend>
                            <?php if (!empty($task->equipment)): ?>
                                <table cellpadding="0" cellspacing="0" class="table table-striped">
                                    <tr>
                                        <th><?= __('Name') ?></th>
                                        <th><?= __('Quantity Needed') ?></th>
                                        <th><?= __('In-Stock Quantity') ?></th>
                                    </tr>
                                    <?php foreach ($task->equipment as $equipment): ?>
                                        <tr>
                                            <td><?= h($equipment->name) ?></td>
                                            <td><?= h($equipment->_joinData->quantity) ?></td>
                                            <td><?= h($equipment->_joinData->in_stock_quantity) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-4">
                            <legend><h4><i class="fa fa-angle-right"></i> <?= __('Manpower Consumption') ?></h4></legend>
                            <?php if (!empty($task->manpower_types)): ?>
                                <table cellpadding="0" cellspacing="0" class="table table-striped">
                                    <tr>
                                        <th><?= __('Manpower Type') ?></th>
                                        <th><?= __('Quantity Needed') ?></th>
                                        <th><?= __('In-Stock Quantity') ?></th>
                                    </tr>
                                    <?php foreach ($task->manpower_types as $manpower_type): ?>
                                        <tr>
                                            <td><?= h($manpower_type->title) ?></td>
                                            <td><?= h($manpower_type->_joinData->quantity) ?></td>
                                            <td><?= h($manpower_type->_joinData->in_stock_quantity) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-4">
                            <legend><h4><i class="fa fa-angle-right"></i> <?= __('Materials Consumption') ?></h4></legend>
                            <?php if (!empty($task->materials)): ?>
                                <table cellpadding="0" cellspacing="0" class="table table-striped">
                                    <tr>
                                        <th><?= __('Name') ?></th>
                                        <th><?= __('Quantity Needed') ?></th>
                                        <th><?= __('In-Stock Quantity') ?></th>
                                        <th><?= __('Quantity Used') ?></th>
                                    </tr>
                                    <?php foreach ($task->materials as $material): ?>
                                        <tr>
                                            <td><?= h($material->name . ' ' . $material->unit_measure) ?></td>
                                            <td><?= h($material->_joinData->quantity) ?></td>
                                            <td><?= h($material->_joinData->in_stock_quantity) ?></td>
                                            <td><?php
                                                echo $this->Form->input('materials.id[]', [
                                                    'type' => 'hidden',
                                                    'val' => $material->id
                                                ]);
                                                echo $this->Form->input('materials.in_stock_quantity[]', [
                                                    'type' => 'hidden',
                                                    'val' => $material->_joinData->in_stock_quantity,
                                                    'class' => 'in_stock_quantity'
                                                ]);
                                                echo $this->Form->input('materials.quantity_used[]', [
                                                    'class' => 'form-control number-only',
                                                    'label' => false,
                                                    'val' => $material->_joinData->in_stock_quantity,
                                                    'oninput' => "
                                                        var \$context = $(this).closest('tr');
                                                        var inStockQuantity = Number(
                                                            \$context.find('.in_stock_quantity').val()
                                                        );
                                                        if(inStockQuantity < Number($(this).val()))
                                                        {
                                                            alert('Quantity used cannot be greater than in-stock quantity.');
                                                            $(this).val($(this).val().slice(0, -1));
                                                        }
                                                    "
                                                ]);
                                            ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php

        echo $this->Form->input('comments', [
            'class' => 'form-control',
            'label' => [
                'class' => 'mt',
                'text' => 'Comments'
            ],
            'type' => 'textarea'
        ]);

        ?>

        <?= $this->Form->button(__('Finish'), [
            'class' => 'btn btn-primary btn-submit',
            'onclick' => "
            if(!confirm('Once the task is finished, the materials will be returned to the project inventory and this cannot be reverted. Are you sure with your task closing?'))
                event.preventDefault();
            ",
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>