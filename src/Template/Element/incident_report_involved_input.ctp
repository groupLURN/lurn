<?php

$defaults = [
    'id'        => 'incident-report-involved-input',
    'personsDefault'    => ['' => '-Add Persons Involved-'], 
    'itemsDefault'    => ['' => '-Add Items Lost-'], // Pre-set values.
    'hidden'    => false, // Shows/Hides this element,
];

extract($defaults, EXTR_SKIP);

?>

<div id=<?= $id ?>>

    <h4 id="injured-details-header" class="mt"></i>Details of Injured Person/s</h4>

        <?= 
        $this->Form->input('person-list', [
            'class' => 'chosen form-control',
            'data-count' => 0,
            'label' => [
                        'class' => 'mt',
                        'text' => 'Add Persons involved'
                    ],
            'name' => false,
            'options' => isset($personsInvolved) ? $personsInvolved : $personsDefault
        ]) 
    ?>

            
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

    <div>
        <button type="button" class="mt" onclick="addInvolved();">Add Person</button>
    </div>

    <label class="mt">Persons Involved</label>
    <ol id="persons-involved">
        None.
    </ol>

    <div id="items-lost-details">
        <h4></i>Lost Items/Materials</h4>

        <?php                
            echo $this->Form->input('item-list', [
                'class' => 'chosen form-control',
                'label' => [                   
                    'class' => 'mt',
                    'text' => 'Add Lost Items'
                ],
                'name' => false,
                'options' => $itemsDefault
            ]);

        ?>

        <div>
            <button type="button" class="mt" onclick="addItem();">Add Item</button>
        </div>

        <label class="mt">Lost Items</label>
        <ol id="items-lost">
            None.
        </ol>               
    </div>
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
    
    function addInvolved() {
        var userId      = $("#person-list").val();
        var userName    = $("#person-list option:selected").text();        
        var userSummary = "";

        if(userId > 0) {
            var typeVal     = $("#type").val();

            var index       = $("#persons-involved li:last").index() + 1;

            var involved    = "<li>"
                    + userName
                    + "<input type=\"hidden\" name=\"involved-id[" + index + "]\" value=" + userId + ">";

            switch(typeVal) {
                case "acc":
                case "doc":
                case "inj":

                    userSummary = $("#injured-summary").val();
                         
                    involved     = involved + "<input type=\"hidden\" name=\"injured-summary[" + index + "]\" value=\""+userSummary+"\">"

                    resetInjuredInput();         
                break;
            }

            involved = involved + "</li>";

            if(index == 0) {
                $("#persons-involved").empty();
            }

            $("#person-list option[value=\"" + userId + "\"]").remove();

            $("#person-list").trigger("chosen:updated");

            $("#persons-involved").append(
                involved                  
            );
        }

    }

    function addItem() {
            var typeVal     = $("#type").val();

            switch(typeVal) {
                case "los":

                var itemId      = $("#item-list").val();
                var itemName    = $("#item-list option:selected").text();

                if(itemId != "") {

                    var index       = $("#items-lost li:last").index() + 1;

                    var item    = "<li>"
                    + itemName
                    + "<input type=\"hidden\" name=\"item-id[" + index + "]\" value=" + itemId + ">"
                    + "</li>";

                    if(index == 0) {
                        $("#items-lost").empty();
                    }

                    $("#item-list option[value=\"" + itemId + "\"]").remove();

                    $("#item-list").trigger("chosen:updated");

                    $("#items-lost").append(
                        item                  
                    );


                }
                break;
            }

        }

</script>