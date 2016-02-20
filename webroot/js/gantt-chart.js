///// Application Logic

// Validation
gantt.attachEvent("onLightboxSave", function(id, item){
    var parentId = gantt.getParent(id);
    var parentItem = parentId? gantt.getTask(parentId): null;

    if(!item.text)
        gantt.message({type:"error", text:"There must be a description!"});
    else if(parentId > 0 && item.start_date < parentItem.start_date)
        gantt.message({type:"error", text:"Task cannot start earlier than the start date of its milestone!"});
    else if(parentId > 0 && item.start_date.clone().add(item.duration).days() > parentItem.start_date.clone().add(parentItem.duration).days())
        gantt.message({type:"error", text:"Task cannot end later than the end date of its milestone!"});
    else
        return true;

    return false;
});

// On Save
$(".btn-submit").on("click", function(event)
{
    //event.preventDefault();
    $("form input#data").val(JSON.stringify(gantt.serialize()));
});
///// Initialization and use of gantt-chart.
(function(gantt)
{
    gantt.init("gantt-chart");

    // To be called in zoom_tasks.
    function show_scale_options(mode){
        var hourConf = document.getElementById("filter_hours"),
            dayConf = document.getElementById("filter_days");
        if(mode == 'day'){
            hourConf.style.display = "none";
            dayConf.style.display = "";
            dayConf.getElementsByTagName("input")[0].checked = true;
        }else if(mode == "hour"){
            hourConf.style.display = "";
            dayConf.style.display = "none";
            hourConf.getElementsByTagName("input")[0].checked = true;
        }else{
            hourConf.style.display = "none";
            dayConf.style.display = "none";
        }
    }

    // To be called in zoom_tasks.
    function set_scale_units(mode){
        if(mode && mode.getAttribute){
            mode = mode.getAttribute("value");
        }

        switch (mode){
            case "work_hours":
                gantt.config.subscales = [
                    {unit:"hour", step:1, date:"%H"}
                ];
                gantt.ignore_time = function(date){
                    return (date.getHours() < 9 || date.getHours() > 16);
                };

                break;

            case "full_day":
                gantt.config.subscales = [
                    {unit:"hour", step:3, date:"%H"}
                ];
                gantt.ignore_time = null;
                break;

            case "work_week":
                gantt.ignore_time = function(date){
                    return (date.getDay() == 0 || date.getDay() == 6);
                };

                break;
            default:
                gantt.ignore_time = null;
                break;
        }
        gantt.render();
    }

    // Method called outside.
    function zoom_tasks(node){
        switch(node.value){
            case "week":
                gantt.config.scale_unit = "day";
                gantt.config.date_scale = "%d %M";

                gantt.config.scale_height = 60;
                gantt.config.min_column_width = 30;
                gantt.config.subscales = [
                    {unit:"hour", step:1, date:"%H"}
                ];
                show_scale_options("hour");
                break;
            case "trplweek":
                gantt.config.min_column_width = 70;
                gantt.config.scale_unit = "day";
                gantt.config.date_scale = "%d %M";
                gantt.config.subscales = [ ];
                gantt.config.scale_height = 35;
                show_scale_options("day");
                break;
            case "month":
                gantt.config.min_column_width = 70;
                gantt.config.scale_unit = "week";
                gantt.config.date_scale = "Week #%W";
                gantt.config.subscales = [
                    {unit:"day", step:1, date:"%D"}
                ];
                show_scale_options();
                gantt.config.scale_height = 60;
                break;
            case "year":
                gantt.config.min_column_width = 70;
                gantt.config.scale_unit = "month";
                gantt.config.date_scale = "%M";
                gantt.config.scale_height = 60;
                show_scale_options();
                gantt.config.subscales = [
                    {unit:"week", step:1, date:"#%W"}
                ];
                break;
        }
        set_scale_units();
        gantt.render();
    }

    // Default to day.
    show_scale_options("day");

    window.zoom_tasks = zoom_tasks;
})(gantt);