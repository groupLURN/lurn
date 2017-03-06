<?php

$defaults = [
    'resource' => 'equipment',
    'quantity' => 'true', // Shows/Hides the quantity text field.
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
            <?= $this->Form->input($resource.'-list', [
                'label' => false,
                'type' => 'select',
                'data-placeholder' => 'No ' . __($resource),
                'class' => 'chosen resource form-control',
                'options' => $options
            ]) ?>
        </div>
        <div class="child-center">
            <?php if ($quantity) : ?>
                Quantity
                <input type="text" class='number-only resource-quantity' style="text-align: center;">
            <?php endif; ?>
            &nbsp;
            <img src=<?=$this->Url->image('add.png')?> alt="Add" style="cursor: pointer;" onclick="if(<?= $checker ?> === true) add_<?= $resource ?>(this);">
        </div>
    </div>
    <ul class="options">
        <?php foreach ($values as $value) : ?>
            <li onclick="$(this).remove();">
                <?php if ($quantity) : ?>
                    <input type="hidden" name="<?= $nameHolder ?>[_joinData][][quantity]"
                           value="<?= $value['_joinData']['quantity'] ?>">
                <?php endif; ?>
                <input type="hidden" class="id" name="<?= $nameHolder ?>[id][]" value="<?= $value['id'] ?>">
                <?php if ($quantity) : ?> <?= $value['_joinData']['quantity'] ?>x  <?php endif; ?>
                <?= isset($value['name']) ? $value['name'] : $value['title'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script>
    function add_<?= $resource ?>(object) {
        var $context = $(object).closest("div.multi-select-with-input");
        var $select = $("select.chosen", $context);

        if($select.val() === null)
            return;

        var $ul = $("ul.options", $context);

        var $li = $("<li>", {
            onclick: '<?= $resource ?>ResetInput(this);'
        });

        var selectedObject = {
            id: $select.val(),
            name: $select.find('[value= ' + $select.val() + ']').text()
        };;

        <?php if($quantity) : ?>
        selectedObject.quantity = $(".resource-quantity", $context).val();
        $li.append($("<input>", {type: "hidden"}).attr("name", "<?=$nameHolder ?>[_joinData][][quantity]").val(selectedObject.quantity));
        <?php endif; ?>

        $li.append($("<input>", {
            type: "hidden",
            class: 'id'
        }).attr("name", "<?=$nameHolder ?>[id][]").val(selectedObject.id));

        $li.append(
            <?php if($quantity) : ?>
            selectedObject.quantity + 'x ' +
            <?php endif; ?>
            selectedObject.name);

        if ($ul.find('input.id[value=' + selectedObject.id + ']').length === 0
            <?php if($quantity) : ?> && selectedObject.quantity.trim() !== "" <?php endif; ?>
        ) {
            $ul.append($li);

            $select.find('[value= ' + $select.val() + ']').attr('disabled', true);
            $select.trigger('chosen:updated');
        }
    }

    function <?= $resource ?>ResetInput(object) {
        var $context = $(object).closest("div.multi-select-with-input");
        var $select = $("select.chosen", $context);
        var id = $(object).find('.id').val();

        $select.find('[value='+id+']').attr('disabled', false);
        $select.trigger('chosen:updated');
        $(object).remove();
    }
</script>