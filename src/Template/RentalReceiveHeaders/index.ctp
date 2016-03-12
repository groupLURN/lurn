<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Rental Receives') ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('New Rental Receive'), ['action' => 'add']); ?>
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Rental Receives') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('RentalReceiveHeaders.id', 'Rental Receive Number') ?></th>
                    <th><?= $this->Paginator->sort('RentalRequestHeaders.id', 'Rental Request Number') ?></th>
                    <th><?= $this->Paginator->sort('Projects.title', 'Project') ?></th>
                    <th><?= $this->Paginator->sort('Suppliers.name', 'Supplier') ?></th>
                    <th><?= $this->Paginator->sort('RentalRequestHeaders.created', 'Date Requested') ?></th>
                    <th><?= $this->Paginator->sort('RentalReceiveHeaders.created', 'Date Received') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($rentalReceiveHeaders as $rentalReceiveHeader): ?>
                    <tr>
                        <td><?= h($rentalReceiveHeader->id) ?></td>
                        <td><?= $this->Html->link($rentalReceiveHeader->_matchingData['RentalRequestHeaders']['id'], ['controller' => 'RentalRequestHeaders', 'action' => 'view', $rentalReceiveHeader->_matchingData['RentalRequestHeaders']['id']])?></td>
                        <td><?= $rentalReceiveHeader->_matchingData['Projects']['id']? $this->Html->link($rentalReceiveHeader->_matchingData['Projects']['title'], ['controller' => 'RentalReceiveHeaders', 'action' => 'view', $rentalReceiveHeader->_matchingData['Projects']['id']]): '' ?></td>
                        <td><?= $this->Html->link($rentalReceiveHeader->_matchingData['Suppliers']['name'], ['controller' => 'RentalReceiveHeaders', 'action' => 'view', $this->Html->link($rentalReceiveHeader->_matchingData['Suppliers']['id'])]) ?></td>
                        <td><?= h($rentalReceiveHeader->receive_date) ?></td>
                        <td><?= h($rentalReceiveHeader->created) ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $rentalReceiveHeader->id]); ?>
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