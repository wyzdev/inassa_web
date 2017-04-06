$(function () {
    $('#role').change(function () {
        if($("#role").val() == "medecin") {
            document.getElementById('hospital_field').value="";
            $("#hospital_field").show(200, function () {
            });
        }
        else {
            $("#hospital_field").hide(200, function () {
                document.getElementById('hospital_field').value = "INASSA";
            });
        }
    });
});