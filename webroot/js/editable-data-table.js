// Due to time constraint, this will only work with one instance of the editable data table element.
var $editableDataTable = $(".editable-data-table");

$editableDataTable.cloneDataRow = function()
{
    // Create a deep copy of the row.
    var $clone = $("tr.data:last").clone(true);

    // Manually un-chosen and re-chosen of every select tag found.
    $clone.find('select.chosen').each(function()
    {
        var $td = $(this).closest('td');
        $td.html($(this));
        $(this).chosen({width: '100%'});
    });

    // Clear all input:text.
    $clone.find('input').val('');
    return $clone;
};

$editableDataTable.clearTable = function()
{
    var $tr = $(this).find('tr.data');
    var size = $tr.length;
    for (var i = 0; i < size - 1; i++)
        $tr.eq(i).remove();
};

$editableDataTable.fillTable = function(data)
{
    var $self = this;
    var $newEntries = [];
    data.forEach(function(row)
    {
        var $tr = $self.cloneDataRow();
        $inputs = $.map($tr.children(), function(child)
        {
            return $(child).find('select, input').eq(0);
        });

        for(var i = 0; i < row.length && i < $inputs.length; i++)
        {
            $inputs[i].val(row[i]);
            if($inputs[i].is('select'))
                $inputs[i].trigger('chosen:updated');
        }
        $newEntries.push($tr);
    });

    for(var i = $newEntries.length - 1; i >= 0; i--)
        $self.find('tr.data:last').before($newEntries[i].show());
};

$editableDataTable.find('.editable-data-table-add').on('click', function(event)
{
    var $table = $(this).closest('table');
    var $trHeader = $table.find('tr.headers');
    var $tr = $(this).closest('tr');
    var errorMessages = [];
    $tr.children().each(function(index)
    {
        var $target = $(this).find('select, input').eq(0);
        if ($target.is(':disabled'))
            return;
        var value = $target.val();
        if(typeof value !== 'undefined' && (value.length === 0 || value == 0))
            errorMessages.push($trHeader.children().eq(index).text() + ' is invalid!');
    });
    if(errorMessages.length > 0)
    {
        alert(errorMessages.join('\n'));
        event.preventDefault();
        return;
    }
    var $clone = $tr.clone(true);
    var rowIndex = $tr.index();

    $clone.find('select.chosen').each(function()
    {
        var $td = $(this).closest('td');
        $td.html($(this));
        $(this).chosen({width: '100%'});
    });
    $clone.find('input').val('');
    $tr.after($clone);
    $tr.find('input, select').prop('disabled', true);
    $tr.find('select').trigger('chosen:updated');
});

$editableDataTable.find('.editable-data-table-delete').on('click', function(event)
{
    if(confirm('Are you sure you want to delete this entry?'))
        $(this).closest('tr').remove();
});