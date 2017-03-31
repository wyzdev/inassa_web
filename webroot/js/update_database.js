$(function () {
    $('.access').click('click', function () {
        var balise = $(this);
        var id = balise.attr("num");
        $.ajax({
            type: "POST",
            data: {value_to_send: id},
            url: "/users/updateAccess/",
            success: function (data) {
                if (data == 'no') {
                    alert("Vous ne pouvez pas changer votre droit d'accès");// will alert "ok"
                    if ($("#" + balise.attr("id")).is(':checked'))
                        $("#" + balise.attr("id")).prop('checked', false);
                    else
                        $("#" + balise.attr("id")).prop('checked', true);
                }

            },
            error: function () {
                alert("false");
            }
        });


    }, function () {

    });
});

$(function () {
    $('.status').click('click', function () {
        var balise = $(this);
        var id = balise.attr("num");
        $.ajax({
            type: "POST",
            data: {value_to_send: id},
            url: "/users/updateStatus/",
            success: function (data) {
                if (data == 'no') {
                    alert("Vous ne pouvez pas changer votre status");// will alert "ok"
                    if ($("#" + balise.attr("id")).is(':checked'))
                        $("#" + balise.attr("id")).prop('checked', false);
                    else
                        $("#" + balise.attr("id")).prop('checked', true);
                }

            },
            error: function () {
                alert("false");
            }
        });


    }, function () {

    });
});

$(function () {
    $('.reset').click('click', function () {
        var balise = $(this);
        var id = balise.attr("num");
        if (confirm('Voulez vous vraiment réinitialiser le compte de ' + $(this).attr("firstname") + ' ' + $(this).attr("lastname"))) {
            $.ajax({
                type: "POST",
                data: {value_to_send: id},
                url: "/users/resetAccount/",
                success: function (data) {
                    if (data == 'no') {
                        alert("Vous ne pouvez pas reinitialiser votre compte");
                    }
                    else {
                        $("#" + "admin" + id).prop('checked', false);
                        $("#" + "status" + id).prop('checked', true);
                    }

                },
                error: function () {
                    alert("false");
                }
            });
        }


    });
});