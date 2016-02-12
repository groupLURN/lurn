//$("#btn-search").on("click", function(e){
//
//    var $form = $(this).closest("form");
//    var $txtSearch = $("#txt-search");
//
//    var action = $form.attr("action").split("?")[0];
//    var queries = [];
//
//    if($txtSearch.length > 0 && $txtSearch.val().trim() !== "")
//        queries.push($txtSearch.attr("name") + "=" + $txtSearch.val().trim().split(" ").join("+"));
//
//    if(queries.length > 0)
//        action += "?" + queries.join("&");
//
//    $form.attr("action", action);
//});