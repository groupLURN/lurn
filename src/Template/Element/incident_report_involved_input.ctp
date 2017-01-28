<?php

$defaults = [
    'namespaces' => [], // Namespaces for the fields.
    'values' => [], // Pre-set values.
    'hidden' => false, // Shows/Hides this element,
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

    <legend id="injured-details-header" class="mt"><h4></i>Details of Injured Person/s</h4></legend>

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
        <img src=<?=$this->Url->build(['controller' => '/img/add.png', 'action' => 'index'])?> alt="Add" style="cursor: pointer;" onclick="addManpower(this);">
    </div>
            
    <div id="injured-details">
        <?php

            echo $this->Form->input('name', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [                   
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('age', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [
                    'text' => 'Age/Date of Birth',                    
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('address', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [
                    'text' => 'Address of Injured Person',                    
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('contact-number', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [                
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('Occupation', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [                 
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('involved-summary', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Summary of the injury caused by the incident (parts of the body and severity)'
                ],
                'type' => 'textarea'
            ]);
        ?>


        <ul class="involved-summaries">
        </ul>
    </div>

    <div id="lost-items-details">
        <legend class="mt"><h4></i>Lost Items/Materials</h4></legend>
        <?php                
            echo $this->Form->input('item', [
                'class' => 'form-control',
                'label' => [                   
                    'class' => 'mt'
                ]
            ]);

        ?>
    </div>
</div>

<script>
    function addManpower(object) {
        var $context = $(object).closest("div.multi-select-with-input");
        var $select = $("select.chosen", $context);
        //append description, name, etc to list.
    }
</script>