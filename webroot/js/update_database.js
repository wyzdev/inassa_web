
var id;

$(function () {
    $('.access').click('click', function () {
        var balise = $(this);
        id = balise.attr("num");
        $.ajax({
            type: "POST",
            data: {value_to_send: id},
            url: "http://localhost/inassa_web/users/updateAccess/",
            success: function (data) {
                if (data == 'no') {

                    interdit("Vous ne pouvez pas changer votredroit d\'accès");

                    if ($("#" + balise.attr("id")).is(':checked'))
                        $("#" + balise.attr("id")).prop('checked', false);
                    else
                        $("#" + balise.attr("id")).prop('checked', true);
                }
                else{
                    var acces = "";
                    if ($("#" + balise.attr("id")).is(':checked'))
                        acces = 'admin';
                    else
                        acces = 'simple utilisateur';

                    changement('#admin'+id, acces)
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
            url: "http://localhost/inassa_web/users/updateStatus/",
            success: function (data) {
                if (data == 'no') {

                    interdit("Vous ne pouvez pas changer votre status");

                    if ($("#" + balise.attr("id")).is(':checked'))
                        $("#" + balise.attr("id")).prop('checked', false);
                    else
                        $("#" + balise.attr("id")).prop('checked', true);
                }
                else{

                    var status = "";
                    if ($("#" + balise.attr("id")).is(':checked'))
                        status = 'actif';
                    else
                        status = 'inactif';
                    changement('#actif'+id, status);
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

        document.getElementById('reset-user_modal-body').innerHTML = '<p>Voulez-vous vraiment réinitialiser le compte de <b>' + $(this).attr("firstname") + ' ' + $(this).attr("lastname") + '</b>?</p>' +
            '<p class="text-warning"><small>Le mot de passe et le droit d\'accès seront remis à l\'état d\'origine.</small></p>';


    });
});

$(function () {
    $('.confirmation_reset').click('click', function () {
        $.ajax({
            type: "POST",
            data: {value_to_send: id},
            url: "http://localhost/inassa_web/users/resetAccount/",
            success: function (data) {
                if (data == 'no') {
                    interdit("Vous ne pouvez pas réinitialiser votre compte");
                }
                else {

                    document.getElementById('dialog-message').innerHTML = '<p><center>Le compte de l\'utilisateur <b>' + $('#admin'+id).attr("firstname") + ' ' + $('#admin'+id).attr("lastname") + '</b> a été <b>réinitialisé</b>.</center></p>';


                    $( function() {
                        $( "#dialog-message" ).dialog({
                            modal: true,
                            buttons: {
                                Ok: function() {
                                    $( this ).dialog( "close" );
                                }
                            }
                        });
                    } );

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

function changement (id, value) {
    document.getElementById('dialog-message').innerHTML = '<p><center>L\'utilisateur <b>' + $(id).attr("firstname") + ' ' + $('#admin'+id).attr("lastname") + '</b> est maintenant <b>'+ value +'</b>.</center></p>';


    $( function() {
        $( "#dialog-message" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    } );
}


function interdit(value){
    document.getElementById('dialog-message').innerHTML = '<center><p class="text-danger"><b>'+ value +'.</b></p></center>';
    $( function() {
        $( "#dialog-message" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    } );
}