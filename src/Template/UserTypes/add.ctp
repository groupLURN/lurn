<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List User Types'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="userTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($userType) ?>
    <fieldset>
        <legend><?= __('Add User Type') ?></legend>
        <?php
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
