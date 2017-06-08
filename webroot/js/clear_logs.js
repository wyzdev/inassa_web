$(function () {
    $('.confirmation_clear').click('click', function () {
        $.ajax({
            type: "POST",
            data: {value_to_send: ""},
            url: "http://localhost/inassa_web/logs/clearlogs/",
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
            '<p class="text-danger"><small>Les données effacées seront perdu à jamais.</small></p>';


    });
});