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
                        <td><?= h($incidentReportHeader->type) ?></td>
                        <td><?= h($incidentReportHeader->date) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $incidentReportHeader->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $incidentReportHeader->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $incidentReportHeader->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incidentReportHeader->id)]) ?>
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
