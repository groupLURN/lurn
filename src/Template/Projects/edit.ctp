<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($project) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i>Edit Project</h3></legend>
            <?php

            echo $this->Form->input('title', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);
            echo $this->Form->input('description', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('location', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('client_id', [
                'options' => $clients,
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('project_manager_id', [
                'options' => $projectManagers,
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('start_date', [
                'type' => 'text',
                'class' => 'form-control datetime-picker',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('end_date', [
                'type' => 'text',
                'class' => 'form-control datetime-picker',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            ?>
            <h3>Core Team Assignment</h3>

            <?php
                echo $this->Form->input('project-engineer', [
                    'class' => 'form-control',
                    'default' => $projectEngineer,
                    'label' => [
                        'text' => 'Project Engineers'
                    ],
                    'options' => [''=>'-Add a Project Engineer-']+$projectEngineers
                ]);

                echo $this->Form->input('warehouse-keeper', [
                    'class' => 'form-control',
                    'default' => $warehouseKeeper,
                    'label' => [
                        'class' => 'mt',
                        'text' => 'Warehouse Keepers'
                    ],
                    'options' => [''=>'-Add a Warehouse Keeper-']+$warehouseKeepers
                ]);
            ?>
        </fieldset>

        <?= $this->Form->button(__('Update'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>