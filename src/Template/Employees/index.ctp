<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('New Employee'), ['action' => 'add']); ?>
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
                        <input type="checkbox" name="employment_date_checked" <?= isset($employment_date_checked)? 'checked': ''?>
                               onclick="$('input.datetime-picker:text', $(this).closest('tr')).prop('disabled', !$(this).is(':checked'));">
                        <label>Employment Date</label>
                    </td>
                    <td>
                        <?= $this->Form->input('employment_date_from', [
                            'class' => 'datetime-picker form-control',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($employment_date_checked),
                            'val' => isset($employment_date_from)? $employment_date_from: ''
                        ]); ?>
                    </td>
                    <td colspan="2">
                        <?= $this->Form->input('employment_date_to', [
                            'class' => 'datetime-picker form-control advance-1-day',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($employment_date_checked),
                            'val' => isset($employment_date_to)? $employment_date_to: ''
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <input type="checkbox" name="termination_date_checked" <?= isset($termination_date_checked)? 'checked': ''?>
                               onclick="$('input.datetime-picker:text', $(this).closest('tr')).prop('disabled', !$(this).is(':checked'));">
                        <label>Termination Date</label>
                    </td>
                    <td>
                        <?= $this->Form->input('termination_date_from', [
                            'class' => 'datetime-picker form-control',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($termination_date_checked),
                            'val' => isset($termination_date_from)? $termination_date_from: ''
                        ]); ?>
                    </td>
                    <td colspan="2">
                        <?= $this->Form->input('termination_date_to', [
                            'class' => 'datetime-picker form-control advance-1-day',
                            'style' => 'display: initial;',
                            'label' => false,
                            'disabled' => !isset($termination_date_checked),
                            'val' => isset($termination_date_to)? $termination_date_to: ''
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <?= $this->Form->label("", "Employee Type"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('employee_type_id', [
                            'options' => ['0' => 'All'] + $employeeTypes,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($employee_type_id)? $employee_type_id: 0
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="row mt">
                            <div class="col-md-10">
                                <input type="text" name="name" class="form-control" placeholder="Search Employee's Name"
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Employees') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('employee_type_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('employment_date') ?></th>
                    <th><?= $this->Paginator->sort('termination_date') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?= $employee->has('employee_type') ? h($employee->employee_type->title) : '' ?></td>
                        <td><?= h($employee->name) ?></td>
                        <td><?= h($employee->employment_date) ?></td>
                        <td><?= h($employee->termination_date) ?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $employee->id]); ?>
                            <?= $this->dataTableEditButton(__('Edit'), ['action' => 'edit', $employee->id]); ?>
                            <?= $this->dataTableDeleteButton(__('Delete'),
                                ['action' => 'delete', $employee->id],
                                __('Are you sure you want to delete {0}? This will also delete its user account.',
                                    $employee->name)
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