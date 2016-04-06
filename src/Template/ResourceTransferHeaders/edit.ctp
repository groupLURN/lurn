<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $resourceTransferHeader->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $resourceTransferHeader->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Resource Transfer Headers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Resource Request Headers'), ['controller' => 'ResourceRequestHeaders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Resource Request Header'), ['controller' => 'ResourceRequestHeaders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Equipment Transfer Details'), ['controller' => 'EquipmentTransferDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Equipment Transfer Detail'), ['controller' => 'EquipmentTransferDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Manpower Transfer Details'), ['controller' => 'ManpowerTransferDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Manpower Transfer Detail'), ['controller' => 'ManpowerTransferDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Material Transfer Details'), ['controller' => 'MaterialTransferDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Material Transfer Detail'), ['controller' => 'MaterialTransferDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="resourceTransferHeaders form large-9 medium-8 columns content">
    <?= $this->Form->create($resourceTransferHeader) ?>
    <fieldset>
        <legend><?= __('Edit Resource Transfer Header') ?></legend>
        <?php
            echo $this->Form->input('resource_request_header_id', ['options' => $resourceRequestHeaders]);
            echo $this->Form->input('from_project_id');
            echo $this->Form->input('to_project_id', ['options' => $projects, 'empty' => true]);
            echo $this->Form->input('received_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
