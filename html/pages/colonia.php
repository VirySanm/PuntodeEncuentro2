<?php 
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Ejemplo de un mapa muy simple y geolocalización - Google API v3</title>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <script src="../js/jquery-1.10.1.js"></script>
<script type="text/javascript">
var geocoder;
/*var map;
var infowindow = new google.maps.InfoWindow();
var marker = new google.maps.Marker();
 
function closeInfoWindow() {
        infowindow.close();
   }

function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(19.4456375, -99.119641);
  var mapOptions = {
    zoom: 8,
    center: latlng,
    mapTypeId: 'roadmap'
  }
  map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
 
  google.maps.event.addListener(map, 'click', function(){
            closeInfoWindow();
          });
}
 */
function codeLatLng() {

  geocoder = new google.maps.Geocoder();
  var input = $('#latlng').val();
  var latlngStr = input.split(',', 2);
  var lat = parseFloat(latlngStr[0]);
  var lng = parseFloat(latlngStr[1]);
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({'latLng': latlng}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[0]) {
       // map.fitBounds(results[0].geometry.viewport);
               // marker.setMap(map);
               // marker.setPosition(latlng);
                direc=results[0].formatted_address;
                dir=direc.split(",");
                tam=dir.length;
                alert(tam);
                if(tam==6)
                    $('#address').text("Col. "+dir[1]+", "+dir[2]+","+dir[3]+","+dir[4]+","+dir[5]);
                  else
                    $('#address').text("Col. "+dir[1]+", "+dir[2]+","+dir[3]+","+dir[4]);
        $('#address2').text(results[0].formatted_address);
        //infowindow.setContent(results[0].formatted_address);
       // infowindow.open(map, marker);
        //google.maps.event.addListener(marker, 'click', function(){
         //   infowindow.setContent(results[0].formatted_address);
          //  infowindow.open(map, marker);
        //});
      } else {
        alert('No results found');
      }
    } else {
      alert('Geocoder failed due to: ' + status);
    }
  });
}
 
$(document).ready(function(){
	codeLatLng();
});
</script>
</head>
<body>
<div>
   <input id="latlng" type="textbox" value="19.44598689999998, -99.1196653">
</div>
<div>
   <input type="button" value="Reverse Geocode" onclick="codeLatLng()">
</div>
<table class="width2">
   <tr><td class="unitx1"><strong>Dirección:</strong></td><td><div id="address"></div><br><div id="address2"></div></td></tr>
</table>
<div id="map_canvas" style="width: 990px; height: 500px"></div>
</body>
</html> 