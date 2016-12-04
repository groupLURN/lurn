
<?= $this->assign('title', 'Create Incident Report') ?>

<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($incidentReportHeader) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i>Create Incident Report</h3></legend>
            <?php
                echo $this->Form->input('project-name', [
                    'class' => 'form-control',
                    'disabled' => true,
                    'label' => [
                        'class' => 'mt'
                    ],
                    'value' => $project->title
                ]);

                echo $this->Form->input('project-location', [
                    'class' => 'form-control',
                    'disabled' => true,
                    'label' => [
                        'text' => 'Project Location',    
                        'class' => 'mt'
                    ],
                    'type' => 'text',
                    'value' => $project->location
                ]);

                echo $this->Form->input('project', [
                    'class' => 'form-control',
                    'disabled' => true,
                    'label' => [
                        'text' => 'Project Engineer',    
                        'class' => 'mt'
                    ],
                    'type' => 'text',
                    'value' => $project->project_engineer->name
                ]);

                echo $this->Form->input('date', [
                    'class' => 'form-control',
                    'disabled' => true,
                    'label' => [
                        'text' => 'Date',    
                        'class' => 'mt'
                    ],
                    'type' => 'text',
                    'value' => $project->date_now
                ]);

                echo $this->Form->input('type', [
                    'class' => 'form-control chosen',
                    'label' => [
                        'class' => 'mt'
                    ],
                    'options' => [''=>'-Select an Incident Type-', 
                                'acc'=>'Accident', 
                                'doc'=>'Dangerous Occurrence', 
                                'inj'=>'Injury', 
                                'los'=>'Loss']
                ]);

            ?>
            
            <legend class="mt"><h4></i>Incident Details</h4></legend>
            <?php                
                echo $this->Form->input('location', [
                    'class' => 'form-control',
                    'label' => [
                        'text' => 'Location',                    
                        'class' => 'mt'
                    ]
                    ]);
                echo $this->Form->input('task', [
                    'class' => 'form-control chosen',
                    'label' => [
                        'class' => 'mt'
                    ],
                    'options' => [''=>'-Select A Task-']+$tasks
                ]);

                echo $this->Form->input('involved-personnel', [
                    'multiple' => true,
                    'data-placeholder' => 'Add Persons Involved',
                    'class' => 'form-control chosen',
                    'label' => [
                        'text' => 'Persons Involved',                    
                        'class' => 'mt'
                    ],
                    'options' => $projectMembers,
                    'data-count' => count($projectMembers)
                    ]);

                echo $this->Form->input('summary', [
                    'class' => 'form-control',
                    'label' => [
                        'class' => 'mt',
                        'text' => 'Summary of the incident and/or injury caused by the incident (parts of the body and severity)'
                    ],
                    'type' => 'textarea'
                ]);
            ?>

            <br>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>