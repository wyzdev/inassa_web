$(function () {
    $('#role').change(function () {
        if($("#role").val() == "medecin")
            $("#hospital_field").show(200, function () {
                
            });
        else
            $("#hospital_field").hide(200, function () {
                
            });


    });
});