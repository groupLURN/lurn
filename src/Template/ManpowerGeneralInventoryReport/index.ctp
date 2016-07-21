<?= $this->Flash->render() ?>
<?= $this->assign('title', 'General Manpower Inventory Report') ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->dataTableViewButton(__('Save as PDF'), ['action' => 'view', 1, '_ext' => 'pdf']); ?>
        <?= $this->dataTablePrintButton(__('Print'), ['action' => 'view', '_ext' => 'pdf']); ?>
    </div>
</div>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel" style="padding:20px">
            <?= $this->Html->image('logo.jpg', array('class' => 'float-right')) ?>
            <h5>
                <?= $this->fetch('title') ?><br>
                J.I. Espino Construction
            </h5>
            <br><br>
            <h5>* As of <?= $currentDate ?></h5>
            <br>
            <?php if (sizeOf($manpower) > 0): ?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center"><?= __('Manpower Type') ?></th>
                    <th class="text-center"><?= __('Available') ?></th>
                    <th class="text-center"><?= __('Unavailable')?></th>
                    <th class="text-center"><?= __('Total') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($manpower as $manpower_): ?>
                    <tr>
                        <td class="text-left"><?= h($manpower_->manpower_type->title) ?></td>
                        <td class="text-center"><?= $this->Number->format($manpower_->available_quantity) ?></td>
                        <td class="text-center"><?= $this->Number->format($manpower_->unavailable_quantity) ?></td>
                        <td class="text-center"><?= $this->Number->format($manpower_->total_quantity) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No data available.</p>
            <?php endif; ?>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div>