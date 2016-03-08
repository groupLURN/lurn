<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Manpower Project Inventory') ?>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <?= $this->Form->create('Search', ['type' => 'GET']) ?>
            <h4><i class="fa fa-angle-right"></i> Filters </h4>
            <?= $this->Form->input('project_id', ['type' => 'hidden', 'value' => $projectId]); ?>
            <hr>
            <table class="table">
                <tbody>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <?= $this->Form->label("", "Milestone"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('milestone_id', [
                            'options' => ['0' => 'All'] + $milestones,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($milestone_id)? $milestone_id: 0
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px; width: 20%;">
                        <?= $this->Form->label("", "Manpower Type"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('manpower_type_id', [
                            'options' => ['0' => 'All'] + $manpowerTypes,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($manpower_type_id)? $manpower_type_id: 0
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="row mt">
                            <div class="col-md-1 col-md-offset-11">
                                <?= $this->Form->button(__('Search'), [
                                    'id' => 'btn-search',
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <?= $this->Form->end(); ?>
        </div><!-- --/content-panel ---->
    </div>
</div>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i> <?= __('Manpower Project Inventory') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ManpowerTypes.title', 'Job Title') ?></th>
                    <th><?= $this->Paginator->sort('available_quantity') ?></th>
                    <th><?= $this->Paginator->sort('unavailable_quantity') ?></th>
                    <th><?= $this->Paginator->sort('total_quantity') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($manpower as $manpower_): ?>
                    <tr>
                        <td><?= h($manpower_->manpower_type->title) ?></td>
                        <td><?= $this->Number->format($manpower_->available_quantity) ?></td>
                        <td><?= $this->Number->format($manpower_->unavailable_quantity) ?></td>
                        <td><?= $this->Number->format($manpower_->total_quantity) ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $manpower_->manpower_type->id, '?' => ['project_id' => $projectId]]); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                </ul>
                <p><?= $this->Paginator->counter() ?></p>
            </div>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div>
<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Manpower Project Inventory'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Manpower'), ['controller' => 'Manpower', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Manpower'), ['controller' => 'Manpower', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="equipmentProjectInventories index large-9 medium-8 columns content">
    <h3><?= __('Manpower Project Inventories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('equipment_id') ?></th>
                <th><?= $this->Paginator->sort('project_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipmentProjectInventories as $equipmentProjectInventory): ?>
            <tr>
                <td><?= $equipmentProjectInventory->has('equipment') ? $this->Html->link($equipmentProjectInventory->equipment->name, ['controller' => 'Manpower', 'action' => 'view', $equipmentProjectInventory->equipment->id]) : '' ?></td>
                <td><?= $equipmentProjectInventory->has('project') ? $this->Html->link($equipmentProjectInventory->project->title, ['controller' => 'Projects', 'action' => 'view', $equipmentProjectInventory->project->id]) : '' ?></td>
                <td><?= $this->Number->format($equipmentProjectInventory->quantity) ?></td>
                <td><?= h($equipmentProjectInventory->created) ?></td>
                <td><?= h($equipmentProjectInventory->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $equipmentProjectInventory->equipment_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $equipmentProjectInventory->equipment_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $equipmentProjectInventory->equipment_id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipmentProjectInventory->equipment_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
-->