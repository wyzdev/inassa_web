$(function () {
    $('.datepicker').datepicker({
        weekStart: 0,
        format: "mm/dd/yyyy",
        language: "fr",
        forceParse: false,
        daysOfWeekHighlighted: "0,6",
        autoclose: true,
        todayHighlight: true
    });
});