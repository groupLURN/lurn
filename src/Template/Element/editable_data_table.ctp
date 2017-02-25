<?= $this->Html->script('editable-data-table', ['block' => 'script-end']); ?>
<?php

    $defaults = [
        'tableName' => 'Data Table',
        'tableWidth' => '500px',
        'headers' => [
        ],
        'columns' => [
        ],
        'hasAdd' => true,
        'hasDelete' => true,
        'id' => ''
    ];

    extract($defaults, EXTR_SKIP);
?>
<div class="mt">
    <table id="<?= $id?>" class="table table-striped table-advance table-hover editable-data-table" style="width: <?=$tableWidth?>;">
    <thead>
    <tr class="headers">
        <?php foreach($headers as $header) : ?>
        <th><?= h($header) ?></th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
        <tr class="data" <?php if(!$hasAdd) echo 'style="display:none;"' ?>>
            <?php foreach ($columns as $column): ?>
            <td style="width: <?= 90/count($columns) ?>%"><?= $column ?></td>
            <?php endforeach; ?>
            <td style="width: 10%;" class="editable-data-table-action">
                <img src="/img/cross_bright.png" class='editable-data-table-delete' alt="Delete" style="cursor: pointer; <?php if(!$hasDelete) echo 'display:none;' ?>">
                <img src="/img/add.png" class='editable-data-table-add' alt="Add" style="cursor: pointer; <?php if(!$hasAdd) echo 'display:none;' ?>">
            </td>
        </tr>
    </tbody>
    </table>
</div>