function selectCurrentPill(element)
{
    var $context = $(element).closest("ul");
    $context.find("li").removeClass("active");
    $(element).closest("li").addClass("active");
    var id = $(element).attr("id");
    var $selectedDiv = $('div#' + id);
    $selectedDiv.closest('.right-pane').find('.multi-select-with-input').hide();
    $selectedDiv.show();
}
