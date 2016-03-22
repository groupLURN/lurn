<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Resources Transfer') ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('New Resources Transfer'), ['action' => 'add']); ?>
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
                        <input type="checkbox" name="transfer_date_checked" <?= isset($transfer_date_checked)? 'checked': ''?>
                               onclick="$('input.datetime-picker:text', $(this).closest('tr')).prop('disabled', !$(this).is(':checked'));">
                        <label>Date Transferred</label>
                    </td>
                    <td>
                        <?= $this->Form->input('transfer_date_from', [
                            'class' => 'datetime-picker form-control',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($transfer_date_checked),
                            'val' => isset($transfer_date_from)? $transfer_date_from: ''
                        ]); ?>
                    </td>
                    <td colspan="2">
                        <?= $this->Form->input('transfer_date_to', [
                            'class' => 'datetime-picker form-control advance-1-day',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($transfer_date_checked),
                            'val' => isset($transfer_date_to)? $transfer_date_to: ''
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <?= $this->Form->label("", "Transfer To"); ?>
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Resources Transfers') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'Resources Transfer Number') ?></th>
                    <th><?= h('Resources Request Number') ?></th>
                    <th><?= $this->Paginator->sort('from_project_id', 'Transfer From') ?></th>
                    <th><?= $this->Paginator->sort('to_project_id', 'Transfer To') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Date Transferred') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($resourceTransferHeaders as $resourceTransferHeader): ?>
                    <tr>
                        <td><?= h($resourceTransferHeader->number) ?></td>
                        <td><?= h($resourceTransferHeader->resource_request_header->number) ?></td>
                        <td><?= $resourceTransferHeader->has('project_from') ? $this->Html->link($resourceTransferHeader->project_from->title, ['controller' => 'Projects', 'action' => 'view', $resourceTransferHeader->project_from->id]) : 'General' ?></td>
                        <td><?= $resourceTransferHeader->has('project_to') ? $this->Html->link($resourceTransferHeader->project_to->title, ['controller' => 'Projects', 'action' => 'view', $resourceTransferHeader->project_to->id]) : 'General' ?></td>
                        <td><?= h($resourceTransferHeader->created) ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $resourceTransferHeader->id]); ?>
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