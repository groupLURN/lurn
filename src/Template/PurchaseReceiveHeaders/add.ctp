<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Create Purchase Receive') ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($purchaseReceiveHeader) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Create Purchase Receive') ?></h3></legend>
            <?php

            echo $this->Form->input('purchase_order_header_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Purchase Order Number'
                ],
                'options' => [null => '-'] + $purchaseOrderHeaders,
                'onchange' => sprintf("
                    if(!confirm('Are you sure you want to change purchase order number? This will erase the details below.'))
                    {
                        event.preventDefault();
                        return;
                    }
                    \$editableDataTable.clearTable();
                    $.getJSON('%s' + '/' + $(this).val(),
                        function(response)
                        {
                            \$editableDataTable.fillTable(
                                $.map(response.purchaseOrderHeader.purchase_order_details, function(purchase_order_detail)
                                {
                                    return [[
                                        purchase_order_detail.id,
                                        purchase_order_detail.material.id,
                                        purchase_order_detail.quantity,
                                        purchase_order_detail.quantity_remaining,
                                        purchase_order_detail.quantity_remaining
                                    ]];
                                })
                            );
                        }
                    );
                ", $this->Url->build(['controller' => 'PurchaseOrderHeaders', 'action' => 'view']))
            ]);

            echo $this->Form->input('received_date', [
                'type' => 'text',
                'class' => 'form-control datetime-picker',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            ?>

            <legend class="mt"><h3><i class="fa fa-angle-right"></i> <?= __('Purchase Details') ?></h3></legend>
            <?= $this->element('editable_data_table', [
                'headers' => [
                    '',
                    'Materials',
                    'Quantity Ordered',
                    'Quantity Remaining',
                    'Quantity Receive',
                ],
                'columns' => [
                    $this->Form->input('purchase_receive_details.purchase_order_detail_id[]', [
                        'class' => 'form-control',
                        'type' => 'hidden',
                        'label' => false,
                        'id' => false
                    ]),
                    $this->Form->input('purchase_receive_details.material_id[]', [
                        'class' => 'chosen form-control',
                        'label' => false,
                        'options' => ['0' => '-'] + $materials,
                        'id' => false,
                        'disabled' => true
                    ]),
                    $this->Form->input('purchase_receive_details.quantity[]', [
                        'class' => 'number-only',
                        'label' => false,
                        'id' => false,
                        'disabled' => true
                    ]),
                    $this->Form->input('purchase_receive_details.quantity_remaining[]', [
                        'class' => 'number-only quantity-remaining',
                        'label' => false,
                        'id' => false,
                        'disabled' => true
                    ]),
                    $this->Form->input('purchase_receive_details.quantity[]', [
                        'class' => 'number-only quantity-receive',
                        'label' => false,
                        'id' => false
                    ])
                ],
                'hasAdd' => false,
                'hasDelete' => false,
                'tableWidth' => '600px'
            ]); ?>
        </fieldset>

        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit',
            'onclick' => "
            var hasReceives = false;
            var hasReceivesExceeded = false;
            $('.editable-data-table tr.data:not(:last)').each(
                function()
                {
                    var quantityReceive = Number($(this).find('.quantity-receive').val());
                    var quantityRemaining = Number($(this).find('.quantity-remaining').val());

                    hasReceives = hasReceives || quantityReceive !== 0 ;
                    hasReceivesExceeded = hasReceivesExceeded || quantityReceive > quantityRemaining;
                }
            );

            if($('.editable-data-table tr.data').length === 1 || !hasReceives)
            {
                alert('There should be at least one purchase receive.');
                event.preventDefault();
            }
            else if(hasReceivesExceeded)
            {
                alert('You cannot receive more than what you was ordered.');
                event.preventDefault();
            }
            else if(!confirm('Once the purchase receive is submitted, the purchase receive cannot be edited or deleted. Are you sure with your purchase receive?'))
                event.preventDefault();
            else
            {
                $('.editable-data-table tr:last').find('input, select').prop('disabled', true);
                $('.duration', '.editable-data-table tr.data:not(:last)').prop('disabled', false);
            }
            "
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>
