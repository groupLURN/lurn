$(".datetime-picker").datepicker().datepicker("option","dateFormat", "yy-mm-dd").datepicker("setDate", new Date());

var date_from = '<?= isset($date_from)? $date_from: ""?>';
if(date_from)
    $('input.datetime-picker[name=date_from]').val(date_from);

var date_to = '<?= isset($date_to)? $date_to: ""?>';
if(date_to)
    $('input.datetime-picker[name=date_to]').val(date_to);

