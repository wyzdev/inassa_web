$(document).ready(function(){
    $(".client_row").click(function(){
        $("#table_client").hide();


        	document.getElementById('display_client_info').innerHTML = '<span class="indicatif">Client</span><span class="deux-point">:</span><span class="result">' + $(this).attr("firstname") + ' ' + $(this).attr("lastname") + '</span><br/><span class="indicatif">Date de naissance</span><span class="deux-point">:</span><span class="result">' + $(this).attr("dob") + '</span>';

            if ($('#role_user').attr('role') != 'medecin'){
        	   document.getElementById('link_to_historic').innerHTML = "<a href=\""+  window.location.protocol+"//"+window.location.host + "/" + location.pathname.split('/')[1] + "/logs/historique?first_name="+  $(this).attr("firstname").replace(' ', "%20") +"&last_name="+  $(this).attr("lastname").replace(' ', "%20") +"&dob="+ $(this).attr("dob_search").substring(0,10) +"\">Voir l\'historique de ce client</a>";
            }


        if ($(this).attr("status") == '1'){

        	document.getElementById('display_client_status').innerHTML = "<span class=\"status_active\">Client Actif</span>";

        	$("#display_client").show();
        }
        else{
        	
        	document.getElementById('display_client_status').innerHTML = "<span class=\"status_inactive\">Client inactif</span>";
        }


        $("#display_client").show();
    });


    $(".btn-blue").click(function(){
        $("#table_client").hide();
        $("#display_client").hide();
        $(".btn-blue").hide();
        $("#client_not_exist").hide();

        document.getElementsByName("first_name")[0].value = "" ;
        document.getElementsByName("last_name")[0].value = "" ;
        document.getElementsByName("dob")[0].value = "" ;
    });
});