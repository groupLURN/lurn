
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
                    'options' => $projects
                ]);

                echo $this->Form->input('type');

                echo $this->Form->input('project_engineer', [
                    'class' => 'form-control chosen',
                    'label' => [
                        'class' => 'mt'
                    ],
                    'options' => [null => '-Choose a Project-']
                ]);
                echo $this->Form->input('date');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>