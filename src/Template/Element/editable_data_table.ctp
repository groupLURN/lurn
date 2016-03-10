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
<table class="table table-striped table-advance table-hover" style="width: <?=$tableWidth?>; margin: 0 auto;">
<thead>
<tr>
    <?php foreach($headers as $header) : ?>
    <th><?= h($header) ?></th>
    <?php endforeach; ?>
</tr>
</thead>
<tbody>
    <tr>
        <?php foreach ($columns as $column): ?>
        <td class="data" style="width: <?= 90/count($columns) ?>%"><?= $column ?></td>
        <?php endforeach; ?>
        <td style="width: 10%;">
            <img src="/img/cross_bright.png" class='editable-data-table-delete' alt="Delete" style="cursor: pointer;" onclick="if(confirm('Are you sure you want to delete this entry?')) $(this).closest('tr').remove();">
            <img src="/img/add.png" class='editable-data-table-add' alt="Add" style="cursor: pointer;" onclick="
                var $clone = $(this).closest('tr').clone(true);
                var rowIndex = $(this).closest('tr').index();

                $clone.find('select.chosen').each(function()
                {
                    var $td = $(this).closest('td');
                    $td.html($(this));
                    $(this).chosen({width: '100%'});
                });
                $clone.find('input').val('');
                $(this).closest('tr').after($clone);">
        </td>
    </tr>
</tbody>
</table>