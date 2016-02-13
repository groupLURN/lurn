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
            <div class="row search-container">
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
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<div class="row mt">
    <div class="col-md-12">
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