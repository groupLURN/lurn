<?php $quantity = isset($quantity)? $quantity: true; ?>

<div class="content-panel multi-select-with-input">
    <table>
        <tr>
            <td>
                <?= $this->Form->input('equipment_list', [
                    'label' => false,
                    'type' => 'select',
                    'class' => 'chosen resource form-control',
                    'options' => $options
                ]) ?>
            </td>
            <td>
                <?php if($quantity) : ?>
                <input type="text" class='number-only resource-quantity'>
                Quantity
                <?php endif; ?>
                <img src="/img/add.png" alt="Add" style="cursor: pointer;" onclick="add_<?= $resource ?>(this)">
            </td>
        </tr>
    </table>
    <ul class="options">
    </ul>
</div>

<script>
    function add_<?= $resource ?>(object){
        var $context = $(object).closest("div");
        var $select = $("select.chosen", $context);
        var $ul = $("ul.options", $context);

        var $li = $("<li>", {
            onclick: '$(this).remove();'
        });

        var selectedObject = {
            id: $("select.chosen", $context).val(),
            name: $select.find('[value= ' + $("select.chosen", $context).val() + ']').text()
        };

        <?php if($quantity) : ?>
        selectedObject.quantity = $(".resource-quantity", $context).val();
        $li.append($("<input>", {type: "hidden"}).attr("name", "resources[<?=$resource ?>][_joinData][][quantity]").val(selectedObject.quantity));
        <?php endif; ?>

        $li.append($("<input>", {type: "hidden", class:'id'}).attr("name", "resources[<?=$resource ?>][id][]").val(selectedObject.id));

        $li.append(
            <?php if($quantity) : ?>
                selectedObject.quantity + 'x ' +
            <?php endif; ?>
            selectedObject.name);

        if($ul.find('input.id[value=' + selectedObject.id + ']').length === 0
            <?php if($quantity) : ?> && selectedObject.quantity.trim() !== "" <?php endif; ?>
        )
            $ul.append($li);
    }
</script>