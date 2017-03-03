<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($project, ['type' => 'file']) ?>
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
            <h4>Core Team Assignment</h4>

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
            <h4 class="mt">Uploaded Files</h4>
            <div id="files-existing" >
                <?php 
                    if (count($project->projects_files) > 0) {
                        foreach ($project->projects_files as $file){
                ?>                     
                    
                        <div class="file-block">
                            <div class="row">
                                <div class="col-sm-10">
                                    <input type="hidden" name="uploaded-file[]"
                                        value="<?= h($file->id)?>"/>
                       
                                    <?= h($file->file_name.'.'.$file->file_type)?>                      
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="remove-file btn btn-default pull-right">
                                    Remove File
                                    </button>
                                </div>
                            </div>
                        </div>
                <?php 
                        }
                    } else { 
                ?>
                    None.
                <?php 
                    } 
                ?>
            </div>
            <h4 class="mt">Upload New Files</h4>
            <div id="files-added" >
                None.                
            </div>
            <button id="add-file" class="mt btn btn-default" type="button">Add File</button>
        </fieldset>

        <?= $this->Form->button(__('Update'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>