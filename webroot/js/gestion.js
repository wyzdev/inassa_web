$(document).ready(function () {
    $(".client_row").click(function () {
        $("#table_client").hide();

        saveInHistoric($(this));


        document.getElementById('display_client_info').innerHTML = '<span class="indicatif">Client</span><span class="deux-point">:</span><span class="result">' + $(this).attr("firstname") + ' ' + $(this).attr("lastname") + '</span><br/><span class="indicatif">Date de naissance</span><span class="deux-point">:</span><span class="result">' + $(this).attr("dob") + '</span>';

        if ($('#role_user').attr('role') != 'medecin') {
            document.getElementById('link_to_historic').innerHTML = "<a href=\"" + window.location.protocol + "//" + window.location.host + "/" + location.pathname.split('/')[1] + "/logs/historique?first_name=" + $(this).attr("firstname").replace(' ', "%20") + "&last_name=" + $(this).attr("lastname").replace(' ', "%20") + "&dob=" + $(this).attr("dob_search").substring(0, 10) + "\">Voir l\'historique de ce client</a>";
        }


        if ($(this).attr("status") == '1') {

            document.getElementById('display_client_status').innerHTML = "<span class=\"status_active\">Client Actif</span>";

            $("#display_client").show();
        }
        else {

            document.getElementById('display_client_status').innerHTML = "<span class=\"status_inactive\">Client inactif</span>";
        }


        $("#display_client").show();
    });

    function saveInHistoric(row) {
        var currentdate = new Date();

        var month = currentdate.getMonth() + 1;
        var day = currentdate.getDate();
        var hour = currentdate.getHours();
        var minute = currentdate.getMinutes();
        var second = currentdate.getSeconds();

        var firstname = row.attr("firstname");
        var lastname = row.attr("lastname");
        var dob = row.attr("dob");
        var status = row.attr("status");
        var doctor_name = row.attr("user_fullname");
        var institution = row.attr("user_institution");
        var date = currentdate.getFullYear() + "-"
            + ((month < 10) ? '0' + month : month) + "-"
            + ((day < 10) ? '0' + day : day) + " "
            + ((hour < 10) ? '0' + hour : hour) + ":"
            + ((minute < 10) ? '0' + minute : minute) + ":"
            + ((second < 10) ? '0' + second : second);

        var date_dob = new Date(dob);
        var month_dob = date_dob.getMonth() + 1;
        var day_dob = date_dob.getDate();

        var new_dob =
            date_dob.getFullYear() + "-"
            + ((month_dob < 10) ? '0' + month_dob : month_dob) + "-"
            + ((day_dob < 10) ? '0' + day_dob : day_dob);

        saveHistoricInDatabase(firstname, lastname, new_dob, status, doctor_name, institution, date);
    }

    function saveHistoricInDatabase(firstname, lastname, dob, status, doctor_name, institution, date) {

        $.post(
            window.location.protocol + "//" + window.location.host + "/" + location.pathname.split('/')[1] + "/clients/saveInHistoric/",
            {
                first_name: firstname,
                last_name: lastname,
                dob: dob,
                status: (status == 1) ? 1 : 0,
                doctor_name: doctor_name,
                institution: institution,
                date: date
            },
            function (data, status) {
                if (status == 'success') {
                    // alert(data);
                } else {
                    alert('Une erreur s\'est produite');
                }
            }
        );
    }

    $(".btn-blue").click(function () {
        $("#table_client").hide();
        $("#display_client").hide();
        $(".btn-blue").hide();
        $("#client_not_exist").hide();

        document.getElementsByName("first_name")[0].value = "";
        document.getElementsByName("last_name")[0].value = "";
        document.getElementsByName("datepicker_dropdown")[0].value = "";
    });
});