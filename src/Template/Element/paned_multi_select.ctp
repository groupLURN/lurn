<?= $this->Html->script('paned-multi-select', ['block' => 'script-end']); ?>
<?php
$defaults = [
    'data' => [
        [
            'id' => 100,
            'name' => 'Equipment',
            'quantity' => 3
        ],
        [
            'id' => 101,
            'name' => 'Equipment2',
            'quantity' => 2
        ]
    ],
    'id' => 'equipment-paned-multi-select'
];

extract($defaults, EXTR_SKIP);
?>

<ul class="nav nav-pills nav-stacked" id="<?=$id?>">
</ul>