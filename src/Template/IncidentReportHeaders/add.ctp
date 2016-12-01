
<?= $this->assign('title', 'Create Incident Report') ?>

<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($incidentReportHeader) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i>Create Incident Report</h3></legend>
            <?php
                echo $this->Form->input('project_id', [
                    'class' => 'form-control chosen',
                    'label' => [
                        'class' => 'mt'
                    ],
                    'options' => [''=>'-Select A Project-']+$projects
                ]);

                echo $this->Form->input('incident_type', [
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
            
            <legend class="mt"><h4><i class="fa fa-angle-right"></i>Incident Details</h4></legend>
            <?php                
                echo $this->Form->input('location', [
                    'class' => 'form-control',
                    'label' => [
                        'text' => 'Location',                    
                        'class' => 'mt'
                    ]
                    ]);
                echo $this->Form->input('task_id', [
                    'class' => 'form-control chosen',
                    'label' => [
                        'class' => 'mt'
                    ],
                    'options' => [''=>'-Select A Task-']+$projects
                ]);

                echo $this->Form->input('injured_personnel.ids', [
                    'multiple' => true,
                    'data-placeholder' => 'Add Persons Involved',
                    'class' => 'form-control chosen',
                    'label' => [
                        'text' => 'Persons Involved',                    
                        'class' => 'mt'
                    ],
                    'options' => $projects
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