<?php
//direccion a buscar
$direccion= urlencode('panaderos 115,col morelos,df');
 
//Buscamos la direccion en el servicio de google
 $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$direccion.'&sensor=false');
 
 //decodificamos lo que devuelve google, que esta en formato json
 $output= json_decode($geocode);
 
//Extraemos la informacion que nos interesa
 $lat = $output->results[0]->geometry->location->lat;
 $long = $output->results[0]->geometry->location->lng;
 
//la imprimimos
 echo $lat.', '.$long;
?>
