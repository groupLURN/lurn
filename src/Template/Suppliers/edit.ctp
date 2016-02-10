<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($supplier) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Edit Supplier') ?></h3></legend>
            <?php
            echo $this->Form->input('name', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'col-sm-2 control-label'
                ]
            ]);
            echo $this->Form->input('contact_number', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'col-sm-2 control-label'
                ]
            ]);
            echo $this->Form->input('email', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'col-sm-2 control-label'
                ]
            ]);
            echo $this->Form->input('address', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'col-sm-2 control-label'
                ]
            ]);
            ?>
        </fieldset>

        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>