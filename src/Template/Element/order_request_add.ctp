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
    <tr class="headers">
        <?php foreach($headers as $header) : ?>
        <th><?= h($header) ?></th>
        <?php endforeach; ?>
    </tr>
    </table>
</div>