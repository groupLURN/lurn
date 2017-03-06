<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($supplier) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Edit Supplier') ?></h3></legend>
            <?php
            echo $this->Form->input('name', [
                'class' => 'form-control'
            ]);

            echo $this->Form->input('contact_number', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('email', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('address', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ]
            ]);
            
            echo $this->Form->input('equipment', [
                'class' => 'form-control chosen',
                'data-placeholder' => '-Add Equipment-',
                'default' => $supplier->equipment,
                'label' => [
                    'class' => 'mt'
                ],
                'multiple' => true,
                'options' => $equipment
            ]);

            echo $this->Form->input('materials', [
                'class' => 'form-control chosen',
                'data-placeholder' => '-Add Materials-',
                'default' => $supplier->materials,
                'label' => [
                    'class' => 'mt'
                ],
                'multiple' => true,
                'options' => $materials
            ]);
            ?>
        </fieldset>

        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>