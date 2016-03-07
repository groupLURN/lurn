<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Equipment Project Inventory') ?>
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
                    <td colspan="4">
                        <div class="row mt">
                            <div class="col-md-10">
                                <input type="text" name="name" class="form-control" placeholder="Search Equipment"
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Equipment Project Inventory') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('available_quantity') ?></th>
                    <th><?= $this->Paginator->sort('unavailable_quantity') ?></th>
                    <th><?= $this->Paginator->sort('total_quantity') ?></th>
                    <th><?= $this->Paginator->sort('last_modified', 'Last Modified') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($equipmentInventories as $equipmentInventory): ?>
                    <tr>
                        <td><?= $this->Html->link($equipmentInventory->equipment->name, ['controller' => 'Equipment', 'action' => 'view', $equipmentInventory->id]) ?></td>
                        <td><?= $this->Number->format($equipmentInventory->available_quantity) ?></td>
                        <td><?= $this->Number->format($equipmentInventory->unavailable_quantity) ?></td>
                        <td><?= $this->Number->format($equipmentInventory->total_quantity) ?></td>
                        <td><?= h($equipmentInventory->last_modified) ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $equipmentInventory->equipment->id, '?' => ['project_id' => $projectId]]); ?>
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
        <li><?= $this->Html->link(__('New Equipment Project Inventory'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Equipment'), ['controller' => 'Equipment', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Equipment'), ['controller' => 'Equipment', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="equipmentProjectInventories index large-9 medium-8 columns content">
    <h3><?= __('Equipment Project Inventories') ?></h3>
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
                <td><?= $equipmentProjectInventory->has('equipment') ? $this->Html->link($equipmentProjectInventory->equipment->name, ['controller' => 'Equipment', 'action' => 'view', $equipmentProjectInventory->equipment->id]) : '' ?></td>
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