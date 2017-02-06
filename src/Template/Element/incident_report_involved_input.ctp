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

            echo $this->Form->input('item-quantity', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ],
                'name' => false
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

    function resetItemsInput() {        
        $("#item-quantity").val("");
    }
    
    function addInvolved() {
        var $context        = $("#person-list option:selected");
        var userId          = $("#person-list").val();
        var userName        = $($context).text();
        var userAddress     = $($context).data("address");
        var userAge         = $($context).data("age");
        var userContact     = $($context).data("contact");
        var userOccupation  = $($context).data("occupation");  
        var userSummary = "";

        if(userId != "") {
            var typeVal     = $("#type").val();

            if(typeVal == "") {
                alert("Please select an incident type first.");

                return 0;
            } 

            var index       = $("#persons-involved li:last").index() + 1;

            var involved    = "<li"
                    + " data-id=\""
                    + userId + "\""
                    + " data-name=\""
                    + userName + "\""
                    + ">"
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

            involved = involved 
                + "<button type=\"button\" class=\"ml\" onclick=\"removeInvolved(this);\">Remove</button>"
                + "</li>";

            if(index == 0) {
                $("#persons-involved").empty();
            }

            $("#person-list option[value=\"" + userId + "\"]").prop("disabled", true);

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

                var itemId          = $("#item-list").val();
                var itemQuantity    = $("#item-quantity").val();
                var itemName        = $("#item-list option:selected").text();

                if(itemId != "") {

                    var index       = $("#items-lost li:last").index() + 1;

                    var item    = "<li"
                    + " data-id=\""
                    + itemId + "\""
                    + " data-name=\""
                    + itemName + "\""
                    + ">"
                    + itemName
                    + "<input type=\"hidden\" name=\"item-id[" + index + "]\" value=" + itemId + ">"
                    + "<input type=\"hidden\" name=\"item-quantity[" + index + "]\" value=" + itemQuantity + ">"
                    + "<button type=\"button\" class=\"ml\" onclick=\"removeItem(this);\">Remove</button>"
                    + "</li>";

                    resetItemsInput();
                    
                    if(index == 0) {
                        $("#items-lost").empty();
                    }
                    $("#item-list option[value=\"" + itemId + "\"]").prop("disabled", true);

                    $("#item-list").trigger("chosen:updated");

                    $("#items-lost").append(
                        item                  
                    );


                }
                break;
            }

        }

    function removeItem(person) {        
        var $context        = $(person).closest("li");
        var itemId          = $($context).data("id");
        var itemName        = $($context).data("name");

        var confirmMessage = "Are you sure you want to remove " + itemName + " from lost items?"

        if(confirm(confirmMessage)) {
            var option = "<option value=\""
            + itemId + "\""
            +">" 
            + itemName
            + "</option>";

            $("#item-listoption[value=\"" + itemId + "\"]").prop("disabled", false);

            $("#item-list").trigger("chosen:updated");

            $($context).remove();

            if($("#items-lost li").length < 1) {
                $("#items-lost").html("None.");
            }

        }
    }

    function removeInvolved(person) {        
        var $context        = $(person).closest("li");
        var userId          = $($context).data("id");
        var userName        = $($context).data("name");

        var confirmMessage = "Are you sure you want to remove " + userName + " from involved persons?"
        if(confirm(confirmMessage)) {

            $("#person-list option[value=\"" + userId + "\"]").prop("disabled", false);

            $("#person-list").trigger("chosen:updated");

            $($context).remove();

            if($("#persons-involved li").length < 1) {
                $("#persons-involved").html("None.");
            }

        }
    }

</script>