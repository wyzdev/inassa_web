$(document).ready(function(){
    $("button").click(function(){
        $(".search_client").toggle(400, function () {

        });
    });
});

$(function(){
    $("#dob").prop("readonly", true);
});