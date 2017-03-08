<?php
$lat = 18.5407074;
$lng = -72.319546;
$json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng);

$obj = json_decode($json);
echo $json;
if ($obj->status == 'OK')
    echo $obj->results[0]->formatted_address;
else
    echo "Il y a quelque chose qui ne va pas.";
?>