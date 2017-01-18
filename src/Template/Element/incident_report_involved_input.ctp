<?php

$defaults = [
    'resource' => 'manpower',
    'namespaces' => [], // Namespaces for the fields.
    'values' => [], // Pre-set values.

    'id' => '', // To be used in paned_multi_select.js
    'hidden' => false, // Shows/Hides this element,
    'checker' => "(function(){ return true; })()"
];

extract($defaults, EXTR_SKIP);

$namespaces[] = $resource;

for ($i = 0; $i < count($namespaces); $i++)
    if ($i === 0)
        $nameHolder = $namespaces[$i];
    else
        $nameHolder .= '[' . $namespaces[$i] . ']';
?>

<div class="content-panel multi-select-with-input" id="<?= $id ?>" <?= $hidden ? 'hidden' : '' ?>>
    <div class="mt parent-center">
        <div class="child-center" style="width: 32%;">
            <?= $this->Form->input('list', [
                'label' => false,
                'type' => 'select',
                'data-placeholder' => 'Select persons involved.',
                'class' => 'chosen resource form-control',
                'options' => $options
            ]) ?>
        </div>
        <div class="child-center">
            <img src=<?=$this->Url->build(['controller' => '/img/add.png', 'action' => 'index'])?> alt="Add" style="cursor: pointer;" onclick="if(<?= $checker ?> === true) add_<?= $resource ?>(this);">
        </div>
    </div>
    <ul class="options">
        <?php foreach ($values as $value) : ?>
            <li onclick="$(this).remove();">
                <input type="hidden" class="id" name="<?= $nameHolder ?>[id][]" value="<?= $value['id'] ?>">
                <?= isset($value['name']) ? $value['name'] : $value['title'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script>
    function add_<?= $resource ?>(object) {
        var $context = $(object).closest("div.multi-select-with-input");
        var $select = $("select.chosen", $context);
        //append description, name, etc to list.
    }
</script>