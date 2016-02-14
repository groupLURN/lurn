<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <?= $this->Form->create($equipment) ?>
        <fieldset>
            <legend><h3><i class="fa fa-angle-right"></i> <?= __('Add Equipment') ?></h3></legend>
            <?php

            echo $this->Form->input('name', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
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

<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $equipment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $equipment->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Equipment'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="equipment form large-9 medium-8 columns content">
    <?= $this->Form->create($equipment) ?>
    <fieldset>
        <legend><?= __('Edit Equipment') ?></legend>
        <?php
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
-->