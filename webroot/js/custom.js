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

$('body').on('keypress','.number-only',function (e) {
    var keyCode = e.which;
    
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(keyCode, [0, 46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A
        (keyCode == 65 || keyCode == 97 && e.ctrlKey === true) ||
            // Allow: Ctrl+C
        (keyCode == 67 || keyCode == 99 && e.ctrlKey === true) ||
            // Allow: Ctrl+X
        (keyCode == 88 || keyCode == 120 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
        (keyCode >= 35 && keyCode <= 39)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if (e.shiftKey || !(keyCode > 47 && keyCode < 58)) {
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
        $('#finish-project').modal('show');
    });

    $('#finish-project-confirm').click(function () {       
        $('#finish-form').submit();
    });

    $('#change-phase-submit').click(function (e) {
        e.preventDefault();
        $('#change-phase').modal('show');
    });

    $('#change-phase-confirm').click(function () {    
        var phase = $('#phase').val(); 
        var input = '<input name="phase" type="hidden" value="' + phase + '">';

        $('#change-phase-form').append(input);
        $('#change-phase-form').submit();
    });


});
