<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('New Manpower'), ['action' => 'add']); ?>
    </div>
</div>

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
                            <div class="col-md-10">
                                <input type="text" name="name" class="form-control" placeholder="Search Manpower"
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Manpower') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('manpower_type') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($manpower as $manpower_): ?>
                    <tr>
                        <td><?= h($manpower_->manpower_type->title) ?></td>
                        <td><?= h($manpower_->name) ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $manpower_->id]); ?>
                            <?= $this->dataTableEditButton(__('Edit'), ['action' => 'edit', $manpower_->id]); ?>
                            <?= $this->dataTableDeleteButton(__('Delete'),
                                ['action' => 'delete', $manpower_->id],
                                __('Are you sure you want to delete {0}? This will also delete its user account.',
                                    $manpower_->name)
                            );
                            ?>
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
</div><!-- /row -->
<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Manpower'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Manpower Types'), ['controller' => 'ManpowerTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Manpower Type'), ['controller' => 'ManpowerTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="manpower index large-9 medium-8 columns content">
    <h3><?= __('Manpower') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('manpower_type_id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($manpower as $manpower): ?>
            <tr>
                <td><?= $this->Number->format($manpower->id) ?></td>
                <td><?= $manpower->has('manpower_type') ? $this->Html->link($manpower->manpower_type->title, ['controller' => 'ManpowerTypes', 'action' => 'view', $manpower->manpower_type->id]) : '' ?></td>
                <td><?= h($manpower->name) ?></td>
                <td><?= h($manpower->created) ?></td>
                <td><?= h($manpower->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $manpower->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $manpower->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $manpower->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manpower->id)]) ?>
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