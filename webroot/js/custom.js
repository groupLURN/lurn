Date.prototype.isValid = function () {
    // An invalid date object returns NaN for getTime() and NaN is the only
    // object not strictly equal to itself.
    return this.getTime() === this.getTime();
};

$(".datetime-picker").each(function(){
    var initialValue = new Date($(this).val());
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