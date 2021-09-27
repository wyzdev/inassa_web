$(function () {
    $('.test_api').click('click', function () {
        $('#content_loader3').show(); //display the loader
        $.ajax({
            type: "POST",
            data: {value_to_send: ""},
            url: window.location.protocol+"//"+window.location.host + "/" + location.pathname.split('/')[1] + "/clients/testApi/",
            success: function (data) {
                $('#content_loader3').hide();
                if (data == true){
                    alert("bon");
                   // alert(data);
                }
                else if (data == false) {
                    alert("pas bon");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#content_loader3').hide();
                $('#content_').hide();
                alert("false");
                //alert(xhr.status);
                alert(xhr.responseText);
                alert(thrownError);
            }
        });


    }, function () {

    });
});