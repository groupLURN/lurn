<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Create Purchase Order') ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($purchaseOrderHeader) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Create Purchase Order') ?></h3></legend>
            <?php

            echo $this->Form->input('project_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'class' => 'mt'
                ],
                'options' => [null => '-'] + $projects
            ]);

            echo $this->Form->input('supplier_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'class' => 'mt'
                ],
                'options' => $suppliers
            ]);

            ?>

            <legend class="mt"><h3><i class="fa fa-angle-right"></i> <?= __('Purchase Order') ?></h3></legend>
            <?= $this->element('editable_data_table', [
                'tableWidth' => '350px',
                'headers' => [
                    'Materials',
                    'Quantity',
                ],
                'columns' => [
                    $this->Form->input('purchase_order_details.material_id[]', [
                        'class' => 'chosen form-control',
                        'label' => false,
                        'options' => ['0' => '-'] + $materials,
                        'id' => false
                    ]),
                    $this->Form->input('purchase_order_details.quantity[]', [
                        'class' => 'number-only',
                        'label' => false,
                        'id' => false
                    ]),
                ]
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