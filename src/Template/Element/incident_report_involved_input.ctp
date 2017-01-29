<?php

$defaults = [
    'id'        => 'incident-report-involved-input',
    'values'    => ['' => '-Add Persons Involved-'], // Pre-set values.
    'hidden'    => false, // Shows/Hides this element,
];

extract($defaults, EXTR_SKIP);

?>

<div id=<?= $id ?>>

    <legend id="injured-details-header" class="mt"><h4></i>Details of Injured Person/s</h4></legend>

    <div class="" style="width: 90%; display: inline-block;">
        <?= 
        $this->Form->input('persons-involved', [
            'class' => 'chosen form-control',
            'data-count' => 0,
            'label' => [
                        'class' => 'mt'
                    ],
            'options' => isset($options) ? $options : $values
        ]) 
    ?>
    </div>

    <div class="" style=" display: inline-block;">

        <button type="button" onclick="addManpower();">Add Involved Person</button>
    </div>
            
    <div id="injured-details">
        <?php

            echo $this->Form->input('injured-name', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [                   
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('injured-age', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [
                    'text' => 'Age/Date of Birth',                    
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('injured-address', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [
                    'text' => 'Address of Injured Person',                    
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('injured-contact', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [                
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('injured-occupation', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [                 
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('injured-summary', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Summary of the injury caused by the incident (parts of the body and severity)'
                ],
                'name' => null,
                'type' => 'textarea'
            ]);
        ?>

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

    <ul id="incident-list">
    </ul>
</div>

<script type="text/javascript">

    function resetInjuredInput() {        
        $("#injured-name").val("");
        $("#injured-address").val("");
        $("#injured-age").val("");
        $("#injured-contact").val("");
        $("#injured-occupation").val("");
        $("#injured-summary").val("");
    }
    
    function addManpower() {
        var userId      = $("#persons-involved").val();
        var userName    = $("#persons-involved option:selected").text();        
        var userSummary = "";

        var typeVal     = $("#type").val();

        switch(typeVal) {
            case "acc":
            case "doc":
            case "inj":

                userSummary = $("#injured-summary").val();
                

                var itemList = "<li>"
                        + userName
                        + "<input type=\"hidden\" name=\"injured-id\" value="+userId+">"
                        + "<input type=\"hidden\" name=\"injured-summary\" value=\""+userSummary+"\">"
                        + "</li>";

                resetInjuredInput();               

                $("#persons-involved option[value=\""+userId+"\"]").remove();
                $("#persons-involved").trigger("chosen:updated");

                $("#incident-list").append(
                    itemList                  
                    );


            break;
        }

    }

</script>