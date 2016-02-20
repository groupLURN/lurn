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