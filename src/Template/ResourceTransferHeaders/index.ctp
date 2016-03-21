<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Resources Transfer') ?>
<div class="row mt">
    <div class="col-xs-12">
        <?= $this->newButton(__('New Resources Transfer'), ['action' => 'add']); ?>
    </div>
</div>