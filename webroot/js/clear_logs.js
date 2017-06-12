$(function () {
    $('.confirmation_clear').click('click', function () {
        //alert(location.pathname.split('/')[1]);
        $.ajax({
            type: "POST",
            data: {value_to_send: ""},
            url: window.location.protocol+"//"+window.location.host + "/" + location.pathname.split('/')[1] + "/logs/clearlogs/",
            success: function (data) {
                location.reload(true);
            },
            error: function () {
                alert("false");
            }
        });


    }, function () {

    });
});


$(function () {
    $('#clear_logs').click('click', function () {
        var balise = $(this);
        id = balise.attr("num");

        document.getElementById('reset-user_modal-body').innerHTML = '<p>Voulez-vous vraiment effacer les logs <b></p>' +
            '<p class="text-danger"><small>Les données effacées seront perdues.</small></p>';


    });
});