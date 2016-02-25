$("button").on("click",
    function()
    {
        $("i", this).attr("class", 'fa fa-arrow-' + ($(this).hasClass('collapsed')? 'down' : 'right'));
    }
);

function selectResource(select)
{
    var $ul = $(select).prev('ul');
    console.log($ul);

    if ($ul.find('input[value=' + $(select).val() + ']').length == 0)
        $ul.append('<li onclick="$(this).remove();">' +
            '<input type="hidden" name="ingredients[]" value="' +
            $(select).val() + '" /> ' +
            $(select).find('option[selected]').text() + '</li>');
}

$(".add-button").on("click", function()
{
    var $context = $(this).closest("div");
    var $select = $("select.chosen", $context);
    var $ul = $("ul", $context);

    var $li = $("<li>", {
        onclick: '$(this).remove();'
    });

    var selectedObject = {
        id: $("select.chosen", $context).val(),
        name: $select.find('[value= ' + $("select.chosen", $context).val() + ']').text(),
        quantity: $(".resource-quantity", $context).val()
    };

    var index = $("li", $ul).length;
    $li.append($("<input>", {type: "hidden", class:'id'}).attr("name", "equipment[" + index + "][id]").val(selectedObject.id));
    $li.append($("<input>", {type: "hidden"}).attr("name", "equipment[" + index + "][_joinData][quantity]").val(selectedObject.quantity));
    $li.append(selectedObject.quantity + 'x ' + selectedObject.name);

    if($ul.find('input.id[value=' + selectedObject.id + ']').length === 0 && selectedObject.quantity.trim() !== "")
        $ul.append($li);
});