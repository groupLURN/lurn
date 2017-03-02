<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Track Manpower Schedule') ?>
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
                        <input type="checkbox" name="schedule_date_checked" <?= isset($schedule_date_checked)? 'checked': ''?>
                               onclick="$('input.datetime-picker:text', $(this).closest('tr')).prop('disabled', !$(this).is(':checked'));">
                        <label>Schedule Date</label>
                    </td>
                    <td>
                        <?= $this->Form->input('schedule_date_from', [
                            'class' => 'datetime-picker form-control',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($schedule_date_checked),
                            'val' => isset($schedule_date_from)? $schedule_date_from: ''
                        ]); ?>
                    </td>
                    <td colspan="2">
                        <?= $this->Form->input('schedule_date_to', [
                            'class' => 'datetime-picker form-control advance-1-day',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($schedule_date_checked),
                            'val' => isset($schedule_date_to)? $schedule_date_to: ''
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
                    <td style="padding-top: 15px; padding-left: 10px; width: 20%;">
                        <?= $this->Form->label("", "Manpower Type"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('id', [
                            'options' => ['0' => 'All'] + $manpowerTypes,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($id)? $id: 0
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="row mt">
                            <div class="col-md-12">
                                <?= $this->Form->button(__('Search'), [
                                    'id' => 'btn-search',
                                    'class' => 'btn btn-primary pull-right'
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Track Manpower Schedule') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name', 'Manpower') ?></th>
                    <th><?= $this->Paginator->sort('Projects.title', 'Project') ?></th>
                    <th><?= $this->Paginator->sort('Milestones.title', 'Milestone') ?></th>
                    <th><?= $this->Paginator->sort('Tasks.title', 'Task') ?></th>
                    <th><?= $this->Paginator->sort('Tasks.start_date', 'Task Start') ?></th>
                    <th><?= $this->Paginator->sort('Tasks.end_date', 'Task End') ?></th>
                    <th><?= $this->Paginator->sort('ManpowerTypesTasks.quantity', 'Quantity Needed') ?></th>
                    <th><?= $this->Paginator->sort('quantity_available', 'Available Quantity') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($manpower as $manpower_): ?>
                    <tr>
                        <td><?= h($manpower_['title']) ?></td>
                        <td><?= $this->Html->link($manpower_['Projects']['title'], ['controller' => 'Projects', 'action' => 'view', $manpower_['Projects']['id']]) ?></td>
                        <td><?= h($manpower_['Milestones']['title']) ?></td>
                        <td><?= h($manpower_['Tasks']['title']) ?></td>
                        <td><?= h(date_format(new DateTime($manpower_['Tasks']['start_date']), 'F d, Y')) ?></td>
                        <td><?= h(date_format(new DateTime($manpower_['Tasks']['end_date']), 'F d, Y')) ?></td>
                        <td><?= $this->Number->format($manpower_['ManpowerTypesTasks']['quantity']) ?></td>
                        <td><?= $this->Number->format($manpower_['quantity_available']) ?></td>
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