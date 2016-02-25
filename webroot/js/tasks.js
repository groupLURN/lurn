$("button").on("click",
    function()
    {
        $("i", this).attr("class", 'fa fa-arrow-' + ($(this).hasClass('collapsed')? 'down' : 'right'));
    }
);