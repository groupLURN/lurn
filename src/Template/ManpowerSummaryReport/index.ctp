<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Manpower Summary Report') ?>
<div class="row mt">
    <div class="col-xs-12">

        <?= $this->Form->button('<i class="fa fa-save"></i> Save as PDF', 
            array('onclick' => "location.href='" . $this->Url->build('/manpower-summary-report/view/1.pdf')."'", 'class' => 'btn btn-primary')); ?>
        <?= $this->Form->button('<i class="fa fa-print"></i> Print', 
            array('onclick' => "location.href='" . $this->Url->build('/manpower-summary-report/view/0.pdf')."'", 'class' => 'btn btn-warning')); ?>
    </div>
</div>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel" style="padding:20px">
          
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div>