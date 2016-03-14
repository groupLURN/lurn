<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Equipment General Inventory') ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($equipment) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Adjust Inventory') ?></h3></legend>
            <?php

            echo $this->Form->input('Equipment.name', [
                'type' => 'text',
                'class' => 'form-control number-only',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Equipment'
                ],
                'disabled' => true
            ]);

            echo $this->Form->input('quantity', [
                'type' => 'text',
                'class' => 'form-control number-only',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Available In-house Quantity'
                ],
                'required' => true
            ]);

            ?>
        </fieldset>

        <?= $this->Form->button(__('Submit'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
        <?= $this->Form->end() ?>

    </div>
</div>