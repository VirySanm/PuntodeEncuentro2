<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
$datosPerfil=datosPerfil($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $_SESSION["iduser"]);
 $avatar=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_SESSION["iduser"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Slider to change fusiontable maps layers</title>
  <link
 href="https://code.google.com/apis/maps/documentation/javascript/examples/default.css"
 rel="stylesheet" type="text/css" />
  <script type="text/javascript"
 src="https://maps.google.com/maps/api/js?sensor=false"></script>
  <script
 src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="http://piotrkrosniak.github.io/simple-slider.js"></script>
  <link href="http://piotrkrosniak.github.io/simple-slider.css" rel="stylesheet"
 type="text/css" />
  <link href="http://piotrkrosniak.github.io/simple-slider-volume.css" rel="stylesheet"
 type="text/css" />

  <script type="text/javascript">
  var map;
  var markeres= []; 
function initialize() {
     
  //var edad='<?php echo $datosPerfil[9]?>';
  
  var myLatLng = new google.maps.LatLng(19.4460481, -99.1196811);
	map = new google.maps.Map(document.getElementById('map_canvas'), {
    center: myLatLng,
    zoom: 14,
	panControl: false,
  	zoomControl: true,
	zoomControlOptions: {
    position: google.maps.ControlPosition.LEFT_CENTER
    },
  	mapTypeControl: false,
      mapTypeId: 'roadmap'
    });

   <?php 
     $avatar=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_SESSION["iduser"]);
     $obtenerlatlongAll=obtenerlatlongAll($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
     $tam=substr_count($obtenerlatlongAll,"&");
      
    ?> 
      tam='<?php echo $tam?>';
      
       ubicacion='<?php echo $obtenerlatlongAll?>';
       ubicacions=ubicacion.split("&");
      // alert("u: "+ubicacion);
      for(var i=0;i<tam;i++) 
      {
       ubicacionsep=ubicacions[i].split(","); 

       tim=ubicacionsep[5].split(" ");
      if(tim[1]=="min")
      {              
         if(tim[0]<60){
            estus="online";
         }
         if(tim[0]>=60 && tim[0]<120){
             estus="away";
         }
         if(tim[0]>=120 && tim[0]<150){
           estus="busy";
         }
         if(tim[0]>=150){
           estus="off";
         }
      }
      else
      {
      estus="off";
      }
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(ubicacionsep[2],ubicacionsep[3]),
            title:"<span class='avatar avatar-"+estus+"' title='"+ubicacionsep[0]+"' style='height:40px;width:40px'><a href='profileExt.php?iduser="+ubicacionsep[8]+"'><img src='"+ubicacionsep[1]+"' style='height:40px;width:40px'></a><i></i></span><br>A: "+ubicacionsep[4]+" Km",
            icon:"../icons/location.png"
        });
         marker.setMap(map);

         markeres.push(marker);

       var infowindo = new google.maps.InfoWindow({
          content:"<span class='avatar avatar-"+estus+"' title='"+ubicacionsep[0]+"' style='height:40px;width:40px'><a href='profileExt.php?iduser="+ubicacionsep[8]+"'><img src='"+ubicacionsep[1]+"' style='height:40px;width:40px'></a><i></i></span><br>A: "+ubicacionsep[4]+" Km", 
         });

        infowindo.open(map,marker);

        google.maps.event.addListener(marker, 'click', function(){
            var popup = new google.maps.InfoWindow();
            var note = this.title;
            popup.setContent(note);
            popup.open(map, this);
        });
    }
    ////// mi ubicacion

       var markeri=new google.maps.Marker({
         position:myLatLng,
         });
      
       markeri.setMap(map);
       var infowindoi = new google.maps.InfoWindow({
          content:"<span class='avatar avatar-online' id='estatususerubi' title='<?php echo $_SESSION["user"]?>' style='height:40px;width:40px'><img src='<?php echo $avatar?>' style='height:40px;width:40px'><i></i></span>"  
         });
       
        infowindoi.open(map,markeri);

       google.maps.event.addListener(markeri, 'click', function() {
         infowindoi.open(map,markeri);
       });
  } 

  function cambio(km){
//alert("km:"+ km);
  sex="Hombre";
  
  $.ajax({
        url:'../includes/consultas.php',
        type: 'POST'
        ,dataType: 'html'
        ,data: {num:14,km:km,edad:edad,sex:sex}
        ,success: function(data, textStatus, xhr) {
         if (xhr.status == 200) {    
         // alert(data);
            changeLayer(data);
          }
        }
    });
  }
 function changeLayer(data)
  {
   borrar();
   var myLatLng = new google.maps.LatLng(19.4460481, -99.1196811);
  map = new google.maps.Map(document.getElementById('map_canvas'), {
    center: myLatLng,
    zoom: 14,
  panControl: false,
    zoomControl: true,
  zoomControlOptions: {
    position: google.maps.ControlPosition.LEFT_CENTER
    },
    mapTypeControl: false,
      mapTypeId: 'roadmap'
    });
    datos=data.split("/-/");
    
    tam=datos[1];

   //alert(datos[0]);
   //alert(datos[1]);
      
       ubicacion=datos[0];
       ubicacions=ubicacion.split("&");
     //  alert("u: "+ubicacion);
      for(var i=0;i<tam;i++) 
      {
       ubicacionsep=ubicacions[i].split(","); 

       tim=ubicacionsep[5].split(" ");
      if(tim[1]=="min")
      {              
         if(tim[0]<60){
            estus="online";
         }
         if(tim[0]>=60 && tim[0]<120){
             estus="away";
         }
         if(tim[0]>=120 && tim[0]<150){
           estus="busy";
         }
         if(tim[0]>=150){
           estus="off";
         }
      }
      else
      {
      estus="off";
      }
            var marker = new google.maps.Marker({
            position: new google.maps.LatLng(ubicacionsep[2],ubicacionsep[3]),
            title:"<span class='avatar avatar-"+estus+"' title='"+ubicacionsep[0]+"' style='height:40px;width:40px'><a href='profileExt.php?iduser="+ubicacionsep[8]+"'><img src='"+ubicacionsep[1]+"' style='height:40px;width:40px'></a><i></i></span><br>A: "+ubicacionsep[4]+" Km",
            icon:"../icons/location.png"
        });
         marker.setMap(map);

         markeres.push(marker);
         
       var infowindo = new google.maps.InfoWindow({
          content:"<span class='avatar avatar-"+estus+"' title='"+ubicacionsep[0]+"' style='height:40px;width:40px'><a href='profileExt.php?iduser="+ubicacionsep[8]+"'><img src='"+ubicacionsep[1]+"' style='height:40px;width:40px'></a><i></i></span><br>A: "+ubicacionsep[4]+" Km", 
         });

        infowindo.open(map,marker);

        google.maps.event.addListener(marker, 'click', function(){
            var popup = new google.maps.InfoWindow();
            var note = this.title;
            popup.setContent(note);
            popup.open(map, this);
        });
    }
    ////// mi ubicacion

       var markeri=new google.maps.Marker({
         position:myLatLng,
         });
      
       markeri.setMap(map);
       var infowindoi = new google.maps.InfoWindow({
          content:"<span class='avatar avatar-online' id='estatususerubi' title='<?php echo $_SESSION["user"]?>' style='height:40px;width:40px'><img src='<?php echo $avatar?>' style='height:40px;width:40px'><i></i></span>"  
         });
       
        infowindoi.open(map,markeri);

       google.maps.event.addListener(markeri, 'click', function() {
         infowindoi.open(map,markeri);
       });
    
}

