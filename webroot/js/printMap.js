$(function () {
    $('.ajax').click('click', function () {
        var values = $(this);
        var lat = values.attr('latitude');
        var lng = values.attr('longitude');
        //alert("latitude = " + lat + "longitude = " + lng);


       /* if (mymap != undefined || mymap != null) {
            mymap.off();
            mymap.remove();
            mymap._resetView();
        }*/

        document.getElementById('map-container').innerHTML = "<div id='mapid' style=\"height: 300px; border: 1px solid green;\"></div>";

        $('#myModal').on('shown.bs.modal', function () {
            setTimeout(function () {
                mymap.invalidateSize();
            }, 1);
        })

        var mymap = new L.map('mapid');
        mymap.setView([lat, lng], 18, {
            "animate": true,
            "pan": {
                "duration": 10
            }
        });


        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: ''
        }).addTo(mymap);

        L.marker([lat, lng])
            .addTo(mymap)
            .bindPopup("<b>Latitude : </b>" + lat + "<br />" + "<b>Longitude : </b>" + lng);


    });
});