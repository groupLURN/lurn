
<?= $this->assign('title', 'Create Incident Report') ?>

<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($incidentReportHeader) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i>Create Incident Report</h3></legend>
            <?php
                echo $this->Form->input('project_id', [
                    'data-placeholder' => 'Select A Project',
                    'class' => 'form-control chosen',
                    'label' => [
                        'class' => 'mt'
                    ],
                    'options' => $projects
                ]);

                echo $this->Form->input('type');

            ?>
            
            <legend class="mt"><h3><i class="fa fa-angle-right"></i>Injured Personnel</h3></legend>

            <?=
            $this->Form->input('injured_personnel.ids', [
                'data-placeholder' => 'Add Project Engineers',
                'options' => null,
                'class' => 'form-control chosen',
                'label' => [
                    'text' => 'Project Engineers',                    
                    'class' => 'mt'
                ]
                ]);
            ?>

            <br>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>