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
                'options' => $projects
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
        </fieldset>
        <div class="row mt">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-4">
                        <legend><h4><i class="fa fa-angle-right"></i> <?= __('Assign Equipment Needed') ?></h4></legend>
                        <?= $this->element('multi_select_with_input', [
                            'options' => $equipment,
                            'resource' => 'equipment'
                        ]) ?>
                    </div>
                    <div class="col-xs-4">
                        <legend><h4><i class="fa fa-angle-right"></i> <?= __('Assign Manpower Needed') ?></h4></legend>
                        <?= $this->element('multi_select_with_input', [
                            'options' => $manpowerTypes,
                            'resource' => 'manpower_types'
                        ]) ?>
                    </div>
                    <div class="col-xs-4">
                        <legend><h4><i class="fa fa-angle-right"></i> <?= __('Assign Materials Needed') ?></h4></legend>
                        <?= $this->element('multi_select_with_input', [
                            'options' => $materials,
                            'resource' => 'materials'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
        <?= $this->Form->end() ?>
    </div>
</div>