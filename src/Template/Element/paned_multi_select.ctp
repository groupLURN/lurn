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
    'id' => 'equipment-paned-multi-select',
    'initialize' => true
];

extract($defaults, EXTR_SKIP);
?>

<ul class="nav nav-pills nav-stacked" id="<?=$id?>">
    <?php if($initialize === true) : ?>
        <?php $i = 0; foreach($data as $value) : ?>
            <li <?= $i++ === 0? 'class="active"': '' ?>>
                <a onclick="javascript:selectCurrentPill(this)" style="cursor: pointer;">
                    <?= $value['quantity'] . 'x ' . $value['name'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>