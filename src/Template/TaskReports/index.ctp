<?= $this->Flash->render() ?>
<?= $this->assign('title', 'General Task Accomplishment Report') ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('Generate Reports'), ['action' => 'view']); ?>
    </div>
</div>