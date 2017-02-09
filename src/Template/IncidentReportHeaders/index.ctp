<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Incident Reports') ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('Create Incident Report'), ['action' => 'add']); ?>
    </div>
</div>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i> <?= __('Incident Reports') ?> </h4>
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('project_id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('project_engineer') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($incidentReportHeaders as $incidentReportHeader): ?>
                    <tr>
                        <td><?= $this->Number->format($incidentReportHeader->id) ?></td>
                        <td><?= $incidentReportHeader->has('project') ? $this->Html->link($incidentReportHeader->project->title, ['controller' => 'Projects', 'action' => 'view', $incidentReportHeader->project->id]) : '' ?></td>
                        <td><?= $this->Number->format($incidentReportHeader->project_engineer) ?></td>
                        <td><?= h($incidentReportHeader->type_full) ?></td>
                        <td><?= h(date_format($incidentReportHeader->date,"F d, Y"))?></td>
                        <td class="actions">
                            <?= $this->dataTableViewButton(__('View'), ['action' => 'view', $incidentReportHeader->id]); ?>
                            <?= $this->dataTableEditButton(__('Edit'), ['action' => 'edit', $incidentReportHeader->id]); ?>
                            <?= $this->dataTableDeleteButton(__('Delete'),
                                ['action' => 'delete', $incidentReportHeader->id],
                                __('Are you sure you want to delete invident report {0}?', $incidentReportHeader->id)
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
        </div>
    </div>
</div>
