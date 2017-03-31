$(function () {
    $('.datepicker').datepicker({
        weekStart: 0,
        format: "yyyy-mm-dd",
        language: "fr",
        forceParse: false,
        daysOfWeekHighlighted: "0,6",
        autoclose: true,
        todayHighlight: true
    });
});