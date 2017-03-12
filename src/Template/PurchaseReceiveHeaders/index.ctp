<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Purchase Receives') ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('New Purchase Receive'), ['action' => 'add']); ?>
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
                        <input type="checkbox" name="receive_date_checked" <?= isset($receive_date_checked)? 'checked': ''?>
                               onclick="$('input.datetime-picker:text', $(this).closest('tr')).prop('disabled', !$(this).is(':checked'));">
                        <label>Date Received</label>
                    </td>
                    <td>
                        <?= $this->Form->input('receive_date_from', [
                            'class' => 'datetime-picker form-control',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($receive_date_checked),
                            'val' => isset($receive_date_from)? $receive_date_from: ''
                        ]); ?>
                    </td>
                    <td colspan="2">
                        <?= $this->Form->input('receive_date_to', [
                            'class' => 'datetime-picker form-control advance-1-day',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($receive_date_checked),
                            'val' => isset($receive_date_to)? $receive_date_to: ''
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Purchase Receives') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('PurchaseReceiveHeaders.id', 'Purchase Receive Number') ?></th>
                    <th><?= $this->Paginator->sort('PurchaseOrderHeaders.id', 'Purchase Order Number') ?></th>
                    <th><?= $this->Paginator->sort('Projects.title', 'Project') ?></th>
                    <th><?= $this->Paginator->sort('Suppliers.name', 'Supplier') ?></th>
                    <th><?= $this->Paginator->sort('PurchaseOrderHeaders.created', 'Date Ordered') ?></th>
                    <th><?= $this->Paginator->sort('PurchaseReceiveHeaders.created', 'Date Received') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($purchaseReceiveHeaders as $purchaseReceiveHeader): ?>
                    <tr>
                        <td><?= h($purchaseReceiveHeader->id) ?></td>
                        <td><?= $this->Html->link($purchaseReceiveHeader->_matchingData['PurchaseOrderHeaders']['id'], ['controller' => 'PurchaseOrderHeaders', 'action' => 'view', $purchaseReceiveHeader->_matchingData['PurchaseOrderHeaders']['id']])?></td>
                        <td><?= $purchaseReceiveHeader->_matchingData['Projects']['id']? $this->Html->link($purchaseReceiveHeader->_matchingData['Projects']['title'], ['controller' => 'PurchaseReceiveHeaders', 'action' => 'view', $purchaseReceiveHeader->_matchingData['Projects']['id']]): '' ?></td>
                        <td><?= $this->Html->link($purchaseReceiveHeader->_matchingData['Suppliers']['name'], ['controller' => 'PurchaseReceiveHeaders', 'action' => 'view', $this->Html->link($purchaseReceiveHeader->_matchingData['Suppliers']['id'])]) ?></td>
                        <td><?= h(isset($purchaseReceiveHeader->received_date) 
                            ? date_format($purchaseReceiveHeader->received_date, 'F d, Y') : '') ?></td>
                        <td><?= h(isset($purchaseReceiveHeader->created) 
                            ? date_format($purchaseReceiveHeader->created, 'F d, Y') : '') ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $purchaseReceiveHeader->id]); ?>
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