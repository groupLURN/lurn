<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Create Rental Request') ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($rentalRequestHeader) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Create Rental Request') ?></h3></legend>
            <?php

            echo $this->Form->input('project_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'class' => 'mt'
                ],
                'options' => $projects
            ]);

            echo $this->Form->input('supplier_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'class' => 'mt'
                ],
                'options' => $suppliers
            ]);

            ?>

            <legend class="mt"><h3><i class="fa fa-angle-right"></i> <?= __('Rental Details') ?></h3></legend>
            <?= $this->element('editable_data_table', [
                'headers' => [
                    'Equipment',
                    'Quantity',
                    'Duration (days)'
                ],
                'columns' => [
                    $this->Form->input('rental_request_details.equipment_id[]', [
                        'class' => 'chosen form-control',
                        'label' => false,
                        'options' => ['0' => '-'] + $equipment,
                        'id' => false
                    ]),
                    $this->Form->input('rental_request_details.quantity[]', [
                        'class' => 'number-only',
                        'label' => false,
                        'id' => false
                    ]),
                    $this->Form->input('rental_request_details.duration[]', [
                        'class' => 'number-only',
                        'label' => false,
                        'id' => false
                    ])
                ]
            ]); ?>
        </fieldset>

        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit',
            'onclick' => "
            if($('.editable-data-table tr.data').length === 1)
            {
                alert('There should be at least one rental detail.');
                event.preventDefault();
            }
            else if(!confirm('Once the rental request is submitted, the rental request cannot be edited or deleted. Are you sure with your rental request?'))
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