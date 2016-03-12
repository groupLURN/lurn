$(".chosen").chosen();

Date.prototype.isValid = function () {
    // An invalid date object returns NaN for getTime() and NaN is the only
    // object not strictly equal to itself.
    return this.getTime() === this.getTime();
};

$(".datetime-picker").each(function(){
    var initialValue = Date.parse($(this).val());
    var today = new Date();
    $(this).datepicker().datepicker("option","dateFormat", "yy-mm-dd");
    if(initialValue.isValid())
        $(this).datepicker("setDate", initialValue);
    else if ($(this).hasClass('advance-1-day'))
    {
        today.setDate(today.getDate() + 1);
        $(this).datepicker("setDate", today);
    }
    else
        $(this).datepicker("setDate", today);
});


$(".number-only").keydown(function (e) {
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

$(".autocomplete").each(
    function(index)
    {
        $(this).autocomplete({
            source: backEnd.autocomplete[index]
        });
    }
);