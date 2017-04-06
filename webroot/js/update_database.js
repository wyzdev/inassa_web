
var id;

$(function () {
    $('.access').click('click', function () {
        var balise = $(this);
        id = balise.attr("num");
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
        id = balise.attr("num");
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
        id = balise.attr("num");

        document.getElementById('reset-user_modal-body').innerHTML = '<p>Est-ce que vous voulez vraiment réinitialiser le compte de <b>' + $(this).attr("firstname") + ' ' + $(this).attr("lastname") + '</b>?</p>' +
            '<p class="text-warning"><small>Le mot de passe et le droit d\'accès seront remis à l\'état d\'origine.</small></p>';


    });
});

$(function () {
    $('.confirmation_reset').click('click', function () {
        $.ajax({
            type: "POST",
            data: {value_to_send: id},
            url: "/users/resetAccount/",
            success: function (data) {
                if (data == 'no') {
                    alert("Vous ne pouvez pas réinitialiser votre compte");
                }
                else {
                    // alert("entrer et admin : admin"+id+" et status : status"+id);
                    $("#" + "admin" + id).prop('checked', false);
                    $("#" + "actif" + id).prop('checked', true);
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                //alert(xhr.responseText);
                alert(thrownError);
                //alert("false");
            }
        });


    });
});