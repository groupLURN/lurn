<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Rental Requests') ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('New Rental Request'), ['action' => 'add']); ?>
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
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <input type="checkbox" name="request_date_checked" <?= isset($request_date_checked)? 'checked': ''?>
                               onclick="$('input.datetime-picker:text', $(this).closest('tr')).prop('disabled', !$(this).is(':checked'));">
                        <label>Date Requested</label>
                    </td>
                    <td>
                        <?= $this->Form->input('request_date_from', [
                            'class' => 'datetime-picker form-control',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($request_date_checked),
                            'val' => isset($request_date_from)? $request_date_from: ''
                        ]); ?>
                    </td>
                    <td colspan="2">
                        <?= $this->Form->input('request_date_to', [
                            'class' => 'datetime-picker form-control advance-1-day',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($request_date_checked),
                            'val' => isset($request_date_to)? $request_date_to: ''
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
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <?= $this->Form->label("", "Supplier"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('supplier_id', [
                            'options' => ['0' => 'All'] + $suppliers,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($supplier_id)? $supplier_id: 0
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Rental Requests') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'Rental Request Number') ?></th>
                    <th><?= $this->Paginator->sort('project_id', 'Project') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id', 'Supplier') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Date Requested') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($rentalRequestHeaders as $rentalRequestHeader): ?>
                    <tr>
                        <td><?= h($rentalRequestHeader->number) ?></td>
                        <td><?= $rentalRequestHeader->has('project') ? $this->Html->link($rentalRequestHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $rentalRequestHeader->project->id]) : '' ?></td>
                        <td><?= $rentalRequestHeader->has('supplier') ? $this->Html->link($rentalRequestHeader->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $rentalRequestHeader->supplier->id]) : '' ?></td>
                        <td><?= h($rentalRequestHeader->created) ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $rentalRequestHeader->id]); ?>
                            <?= $this->dataTablePrintButton(__('Print'), ['action' => 'view', $rentalRequestHeader->id, '_ext' => 'pdf']); ?>
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