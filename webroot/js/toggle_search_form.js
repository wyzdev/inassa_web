$(document).ready(function(){
    $(".button_search").click(function(){
        $(".search_client").toggle(400, function () {

        });
    });
});

$(function(){
    $("#dob").prop("readonly", true);
});