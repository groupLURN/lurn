<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Create Rental Receive') ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($rentalReceiveHeader) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Create Rental Receive') ?></h3></legend>
            <?php

            echo $this->Form->input('rental_request_header_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Rental Request Number'
                ],
                'options' => $rentalRequestHeaders,
                'onchange' => sprintf("
                    if(!confirm('Are you sure you want to change rental request number? This will erase the details below.'))
                    {
                        event.preventDefault();
                        return;
                    }
                    \$editableDataTable.clearTable();
                    $.getJSON('%s' + '/' + $(this).val(),
                        function(response)
                        {
                            \$editableDataTable.fillTable(
                                $.map(response.rentalRequestHeader.rental_request_details, function(rental_request_detail)
                                {
                                    return [[
                                        rental_request_detail.equipment.id,
                                        rental_request_detail.quantity,
                                        rental_request_detail.duration,
                                        rental_request_detail.quantity_remaining,
                                        rental_request_detail.quantity_remaining
                                    ]];
                                })
                            );
                        }
                    );
                ", $this->Url->build(['controller' => 'RentalRequestHeaders', 'action' => 'view']))
            ]);

            echo $this->Form->input('receive_date', [
                'type' => 'text',
                'class' => 'form-control datetime-picker',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            ?>

            <legend class="mt"><h3><i class="fa fa-angle-right"></i> <?= __('Rental Details') ?></h3></legend>
            <?= $this->element('editable_data_table', [
                'headers' => [
                    'Equipment',
                    'Quantity Requested',
                    'Duration (days)',
                    'Quantity Remaining',
                    'Quantity Receive',
                ],
                'columns' => [
                    $this->Form->input('rental_request_details.equipment_id[]', [
                        'class' => 'chosen form-control',
                        'label' => false,
                        'options' => ['0' => '-'] + $equipment,
                        'id' => false,
                        'disabled' => true
                    ]),
                    $this->Form->input('rental_request_details.quantity[]', [
                        'class' => 'number-only',
                        'label' => false,
                        'id' => false,
                        'disabled' => true
                    ]),
                    $this->Form->input('rental_request_details.duration[]', [
                        'class' => 'number-only',
                        'label' => false,
                        'id' => false,
                        'disabled' => true
                    ]),
                    $this->Form->input('rental_request_details.quantity_remaining[]', [
                        'class' => 'number-only',
                        'label' => false,
                        'id' => false,
                        'disabled' => true
                    ]),
                    $this->Form->input('rental_request_details.quantity_receive[]', [
                        'class' => 'number-only',
                        'label' => false,
                        'id' => false
                    ])
                ],
                'hasAdd' => false,
                'hasDelete' => false,
                'tableWidth' => '700px'
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
