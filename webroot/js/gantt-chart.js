gantt.init("gantt-chart");

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


var demo_tasks = {
    data:[
        {"id":1, "text":"Office itinerancy", "order":"10", progress: 0.4, open: true, priority:0, project:1 },

        {"id":2, "text":"Office facing", "start_date":"02-04-2013", "duration":"8", progress:0.5, "order":"10", progress: 0.6, "parent":"1", open: true, priority:1 },
        {"id":3, "text":"Furniture installation", "start_date":"11-04-2013", "duration":"8", "order":"20", "parent":"1", progress: 0.6, open: true, priority:1 },
        {"id":4, "text":"The employee relocation", "start_date":"13-04-2013", "duration":"6", "order":"30", "parent":"1", progress: 0.5, open: true, priority:1 },

        {"id":5, "text":"Interior office", "start_date":"02-04-2013", "duration":"7", "order":"3", "parent":"2", progress: 0.6, open: true, priority:0 },
        {"id":6, "text":"Air conditioners check", "start_date":"03-04-2013", "duration":"7", "order":"3", "parent":"2", progress: 0.6, open: true, priority:0 },
        {"id":7, "text":"Workplaces preparation", "start_date":"11-04-2013", "duration":"8", "order":"3", "parent":"3", progress: 0.6, open: true, priority:0 },
        {"id":8, "text":"Preparing workplaces", "start_date":"14-04-2013", "duration":"5", "order":"3", "parent":"4", progress: 0.5, open: true, priority:0 },
        {"id":9, "text":"Workplaces importation", "start_date":"14-04-2013", "duration":"4", "order":"3", "parent":"4", progress: 0.5, open: true, priority:0 },
        {"id":10, "text":"Workplaces exportation", "start_date":"14-04-2013", "duration":"3", "order":"3", "parent":"4", progress: 0.5, open: true, priority:0 },

        {"id":11, "text":"Product launch", "order":"5", progress: 0.6, open: true, priority:2, project:1},

        {"id":12, "text":"Perform Initial testing", "start_date":"03-04-2013", "duration":"5", "order":"3", "parent":"11", progress: 1, open: true, priority:0 },
        {"id":13, "text":"Development", "start_date":"02-04-2013", "duration":"7", "order":"3", "parent":"11", progress: 0.5, open: true, priority:2 },
        {"id":14, "text":"Analysis", "start_date":"02-04-2013", "duration":"6", "order":"3", "parent":"11", progress: 0.8, open: true, priority:2 },
        {"id":15, "text":"Design", "start_date":"02-04-2013", "duration":"5", "order":"3", "parent":"11", progress: 0.2, open: true, priority:0 },
        {"id":16, "text":"Documentation creation", "start_date":"02-04-2013", "duration":"7", "order":"3", "parent":"11", progress: 0, open: true, priority:0 },

        {"id":17, "text":"Develop System", "start_date":"03-04-2013", "duration":"2", "order":"3", "parent":"13", progress: 1, open: true, priority:2 },
        {"id":18, "text":"Integrate System", "start_date":"06-04-2013", "duration":"3", "order":"3", "parent":"13", progress: 0.8, open: true, priority:2 },
        {"id":19, "text":"Test", "start_date":"10-04-2013", "duration":"4", "order":"3", "parent":"13", progress: 0.2, open: true, priority:2 },
        {"id":20, "text":"Marketing", "start_date":"10-04-2013", "duration":"4", "order":"3", "parent":"13", progress: 0, open: true, priority:2 },

        {"id":21, "text":"Design database", "start_date":"03-04-2013", "duration":"4", "order":"3", "parent":"15", progress: 0.5, open: true, priority:0 },
        {"id":22, "text":"Software design", "start_date":"03-04-2013", "duration":"4", "order":"3", "parent":"15", progress: 0.1, open: true, priority:0 },
        {"id":23, "text":"Interface setup", "start_date":"03-04-2013", "duration":"5", "order":"3", "parent":"15", progress: 0, open: true}
    ],
    links:[
        {id:"1",source:"1",target:"2",type:"1"},
        {id:"2",source:"2",target:"3",type:"0"},
        {id:"3",source:"3",target:"4",type:"0"},
        {id:"4",source:"2",target:"5",type:"2"},
        {id:"5",source:"2",target:"6",type:"2"},
        {id:"6",source:"3",target:"7",type:"2"},
        {id:"7",source:"4",target:"8",type:"2"},
        {id:"8",source:"4",target:"9",type:"2"},
        {id:"9",source:"4",target:"10",type:"2"},

        {id:"10",source:"11",target:"12",type:"1"},
        {id:"11",source:"11",target:"13",type:"1"},
        {id:"12",source:"11",target:"14",type:"1"},
        {id:"13",source:"11",target:"15",type:"1"},
        {id:"14",source:"11",target:"16",type:"1"},

        {id:"15",source:"13",target:"17",type:"1"},
        {id:"16",source:"17",target:"18",type:"0"},
        {id:"17",source:"18",target:"19",type:"0"},
        {id:"18",source:"19",target:"20",type:"0"},
        {id:"19",source:"15",target:"21",type:"2"},
        {id:"20",source:"15",target:"22",type:"2"},
        {id:"21",source:"15",target:"23",type:"2"}
    ]
};

gantt.attachEvent("onBeforeTaskDisplay", function(id, task){
    if (gantt_filter)
        if (task.priority != gantt_filter)
            return false;

    return true;
});

gantt.templates.scale_cell_class = function(date){
    if(date.getDay()==0||date.getDay()==6){
        return "weekend";
    }
};
gantt.templates.task_cell_class = function(item,date){
    if(date.getDay()==0||date.getDay()==6){
        return "weekend" ;
    }
};

var gantt_filter = 0;
function filter_tasks(node){
    gantt_filter = node.value;
    gantt.refreshData();
}


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
                if(date.getHours() < 9 || date.getHours() > 16){
                    return true;
                }else{
                    return false;
                }
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
                if(date.getDay() == 0 || date.getDay() == 6){
                    return true;
                }else{
                    return false;
                }
            };

            break;
        default:
            gantt.ignore_time = null;
            break;
    }
    gantt.render();
}


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

show_scale_options("day");
gantt.config.details_on_create = true;

gantt.templates.task_class = function(start, end, obj){
    return obj.project ? "project" : "";
}

gantt.config.columns = [
    {name:"text",       label:"Task name",  width:"*", tree:true },
    {name:"progress",   label:"Status",  template:function(obj){
        return Math.round(obj.progress*100)+"%";
    }, align: "center", width:60 },
    {name:"priority",   label:"Priority",  template:function(obj){
        return gantt.getLabel("priority", obj.priority);
    }, align: "center", width:60 },
    {name:"add",        label:"",           width:44 }
];
gantt.config.grid_width = 390;

gantt.attachEvent("onTaskCreated", function(obj){
    obj.duration = 4;
    obj.progress = 0.25;
})

gantt.locale.labels["section_priority"] = "Priority";
gantt.config.lightbox.sections = [
    {name: "description", height: 38, map_to: "text", type: "textarea", focus: true},
    {name: "priority", height: 22, map_to: "priority", type: "select", options: [
        {key:"1", label: "Low"},
        {key:"0", label: "Normal"},
        {key:"2", label: "High"} ]},
    {name: "time", type: "duration", map_to: "auto", time_format:["%d","%m","%Y","%H:%i"]}
];

gantt.init("gantt-chart");
gantt.parse(demo_tasks);
