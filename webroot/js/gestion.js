$(document).ready(function () {
    var user_id;
    user_id = $("#user_id").attr("data-user-id");


    $("#print_client").click(function(){
        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head><title>Recherche '+ $("#code_container").text() +'</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h5></h5>');
        mywindow.document.write(document.getElementById('print_content').innerHTML);
        mywindow.document.write('<style>'+document.getElementById('pdf_style').innerHTML+'</style>');
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;



    });

    // $(".client_row").click(function () {

        // $("#table_client").hide();

        // //saveInHistoric($(this));

        // if ($('#role_user').attr('role') != 'medecin') {
        //     document.getElementById('link_to_historic').innerHTML = "<a href=\"" + window.location.protocol + "//" + window.location.host + "/" + location.pathname.split('/')[1] + "/logs/historique?first_name=" + $(this).attr("firstname").replace(' ', "%20") + "&last_name=" + $(this).attr("lastname").replace(' ', "%20") + "&dob=" + $(this).attr("dob_search").substring(0, 10) + "\">Voir l\'historique de ce client</a>";
        // }

        // if ($(this).attr("primary_employee_id") == $(this).attr("employeeid")){
        //      document.getElementById('display_client_info').innerHTML = '<span class="indicatif">Client</span><span class="deux-point">:</span><span class="result">' + $(this).attr("firstname") + ' ' + $(this).attr("lastname") + '</span><br/><span class="indicatif">Identification</span><span class="deux-point">:</span><span class="result">' + $(this).attr("employeeid") + '</span><br><span class="indicatif">Compagnie</span><span class="deux-point">:</span><span class="result">' + $(this).attr("company") + '</span><br><span class="indicatif">Numéro de police hérité</span><span class="deux-point">:</span><span class="result">' + $(this).attr("legacy_number") + '</span><br><span class="indicatif">Date de Naissance</span><span class="deux-point">:</span><span class="result">' + $(this).attr("dob") + '</span><br><span class="indicatif">Hero</span><span class="deux-point">:</span><span class="result label label-danger">' + $(this).attr("hero") + '</span><br><span class="indicatif">Dépendant</span><span class="deux-point">:</span><span class="result">NON</span>';
        // }else{
        //     document.getElementById('display_client_info').innerHTML = '<span class="indicatif">Client</span><span class="deux-point">:</span><span class="result">' + $(this).attr("firstname") + ' ' + $(this).attr("lastname") + '</span><br/><span class="indicatif">Identification</span><span class="deux-point">:</span><span class="result">' + $(this).attr("employeeid") + '</span><br><span class="indicatif">Compagnie</span><span class="deux-point">:</span><span class="result">' + $(this).attr("company") + '</span><br><span class="indicatif">Numéro de police hérité</span><span class="deux-point">:</span><span class="result">' + $(this).attr("legacy_number") + '</span><br><span class="indicatif">Date de Naissance</span><span class="deux-point">:</span><span class="result">' + $(this).attr("dob") + '</span><br><span class="indicatif">Hero</span><span class="deux-point">:</span><span class="result label label-danger">' + $(this).attr("hero") + '</span><br><span class="indicatif">Dépendant</span><span class="deux-point">:</span><span class="result">OUI</span><br><span class="indicatif">Nom Primaire</span><span class="deux-point">:</span><span class="result">' + $(this).attr("primary_name") + ' - ' + $(this).attr("primary_employee_id") + '</span><br>';
        // }

        // if ($(this).attr("status") == '1') {

        //     document.getElementById('display_client_status').innerHTML = "<span class=\"status_active\">Client Actif</span>";

        //     $("#display_client").show();
        // }
        // else {

        //     document.getElementById('display_client_status').innerHTML = "<span class=\"status_inactive\">Client inactif</span>";
        // }

        // // document.getElementById('print_client').innerHTML = "<?= $this->Html->link(__('<i class=\"fa fa-envelope mail_result\" style=\"color: rgba(23, 27, 124, .9);\"></i>'),'controller' => 'clients','action' => 'sendresearch',json_encode($clients["+$(this).attr("key")+"]),json_encode($this->request->session()->read('Auth.User'))],['escape' => false,'title' => 'Envoye par email']) ?>";
        // // document.getElementById('mail_client').innerHTML = "<a href=\"" + window.location.protocol + "//" + window.location.host + "/" + location.pathname.split('/')[1] + "/gestion/sendResearch?first_name=" + $(this).attr("firstname").replace(' ', "%20") + "&last_name=" + $(this).attr("lastname").replace(' ', "%20") + "&dob=" + $(this).attr("dob_search").substring(0, 10) + "\">Voir l\'historique de ce client</a>";

        // // document.getElementById('print_client').innerHTML = "<a href=\"" + window.location.protocol + "//" + window.location.host + "/" + location.pathname.split('/')[1] + "/gestion/sendResearch? <?= json_encode($clients["+$(this).attr("key")+"]) ?> \">Imprimer</a>";
        // // document.getElementById('mail_client').innerHTML = "<a href=\"" + window.location.protocol + "//" + window.location.host + "/" + location.pathname.split('/')[1] + "/gestion/sendResearch? <?= json_encode($clients["+$(this).attr("key")+"]) ?> \">mail</a>";




        // $("#display_client").show();
    // });

    function saveInHistoric(row) {
        var currentdate = new Date();

        var month = currentdate.getMonth() + 1;
        var day = currentdate.getDate();
        var hour = currentdate.getHours();
        var minute = currentdate.getMinutes();
        var second = currentdate.getSeconds();

        var employeeid = row.attr("employeeid");
        var primaryName = row.attr("primary_name");
        var primaryEmployeeId = row.attr("primary_employee_id");
        var firstname = row.attr("firstname");
        var lastname = row.attr("lastname");
        var dob = row.attr("dob");
        var hero = row.attr("hero");
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

        var is_dependant = 0;

        // check for dependance
        if (employeeid != primaryEmployeeId)
            is_dependant = 1;

        saveHistoricInDatabase(firstname, lastname, dob, status, doctor_name, institution, date, employeeid,
            primaryName, primaryEmployeeId, hero, is_dependant);
    }

    function saveHistoricInDatabase(firstname, lastname, dob, status, doctor_name, institution, date, employeeid,
                                    primaryName, primaryEmployeeId, heroTag, is_dependant) {
        $.post(
            window.location.protocol + "//" + window.location.host + "/" + location.pathname.split('/')[1] + "/clients/saveInHistoric/",
            {
                first_name: firstname,
                last_name: lastname,
                hero: heroTag,
                employee_id: employeeid,
                primary_name : primaryName,
                primary_employee_id : primaryEmployeeId,
                dob: dob,
                status: (status == 1) ? 1 : 0,
                doctor_name: doctor_name,
                institution: institution,
                date: date,
                user_id: user_id,
                is_dependant: is_dependant

            },
            function (data, status) {
                if (status == 'success') {
                    console.log(data);
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