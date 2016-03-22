<?= $this->Html->script('paned-multi-select', ['block' => 'script-end']); ?>
<?php
$defaults = [
    'leftPane' => [
        'id' => 'equipment-paned-multi-select',
        'title' => 'Equipment Requested',
        'enableInitialization' => true
    ],
    'rightPane' => [
        'title' => 'Transfer Equipment',
        'options' => [
            'quantity' => false,
            'resource' => 'equipment'
        ]
    ],
    'data' => [
        [
            'id' => 100,
            'name' => 'Equipment',
            'quantity' => 3,
            'list' => [
                '10000' => '10 - Equipment'
            ]
        ],
        [
            'id' => 101,
            'name' => 'Equipment2',
            'quantity' => 2
        ]
    ]
];

extract($defaults, EXTR_SKIP);
?>

<div class="row mt">
    <div class="col-xs-6">
        <legend><h4><i class="fa fa-angle-right"></i> <?= h($leftPane['title']) ?></h4></legend>
        <ul class="nav nav-pills nav-stacked" id="<?= $leftPane['id'] ?>">
            <?php if ($leftPane['enableInitialization'] === true) : ?>
                <?php $i = 0;
                foreach ($data as $value) : ?>
                    <li <?= $i++ === 0 ? 'class="active"' : '' ?>>
                        <a onclick="javascript:selectCurrentPill(this)" style="cursor: pointer;">
                            <?= $value['quantity'] . 'x ' . $value['name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    <div class="col-xs-6">
        <legend><h4><i class="fa fa-angle-right"></i> <?= h($rightPane['title']) ?></h4></legend>
        <?php foreach ($data as $value) : ?>
        <?= $this->element('multi_select_with_input', [
            'options' => $value['list'],
            'resource' => $rightPane['options']['resource'],
            'quantity' => $rightPane['options']['quantity'],
        ]) ?>
        <?php endforeach; ?>
    </div>
</div>