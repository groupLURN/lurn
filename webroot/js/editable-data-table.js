// Due to time constraint, this will only work with one instance of the editable data table element.
var $editableDataTable = $(".editable-data-table");

$editableDataTable.clearTable = function()
{
    var $tr = $(this).find('tr.data');
    var size = $tr.length;
    for (var i = 0; i < size - 1; i++)
        $tr.eq(i).remove();
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