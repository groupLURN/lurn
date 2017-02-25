<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Create Purchase Order') ?>

<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($purchaseOrderHeader) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i>Create Purchase Order</h3></legend>
            <?php
            echo $this->Form->input('project_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'class' => 'mt'
                ],
                'options' => [null => '-Choose a Project-'] + $projects
            ]);

            echo $this->Form->input('milestone_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'class' => 'mt'
                ],
                'options' => [null => '-Choose a Milestone-']
            ]);

            echo $this->Form->input('task_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'class' => 'mt'
                ],
                'options' => [null => '-Choose a Task-']
            ]);

            echo $this->Form->input('supplier_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'class' => 'mt'
                ],
                'options' => [null => '-Choose a Supplier-']
            ]);

            ?>
            <?= $this->element('editable_data_table', [
                'tableWidth' => '50%',
                'headers' => [
                    'Materials',
                    'Quantity',
                    'Project Inventory Quantity'
                ],
                'hasAdd' => false,
                'id' => 'purchase-order-add'
            ]); ?>
        </fieldset>

        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit',
            'onclick' => "
            if($('.editable-data-table tr.data').length === 1)
            {
                alert('There should be at least one purchase detail.');
                event.preventDefault();
            }
            else if(!confirm('Once the purchase order is submitted, the purchase order cannot be edited or deleted. Are you sure with your purchase order?'))
                event.preventDefault();
            else
            {
                $('.editable-data-table').find('input, select').each(function()
                {
                    $(this).prop('disabled', !$(this).prop('disabled'));
                    if($(this).is('select'))
                        $(this).trigger('chosen:updated');
                });
            }
            "
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>