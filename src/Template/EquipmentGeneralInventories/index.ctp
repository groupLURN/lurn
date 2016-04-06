<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Equipment General Inventory') ?>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <?= $this->Form->create('Search', ['type' => 'GET']) ?>
            <h4><i class="fa fa-angle-right"></i> Filters </h4>
            <hr>
            <table class="table">
                <tbody>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <?= $this->Form->label("", "Equipment Type"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('equipment_type', [
                            'options' => ['0' => 'All'] + $equipmentTypes,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($equipment_type)? $equipment_type: 0,
                            'onchange' => sprintf("
                                $('#supplier-id-filter').prop('disabled', Number($(this).val()) !== %d);
                            ", array_flip($equipmentTypes)['Rented'])
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <?= $this->Form->label("", "Supplier"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('supplier_id', [
                            'options' => ['0' => 'All'] + $suppliers,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($supplier_id)? $supplier_id: 0,
                            'id' => 'supplier-id-filter',
                            'disabled' => isset($equipment_type)? $equipment_type != array_flip($equipmentTypes)['Rented']: true
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <?= $this->Form->label("", "Project"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('project_id', [
                            'options' => ['0' => 'All'] + $projects,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($project_id)? $project_id: 0
                        ]); ?>
                    </td>
                </tr>
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Equipment General Inventory') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('available_in_house_quantity') ?></th>
                    <th><?= $this->Paginator->sort('available_rented_quantity') ?></th>
                    <th><?= $this->Paginator->sort('unavailable_in_house_quantity') ?></th>
                    <th><?= $this->Paginator->sort('unavailable_rented_quantity') ?></th>
                    <th><?= $this->Paginator->sort('total_quantity') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($equipment as $equipment_): ?>
                    <tr>
                        <td><?= $this->Html->link($equipment_->name, ['controller' => 'Equipment', 'action' => 'view', $equipment_->id]) ?></td>
                        <td><?= $this->Number->format($equipment_->available_in_house_quantity) ?></td>
                        <td><?= $this->Number->format($equipment_->available_rented_quantity) ?></td>
                        <td><?= $this->Number->format($equipment_->unavailable_in_house_quantity) ?></td>
                        <td><?= $this->Number->format($equipment_->unavailable_rented_quantity) ?></td>
                        <td><?= $this->Number->format($equipment_->total_quantity) ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $equipment_->id]); ?>
                            <?= $this->dataTableEditButton(__('Adjust'), ['action' => 'edit', $equipment_->id]); ?>
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
            <li><?= $this->Html->link(__('New Equipment General Inventory'), ['action' => 'add']) ?></li>
            <li><?= $this->Html->link(__('List Equipment'), ['controller' => 'Equipment', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('New Equipment'), ['controller' => 'Equipment', 'action' => 'add']) ?></li>
        </ul>
    </nav>
    <div class="equipmentGeneralInventories index large-9 medium-8 columns content">
        <h3><?= __('Equipment General Inventories') ?></h3>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('equipment_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipmentGeneralInventories as $equipmentGeneralInventory): ?>
                <tr>
                    <td><?= $this->Number->format($equipmentGeneralInventory->id) ?></td>
                    <td><?= $equipmentGeneralInventory->has('equipment') ? $this->Html->link($equipmentGeneralInventory->equipment->name, ['controller' => 'Equipment', 'action' => 'view', $equipmentGeneralInventory->equipment->id]) : '' ?></td>
                    <td><?= $this->Number->format($equipmentGeneralInventory->quantity) ?></td>
                    <td><?= h($equipmentGeneralInventory->created) ?></td>
                    <td><?= h($equipmentGeneralInventory->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $equipmentGeneralInventory->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $equipmentGeneralInventory->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $equipmentGeneralInventory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipmentGeneralInventory->id)]) ?>
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