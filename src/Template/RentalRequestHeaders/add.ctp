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
                    $this->Form->input('RentalRequestDetails.equipment_id[]', [
                        'class' => 'chosen form-control',
                        'label' => false,
                        'options' => $equipment,
                        'id' => false
                    ]),
                    $this->Form->input('quantity', [
                        'class' => 'number-only',
                        'label' => false,
                        'id' => false
                    ]),
                    $this->Form->input('duration', [
                        'class' => 'number-only',
                        'label' => false,
                        'id' => false
                    ])
                ]
            ]); ?>
        </fieldset>

        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit',
            'onclick' => "if(!confirm('Once the rental request is submitted, the rental request cannot be edited or deleted. Are you sure with your rental request?')) event.preventDefault();"
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>