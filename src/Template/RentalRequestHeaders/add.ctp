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

            <?= $this->element('order_request_add', [
                'headers' => [
                    'Equipment',
                    'Project Inventory Quantity',
                    'Quantity',
                    'Duration (days)'
                ],
                'hasAdd' => false,
                'id' => 'rental-request-add'
            ]); ?>
        </fieldset>

        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit',
            'onclick' => "
            if($('.editable-data-table tr').length <= 1)
            {
                alert('There should be at least one rental detail.');
                event.preventDefault();
            }
            else if(!confirm('Once the rental request is submitted, the rental request cannot be edited or deleted. Are you sure with your rental request?'))
            {
                event.preventDefault();
            }
            "
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>