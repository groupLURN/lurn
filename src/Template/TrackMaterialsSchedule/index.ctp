<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Track Materials Schedule') ?>
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
                    <td colspan="4">
                        <div class="row mt">
                            <div class="col-md-10">
                                <input type="text" name="name" class="form-control" placeholder="Search Materials"
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Track Materials Schedule') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name', 'Materials') ?></th>
                    <th><?= $this->Paginator->sort('unit_measure', 'Unit Measure') ?></th>
                    <th><?= $this->Paginator->sort('Projects.title', 'Project') ?></th>
                    <th><?= $this->Paginator->sort('Milestones.title', 'Milestone') ?></th>
                    <th><?= $this->Paginator->sort('Tasks.title', 'Task') ?></th>
                    <th><?= $this->Paginator->sort('Tasks.start_date', 'Task Start') ?></th>
                    <th><?= $this->Paginator->sort('Tasks.end_date', 'Task End') ?></th>
                    <th><?= $this->Paginator->sort('MaterialsTasks.quantity', 'Quantity Needed') ?></th>
                    <th><?= $this->Paginator->sort('quantity_available', 'Available Quantity') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($materials as $material): ?>
                    <tr>
                        <td><?= h($material['name']) ?></td>
                        <td><?= h($material['unit_measure']) ?></td>
                        <td><?= $this->Html->link($material['Projects']['title'], ['controller' => 'Projects', 'action' => 'view', $material['Projects']['id']]) ?></td>
                        <td><?= h($material['Milestones']['title']) ?></td>
                        <td><?= h($material['Tasks']['title']) ?></td>
                        <td><?= h($material['Tasks']['start_date']) ?></td>
                        <td><?= h($material['Tasks']['end_date']) ?></td>
                        <td><?= $this->Number->format($material['MaterialsTasks']['quantity']) ?></td>
                        <td><?= $this->Number->format($material['quantity_available']) ?></td>
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