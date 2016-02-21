//webix.ready() function ensures that the code will be executed when the page is loaded
webix.ready(function(){
    //object constructor
    webix.ui({
        view:"kanban",
        type:"space",
        container:"kanban-board",
        //the structure of columns on the board
        cols:[
            { header:"Pending",
                body:{ view:"kanbanlist", status:"new" }},
            { header:"In Progress",
                body:{ view:"kanbanlist", status:"work" }},
            { header:"Delayed",
                body:{ view:"kanbanlist", status:"test" }},
            { header:"Done",
                body:{ view:"kanbanlist", status:"done" }}
        ],
        //url to the file with data collection
        url: "tasks.php"
    });
});