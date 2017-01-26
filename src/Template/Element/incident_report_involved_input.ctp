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

<div class="incident-report-involved-input" id="<?= $id ?>" <?= $hidden ? 'hidden' : '' ?>>
    <div class="" style="width: 94%; display: inline-block;">
        <?= 
        $this->Form->input('persons-involved', [
            'class' => 'chosen form-control',
            'data-count' => 0,
            'label' => [
                        'class' => 'mt'
                    ],
            'options' => $options
        ]) 
        ?>
    </div>
    <div class="" style=" display: inline-block;">
        <img src=<?=$this->Url->build(['controller' => '/img/add.png', 'action' => 'index'])?> alt="Add" style="cursor: pointer;" onclick="if(<?= $checker ?> === true) add_<?= $resource ?>(this);">
    </div>

    <?php
        echo $this->Form->input('involved-summary', [
            'class' => 'form-control',
            'label' => [
                'class' => 'mt',
                'text' => 'Summary of the incident and/or injury caused by the incident (parts of the body and severity)'
            ],
            'type' => 'textarea'
        ]);
    ?>

    <!--

    <ul class="options">
        <?php foreach ($values as $value) : ?>
            <li onclick="$(this).remove();">
                <input type="hidden" class="id" name="<?= $nameHolder ?>[id][]" value="<?= $value['id'] ?>">
                <?= isset($value['name']) ? $value['name'] : $value['title'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
    -->
</div>

<script>
    function add_<?= $resource ?>(object) {
        var $context = $(object).closest("div.multi-select-with-input");
        var $select = $("select.chosen", $context);
        //append description, name, etc to list.
    }
</script>