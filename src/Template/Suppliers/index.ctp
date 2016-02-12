<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-md-12">
        <button type="button" class="btn btn-theme" onclick="$('a', $(this))[0].click();">
            <i class="fa fa-plus"></i>
            <?= $this->Html->link(__('New Supplier'), ['action' => 'add']) ?>
        </button>
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
                            <button class="btn btn-primary btn-xs" onclick="$('a', $(this))[0].click();">
                                <i class="fa fa-pencil"></i>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $supplier->id]) ?>
                            </button>
                            <button class="btn btn-danger btn-xs" onclick="$('a', $(this))[0].click();">
                                <i class="fa fa-trash-o "></i>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $supplier->id], ['confirm' => __('Are you sure you want to delete {0}?', $supplier->name)]) ?>
                            </button>
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
