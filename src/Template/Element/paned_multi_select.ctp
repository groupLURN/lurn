<?= $this->Html->script('paned-multi-select', ['block' => 'script-end']); ?>
<?php

$defaults = [
    'leftPane' => [
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
    ],
    'isSingularChecker' => true
];

extract($defaults, EXTR_SKIP);
?>

<div class="row mt panel-group">
    <div class="col-xs-6 left-pane">
        <legend><h4><i class="fa fa-angle-right"></i> <?= h($leftPane['title']) ?></h4></legend>
        <ul class="nav nav-pills nav-stacked">
            <?php if ($leftPane['enableInitialization'] === true) : ?>
                <?php $i = 0;
                foreach ($data as $value) : ?>
                    <li <?= $i++ === 0 ? 'class="active"' : '' ?>>
                        <a onclick="javascript:selectCurrentPill(this)" style="cursor: pointer;"
                           id="<?= $rightPane['options']['resource'] . '-' . $value['id'] ?>">
                            <?= $value['quantity'] . 'x ' . $value['name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    <div class="col-xs-6 right-pane">
        <legend><h4><i class="fa fa-angle-right"></i> <?= h($rightPane['title']) ?></h4></legend>
        <?php $i = 0;
        foreach ($data as $value) : ?>
            <?= $this->element('multi_select_with_input', [
                'id' => $rightPane['options']['resource'] . '-' . $value['id'],
                'options' => $value['list'],
                'resource' => $rightPane['options']['resource'],
                'quantity' => $rightPane['options']['quantity'],
                'hidden' => $i++ === 0 ? false : true,
                'checker' => ($isSingularChecker === true)? sprintf("
                (function(object)
                {
                    var \$context = $(object).closest('div.multi-select-with-input');
                    var \$ul = \$context.find('ul.options');

                    return \$ul.find('li').length < %s;
                })(this)", $value['quantity']) : sprintf("
                (function(object)
                {
                    var \$context = $(object).closest('div.multi-select-with-input');
                    var \$select = \$context.find('select');
                    var inputQuantity = Number(\$context.find('.resource-quantity').val());
                    var availableQuantity = Number(\$select.find('optgroup').attr('label').match(/\\d+/g));

                    if(inputQuantity > availableQuantity)
                    {
                        alert('You cannot transfer more than what is available in your inventory.');
                        return false;
                    }
                    else if (inputQuantity > %s)
                    {
                        alert('You cannot transfer more than what is requested.');
                        return false;
                    }
                    else
                        return true;
                })(this)", $value['quantity'])
            ]) ?>
        <?php endforeach; ?>
    </div>
</div>