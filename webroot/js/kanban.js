//webix.ready() function ensures that the code will be executed when the page is loaded
webix.ready(function(){
    //object constructor
    webix.ui({
        view:"kanban",
        type:"board",
        container:"kanban-board",
        //the structure of columns on the board
        cols: kanbanColumns,
        data: kanbanData
    });
});