function borrar()
{
   for (var i = 0; i < markeres.length; i++) {
        markeres[i].setMap(null);
    };
    markeres= [];
}
</script>
  
</head>
<body >
<div id="header-wrapper">

<div id="map_canvas" class="container"
 style="width: 1200px; height: 400px;"></div>
<div id="slider" class="container">
<h3>Distancia</h3>
<input id="sli" data-slider="true"  value="<?php echo $datosPerfil[9]?>" data-slider-values="1,2,3,4,5,6,7,8,9,10"
 data-slider-highlight="true" data-slider-nap="true" type="text" />
<br><br>
 <h3>Edad</h3>
18&nbsp;<input id="sli2" data-slider="true" value="<?php echo $datosPerfil[10]?>" data-slider-values="18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55"
 data-slider-highlight="true" data-slider-snap="true" type="text" />&nbsp;55
 <br><br>
 </div>
</div>

<script>

$("#sli")
.each(function () {
var input = $(this);
$("<span id='slii1'>")
.addClass("output")
.insertAfter($(this));
})
.bind("slider:ready slider:changed", function (event, data) {
$(this)
.nextAll("#slii1:first")
.html(data.value.toFixed(0));
km = data.value.toFixed(0);
edad = $("#sli2").val();
cambio(km,edad);
});

$("#sli2")
.each(function () {
var input = $(this);
$("<span id='slii2'>")
.addClass("output")
.insertAfter($(this));
})
.bind("slider:ready slider:changed", function (event, data) {
$(this)
.nextAll("#slii2:first")
.html(data.value.toFixed(0));
edad = data.value.toFixed(0);
km = $("#sli").val();
cambio(km,edad);
});
</script>
</div>

</body>
</html>
