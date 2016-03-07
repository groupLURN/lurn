<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Manpower General Inventory') ?>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <?= $this->Form->create('Search', ['type' => 'GET']) ?>
            <h4><i class="fa fa-angle-right"></i> Filters </h4>
            <hr>
            <table class="table">
                <tbody>
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Manpower General Inventory') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('title', 'Manpower Type') ?></th>
                    <th><?= $this->Paginator->sort('available_quantity', 'Available Pax') ?></th>
                    <th><?= $this->Paginator->sort('unavailable_quantity', 'Unavailable Pax') ?></th>
                    <th><?= $this->Paginator->sort('total_quantity', 'Total Pax') ?></th>
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
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $manpower_->manpower_type->id]); ?>
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
            <li><?= $this->Html->link(__('New Manpower General Inventory'), ['action' => 'add']) ?></li>
            <li><?= $this->Html->link(__('List Manpower'), ['controller' => 'Manpower', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('New Manpower'), ['controller' => 'Manpower', 'action' => 'add']) ?></li>
        </ul>
    </nav>
    <div class="manpowerGeneralInventories index large-9 medium-8 columns content">
        <h3><?= __('Manpower General Inventories') ?></h3>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('manpower_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($manpowerGeneralInventories as $manpowerGeneralInventory): ?>
                <tr>
                    <td><?= $this->Number->format($manpowerGeneralInventory->id) ?></td>
                    <td><?= $manpowerGeneralInventory->has('manpower') ? $this->Html->link($manpowerGeneralInventory->manpower->name, ['controller' => 'Manpower', 'action' => 'view', $manpowerGeneralInventory->manpower->id]) : '' ?></td>
                    <td><?= $this->Number->format($manpowerGeneralInventory->quantity) ?></td>
                    <td><?= h($manpowerGeneralInventory->created) ?></td>
                    <td><?= h($manpowerGeneralInventory->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $manpowerGeneralInventory->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $manpowerGeneralInventory->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $manpowerGeneralInventory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manpowerGeneralInventory->id)]) ?>
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