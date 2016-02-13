<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('New Supplier'), ['action' => 'add']); ?>
    </div>
</div>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <?= $this->Form->create('Search', ['type' => 'GET']) ?>
            <div class="row search-container">
                <div class="col-md-10">
                    <input type="text" name="name" class="form-control" placeholder="Search Supplier's Name"
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
                <h4><i class="fa fa-angle-right"></i> <?= __('Suppliers') ?> </h4>
                <hr>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('contact_number') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($suppliers as $supplier): ?>
                    <tr>
                        <td><?= h($supplier->name) ?></td>
                        <td><?= h($supplier->contact_number) ?></td>
                        <td><?= h($supplier->email) ?></td>
                        <td><?= h($supplier->address) ?></td>
                        <td class="actions">
                            <?= $this->dataTableEditButton(__('Edit'), ['action' => 'edit', $supplier->id]); ?>
                            <?= $this->dataTableDeleteButton(__('Delete'),
                                ['action' => 'delete', $supplier->id],
                                __('Are you sure you want to delete {0}?', $supplier->name)
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
