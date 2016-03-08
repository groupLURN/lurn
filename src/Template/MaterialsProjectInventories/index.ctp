<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Materials Project Inventory') ?>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <?= $this->Form->create('Search', ['type' => 'GET']) ?>
            <h4><i class="fa fa-angle-right"></i> Filters </h4>
            <?= $this->Form->input('project_id', ['type' => 'hidden', 'value' => $project_id]); ?>
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
                    <td colspan="4">
                        <div class="row mt">
                            <div class="col-md-10">
                                <input type="text" name="name" class="form-control" placeholder="Search Materials"
                                       id="txt-search" <?= isset($name)? "value='" . $name . "'": ""; ?> >
                            </div>
                            <div class="col-md-2">
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Materials Project Inventory') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('unit_measure') ?></th>
                    <th><?= $this->Paginator->sort('available_quantity') ?></th>
                    <th><?= $this->Paginator->sort('unavailable_quantity') ?></th>
                    <th><?= $this->Paginator->sort('total_quantity') ?></th>
                    <th><?= $this->Paginator->sort('last_modified', 'Last Modified') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($materials as $material): ?>
                    <tr>
                        <td><?= $this->Html->link($material->name, ['controller' => 'Equipment', 'action' => 'view', $material->id]) ?></td>
                        <td><?= h($material->unit_measure) ?></td>
                        <td><?= $this->Number->format($material->available_quantity) ?></td>
                        <td><?= $this->Number->format($material->unavailable_quantity) ?></td>
                        <td><?= $this->Number->format($material->total_quantity) ?></td>
                        <td><?= h($material->last_modified) ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $material->id, '?' => ['project_id' => $projectId]]); ?>
                            <?= $this->dataTableEditButton(__('Adjust'), ['action' => 'edit', $material->id, '?' => ['project_id' => $projectId]]); ?>
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
        <li><?= $this->Html->link(__('New Materials Project Inventory'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materials'), ['controller' => 'Materials', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Material'), ['controller' => 'Materials', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="materialsProjectInventories index large-9 medium-8 columns content">
    <h3><?= __('Materials Project Inventories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('material_id') ?></th>
                <th><?= $this->Paginator->sort('project_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materialsProjectInventories as $materialsProjectInventory): ?>
            <tr>
                <td><?= $materialsProjectInventory->has('material') ? $this->Html->link($materialsProjectInventory->material->name, ['controller' => 'Materials', 'action' => 'view', $materialsProjectInventory->material->id]) : '' ?></td>
                <td><?= $materialsProjectInventory->has('project') ? $this->Html->link($materialsProjectInventory->project->title, ['controller' => 'Projects', 'action' => 'view', $materialsProjectInventory->project->id]) : '' ?></td>
                <td><?= $this->Number->format($materialsProjectInventory->quantity) ?></td>
                <td><?= h($materialsProjectInventory->created) ?></td>
                <td><?= h($materialsProjectInventory->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $materialsProjectInventory->material_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $materialsProjectInventory->material_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $materialsProjectInventory->material_id], ['confirm' => __('Are you sure you want to delete # {0}?', $materialsProjectInventory->material_id)]) ?>
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