<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Project Manpower Inventory Report') ?>
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
                        <?= $this->Form->label("", "Start Date"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('start_date', [
                            'class' => 'datetime-picker form-control',
                            'style' => 'display: initial;',
                            'label' => false,
                            'val' => isset($start_date)? $start_date: '' //$start_date
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <?= $this->Form->label("", "End Date"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('end_date', [
                            'class' => 'datetime-picker form-control',
                            'style' => 'display: initial;',
                            'label' => false,
                            'val' => isset($end_date)? $end_date: '' //$end_date
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="row mt">
                            <div class="col-md-10"></div>
                            <div class="col-md-2">
                                <?= $this->Form->button(__('Generate'), [
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
        <?php 
        $startParam = "";
        if (isset($start_date))
            $startParam = '&start_date=' . $start_date;
        $endParam = "";
        if (isset($end_date))
            $endParam = '&end_date=' . $end_date;
        ?>

        <?= $this->Form->button('<i class="fa fa-save"></i> Save as PDF', 
            array('onclick' => "location.href='" . $this->Url->build('/manpower-project-inventory-report/view/'.$projectId.'/1.pdf?' . $startParam . $endParam). "'", 'class' => 'btn btn-primary')); ?>
        <?= $this->Form->button('<i class="fa fa-print"></i> Print', 
            array('onclick' => "location.href='" . $this->Url->build('/manpower-project-inventory-report/view/'.$projectId.'/0.pdf?'. $startParam . $endParam) . "'", 'class' => 'btn btn-warning')); ?>
    </div>
</div>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel" style="padding:20px">
            <?= $this->Html->image('logo.jpg', array('class' => 'float-right')) ?>
            <h5>
                <?php foreach ($projects as $project): ?>
                <?= $project->title ?><br>
                <?= $project->client_name ?><br>
                <?= $this->fetch('title') ?><br>
                J.I. Espino Construction<br>
                <?= $project->manager_name ?><br>
                <?= $project->location ?>
                <?php endforeach; ?>
            </h5>
            <br><br>
            <h5>* As of <?= $currentDate ?></h5>
            <br>
            <?php if (sizeOf($manpower) > 0): ?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center"><?= __('Job Title') ?></th>
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