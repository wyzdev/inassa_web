$(function () {
    $('.access').click('click', function () {
        $.ajax({
            type: "POST",
            data: {value_to_send: $(this).attr("num")},
            url: "/users/updateAccess/",
            success: function (data) {
                if (data == 'no')
                    alert("Vous ne pouvez pas changer votre droit d'accès");// will alert "ok"

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
        $.ajax({
            type: "POST",
            data: {value_to_send: $(this).attr("num")},
            url: "/users/updateStatus/",
            success: function (data) {
                if (data == 'no')
                    alert("Vous ne pouvez pas changer votre status");// will alert "ok"

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
        if (confirm('Voulez vous vraiment réinitialiser le compte de ' + $(this).attr("firstname") + ' ' + $(this).attr("lastname"))) {
            $.ajax({
                type: "POST",
                data: {value_to_send: $(this).attr("num")},
                url: "/users/resetAccount/",
                success: function (data) {
                    if (data == 'no')
                        alert("Vous ne pouvez pas reinitialiser votre compte");// will alert "ok"

                },
                error: function () {
                    alert("false");
                }
            });
        }


    });
});