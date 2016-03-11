<?= $this->Html->script('editable-data-table', ['block' => 'script-end']); ?>
<?php

    $defaults = [
        'tableName' => 'Data Table',
        'tableWidth' => '500px',
        'headers' => [
            'Header 1',
            'Header 2',
            'Header 3',
            'Header 4'
        ],
        'columns' => [
            '<input name="input_1" />',
            '<input name="input_2" />',
            '<input name="input_3" />',
            '<input name="input_4" />'
        ]
    ];

    extract($defaults, EXTR_SKIP);
?>
<table class="table table-striped table-advance table-hover editable-data-table" style="width: <?=$tableWidth?>; margin: 0 auto;">
<thead>
<tr class="headers">
    <?php foreach($headers as $header) : ?>
    <th><?= h($header) ?></th>
    <?php endforeach; ?>
</tr>
</thead>
<tbody>
    <tr class="data">
        <?php foreach ($columns as $column): ?>
        <td style="width: <?= 90/count($columns) ?>%"><?= $column ?></td>
        <?php endforeach; ?>
        <td style="width: 10%;">
            <img src="/img/cross_bright.png" class='editable-data-table-delete' alt="Delete" style="cursor: pointer;">
            <img src="/img/add.png" class='editable-data-table-add' alt="Add" style="cursor: pointer;">
        </td>
    </tr>
</tbody>
</table>