function selectCurrentPill(element)
{
    var $context = $(element).closest("ul");
    $context.find("li").removeClass("active");
    $(element).closest("li").addClass("active");
}

function fillPane($pane, data)
{
    var i = 0;
    data.forEach(function(object)
    {
        var $li = $("<li>");
        if(i++ === 0)
            $li.addClass("active");

        var $a = $("<a>");
        $a.attr("onclick", "javascript:selectCurrentPill(this)");
        $a.attr("style", "cursor: pointer");
        $a.text(object.quantity + "x " + object.name);

        $pane.append($li.append($a));
    });
}
