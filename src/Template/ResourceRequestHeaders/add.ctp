<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Create Resources Request') ?>

<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($resourceRequestHeader) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Create Resources Request') ?></h3></legend>
            <?php

            echo $this->Form->input('from_project_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'text' => 'Request From',
                    'class' => 'mt'
                ],
                'options' => [null => '-Choose a Project-']+$projects
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

            echo $this->Form->input('to_project_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'text' => 'Request To',
                    'class' => 'mt'
                ],
                'options' => [null => 'General']
            ]);

            echo $this->Form->input('required_date',[
                'type' => 'text',
                'class' => 'form-control datetime-picker',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            ?>
        <div class="row mt">
            <div class="col-xs-12">
                <h4><?= __('Assign Equipment Needed') ?></h4>
                <?= $this->element('order_request_add', [
                        'headers' => [
                            'Equipment',
                            'Project Inventory Quantity',
                            'Quantity'
                        ],
                        'hasAdd' => false,
                        'id' => 'equipment'
                    ]); 
                ?>
            </div>
        </div>
        <div class="row mt">
            <div class="col-xs-12">
                <h4><?= __('Assign Manpower Needed') ?></h4>
                <?= $this->element('multi_select_with_input', [
                    'options' => [null => '-Add Manpower-'],
                    'resource' => 'manpower_types'
                ]) ?>
            </div>
        </div>
        <div class="row mt">
            <div class="col-xs-12">
                <h4><?= __('Assign Materials Needed') ?></h4>
                <?= $this->element('order_request_add', [
                    'tableWidth' => '50%',
                    'headers' => [
                        'Materials',
                        'Project Inventory Quantity',
                        'Quantity'
                    ],
                    'hasAdd' => false,
                    'id' => 'materials'
                ]); ?>
            </div>
        </div>
        </fieldset>
        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit',
            'onclick' => "
            if(!confirm('Once the resources request is submitted, the resources request cannot be edited or deleted. Are you sure with your resources request?'))
                event.preventDefault();
            "
        ]) ?>
        <?= $this->Form->end() ?>
    </div>
</div>