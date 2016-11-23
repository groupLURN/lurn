var link = $('#base-link').text();

$('.chosen').chosen({width: '100%'});

Date.prototype.isValid = function () {
    // An invalid date object returns NaN for getTime() and NaN is the only
    // object not strictly equal to itself.
    return this.getTime() === this.getTime();
};

$('.datetime-picker').each(function(){

    var value = $(this).val().trim().length > 0? Date.parse($(this).val()) : new Date();
    $(this).datepicker().datepicker('option','dateFormat', 'yy-mm-dd');

    if($(this).hasClass('advance-1-day'))
    {
        value.setDate(value.getDate() + 1);
        $(this).datepicker('setDate', value);
    }
    else
        $(this).datepicker('setDate', value);
});


$('.number-only').keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: Ctrl+C
        (e.keyCode == 67 && e.ctrlKey === true) ||
            // Allow: Ctrl+X
        (e.keyCode == 88 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});

$('.autocomplete').each(
    function(index)
    {
        $(this).autocomplete({
            source: backEnd.autocomplete[index]
        });
    }
);


$.ajax({ 
    type: 'GET', 
    url: link+'/notifications/getUnreadNotificationsCount', 
    data: { get_param: 'value' }, 
    success: function (data) { 
        var count = data.data.count;
        if(count == 0) {
            $('#notification-badge').hide();
        } else {
            $('#notification-badge').show();
            $('#notification-badge').text(count);
        }
    }
});

setInterval(function(){  
    $.ajax({ 
        type: 'GET', 
        url: link+'/notifications/getUnreadNotificationsCount', 
        data: { get_param: 'value' }, 
        success: function (data) { 
            var count = data.data.count;
            if(count == 0) {
                $('#notification-badge').hide();
            } else {
                $('#notification-badge').show();
                $('#notification-badge').text(count);
            }
        }
    });
}, 5000);

$(function(){
    $('#finish-form-submit').click(function (e) {
        e.preventDefault();
        $("#finish-project").modal('show');
    });

    $('#finish-project-confirm').click(function () {       
        $('#finish-form').submit();
    });

});
