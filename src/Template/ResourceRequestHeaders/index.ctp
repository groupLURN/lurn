<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Resources Requests') ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('New Resources Request'), ['action' => 'add']); ?>
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
                        <?= $this->Form->label("", "Request From"); ?>
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Resources Requests') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'Resources Request Number') ?></th>
                    <th><?= $this->Paginator->sort('from_project_id', 'Request From') ?></th>
                    <th><?= $this->Paginator->sort('to_project_id', 'Request To') ?></th>
                    <th><?= $this->Paginator->sort('required_date', 'Date Needed') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Date Requested') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($resourceRequestHeaders as $resourceRequestHeader): ?>
                    <tr>
                        <td><?= h($resourceRequestHeader->number) ?></td>
                        <td><?= $resourceRequestHeader->has('project_from') ? $this->Html->link($resourceRequestHeader->project_from->title, ['controller' => 'Projects', 'action' => 'view', $resourceRequestHeader->project_from->id]) : 'General' ?></td>
                        <td><?= $resourceRequestHeader->has('project_to') ? $this->Html->link($resourceRequestHeader->project_to->title, ['controller' => 'Projects', 'action' => 'view', $resourceRequestHeader->project_to->id]) : 'General' ?></td>
                        <td><?= h(date_format($resourceRequestHeader->required_date, 'F d, Y')) ?></td>
                        <td><?= h(date_format($resourceRequestHeader->created, 'F d, Y')) ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $resourceRequestHeader->id]); ?>
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