<?php 
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
$avatar=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_SESSION["iduser"]);
echo $obtenerlatlongAll=obtenerlatlongAll($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
echo $tam=sizeof($obtenerlatlongAll);
echo $nombreusers=nombreusus($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduser"]);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Ejemplo de un mapa muy simple y geolocalización - Google API v3</title>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
var map; //importante definirla fuera de la funcion initialize() para poderla usar desde otras funciones.
 /*
 function initialize() {
   var punto = new google.maps.LatLng(19.396853,-99.049846); //ubicación del Plaza Central de Tikal, Guatemala
   var myOptions = {
     zoom: 5, //nivel de zoom para poder ver de cerca.
     center: punto,
     mapTypeId: google.maps.MapTypeId.ROADMAP //Tipo de mapa inicial, satélite para ver las pirámides
   }
     map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

   var marker=new google.maps.Marker({
     position:punto,
     });

   marker.setMap(map);
 }
  */
 //copiamos la función de geolocalización del ejemplo anterior.
  
 function pedirPosicion(pos) {
   var centro = new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude);
    //map.setCenter(centro); //pedimos que centre el mapa..
   //map.setZoom(18);//pedimos que centre el mapa..
   var myOptions = {
     zoom: 18, //nivel de zoom para poder ver de cerca.
     center: centro,
     mapTypeId: google.maps.MapTypeId.ROADMAP //Tipo de mapa inicial,callejero
   }
   
     map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
   
  // map.setMapTypeId(google.maps.MapTypeId.ROADMAP); //y lo volvemos un mapa callejero

   var marker=new google.maps.Marker({
     position:centro,
     });
  
   marker.setMap(map);
   var infowindow = new google.maps.InfoWindow({
		  content:"<span class='avatar avatar-online' id='estatususerubi'><img src='<?php echo $avatar?>' alt='...'><i></i></span>&nbsp;&nbsp;<?php echo $_SESSION["user"]?>"
	     //content:"hola"
	     });

	    infowindow.open(map,marker);
	   
   
   tam='<?php echo $tam?>';
   alert(tam);
   for(i=0;i<tam;i++)	   
   {
	   alert(i);
	 ubicacion='<?php echo $obtenerlatlongAll?>';
	 alert(ubicacion);
	 ubicacionsep=ubicacion.split(",");  
	 var user="user"+i;
	 
     user= new google.maps.LatLng(ubicacionsep[2],ubicacionsep[3]);

     var markerusu="markerusu"+i;
     markerusu=new google.maps.Marker({
	     position:user,
	     icon:"../icons/location.png",
	     });
   
     markerusu.setMap(map); 
     
     //var infowindow="infowindow"+i; 
   /*  infowindow= new google.maps.InfoWindow({
		  content:"<span class='avatar avatar-online' id='estatususerubi'><img src='<?php //echo ubicacionsep[1]?>' alt='...'><i></i></span>&nbsp;&nbsp;<?php //echo ubicacionsep[0]?>"
	     });

	   google.maps.event.addListener(markerusu, 'click', function() {
	     infowindow.open(map,markerusu);
	     });*/
   }  
}
 
function geolocalizame(){
navigator.geolocation.getCurrentPosition(pedirPosicion);
 }
  
  
</script>
</head>
<body onload="geolocalizame()">
 <div id="map_canvas" style="width:640px ;height:480px"></div>
 <!-- a href="#" onclick="geolocalizame()">Ahora llevame a mi ubicación</a-->
</body>
</html> 