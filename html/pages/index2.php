<?php
   session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
if(!isset($_COOKIE['Erecor']) && $_COOKIE['Erecor']=="no"){
	$mail=$_COOKIE['Email'];
	$pass=$_COOKIE['Epass'];
	$sel="";
}
else{
	$mail=$_COOKIE['Email'];
	$pass=$_COOKIE['Epass'];
	$sel="checked";
	$dat=pasedirecto($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$mail,$pass);
	$_SESSION["iduser"]=$dat[0];
	$_SESSION["user"]=$dat[1];
}
$avatar=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_SESSION["iduser"]);
$portada=portada($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_SESSION["iduser"]);
$datosPerfil=datosPerfil($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $_SESSION["iduser"]);
$latlog=obtenerlatlong($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
$noti=notificaciones($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
$not=explode(";",$noti);

$tamnot=substr_count($not[1],"&");
?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">

  <title>Punto de Encuentro</title>

  <link rel="apple-touch-icon" href="../../assets/images/apple-touch-icon.png">
  <link rel="shortcut icon" href="../../assets/images/favicon.ico">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap-extend.min.css">
  <link rel="stylesheet" href="../../assets/css/site.min.css">

  <link rel="stylesheet" href="../../assets/examples/css/pages/map.css">

  <!-- Plugins -->
  <link rel="stylesheet" href="../../assets/vendor/animsition/animsition.css">
  <link rel="stylesheet" href="../../assets/vendor/asscrollable/asScrollable.css">
  <link rel="stylesheet" href="../../assets/vendor/switchery/switchery.css">
  <link rel="stylesheet" href="../../assets/vendor/intro-js/introjs.css">
  <link rel="stylesheet" href="../../assets/vendor/slidepanel/slidePanel.css">
  <link rel="stylesheet" href="../../assets/vendor/flag-icon-css/flag-icon.css">

  <!-- Plugins For This Page -->
  <link rel="stylesheet" href="../../assets/vendor/chartist-js/chartist.css">
  <link rel="stylesheet" href="../../assets/vendor/aspieprogress/asPieProgress.css">

  <!-- Page -->
  <link rel="stylesheet" href="../../assets/css/dashboard/v2.css">

  <!-- Fonts -->
  <link rel="stylesheet" href="../../assets/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="../../assets/fonts/brand-icons/brand-icons.min.css">


  <!--[if lt IE 9]>
    <script src="../../assets/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->

  <!--[if lt IE 10]>
    <script src="../../assets/vendor/media-match/media.match.min.js"></script>
    <script src="../../assets/vendor/respond/respond.min.js"></script>
    <![endif]-->

  <!-- Scripts -->
  <script src="../../assets/vendor/modernizr/modernizr.js"></script>
  <script src="../../assets/vendor/breakpoints/breakpoints.js"></script>
  <script src="../js/jquery-1.10.1.js"></script>
  <script src="../js/java.js"></script>
  <script src="../js/ajaxupload.min.js"></script>

  <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
   
  <script>
    Breakpoints();
 
    $(document).ready(function(){
      sel='<?php echo $sel?>';
     if(sel!="")
     {
    	   pe=$("#pendnotis").val();
    	   if(pe!=0)
    	   {
    		  $("#numnotis").html('<i class="icon wb-bell" aria-hidden="true"></i><span class="badge badge-danger up">'+pe+'</span>');
    	   }
    	   else{
    	   	  $("#numnotis").html('<i class="icon wb-bell" aria-hidden="true"></i><span class="badge badge-danger up"></span>');
    	   }
          //codeLatLng();
          actnews();  
          geolocalizame();     
          cronosession();
    	    //////////////crono session usuario//////////////////////
    	    var crono;
    	    function cronosession()
    	    {
			      contador=5;
    	      crono = setInterval(
    	          function(){
    	            if(contador>0) {

    	              $("#crono").val(contador);
    	              contador--;
    	            }
    	            else{
    	                $.ajax({
    	                  url:'../includes/consultas.php',
    	                  type: 'POST'
    	                  ,dataType: 'html'
    	                  ,data:({num:9})
    	                  ,success: function(data, textStatus, xhr){
    	                    //alert(data);
    	                    if (xhr.status == 200) {
    	                   
    	                    	dato=data.split(" ");
    	                   
	   	                      if(dato[1]=="min")
	   	                      {
		   	                   dato[0]=dato[0]*60;
		   	                
	                            if(dato[0]<60){
	                               $("#estatususer").attr("class","avatar avatar-online");
	                            }
	                            if(dato[0]>=60 && dato[0]<120){
	                               $("#estatususer").attr("class","avatar avatar-away");
	                            }
	                            if(dato[0]>=120 && dato[0]<150){
	                               $("#estatususer").attr("class","avatar avatar-busy");
	                            }
	                            if(dato[0]>=150){
	                               $("#estatususer").attr("class","avatar avatar-off");
	                            }
	   	                      }
	                          else{
		                          if(data!="Hace un momento")
	                          	     $("#estatususer").attr("class","avatar avatar-off");
		                          else
		                        	  $("#estatususer").attr("class","avatar avatar-online");
	                          }
    	                      }
    	                    }
    	                });
    	                contador=5;
    	              }
    	          }
    	          ,1000);
    	    }

    }
     else
     {
      alert("Su session ha caducado, Ingrese de nuevo Por favor.");
      document.location.href="login.php"; 
     } 

  });
   	/*
    $(function() {
      // Botón para subir las fotos
      //alert("hola");
      var btn_firma = $('#addImg'), interval;
      new AjaxUpload('#addImg', {
        action: 'uploadFilePor.php',
        onSubmit : function(file , ext){
          if (! (ext && /^(jpg|png)$/.test(ext))){
            // extensiones permitidas
            alert('Sólo se permiten Imagenes .jpg o .png');
            // cancela upload
            return false;
          } else {
            $('#addImg').attr('src','../orden/img/loader.gif');
            // $('#loaderAjax').show();
            //btn_firma.text('Espere por favor');
            //this.disable();
          }
        },
        onComplete: function(file, response){

          respuesta = $.parseJSON(response);

          if(respuesta.respuesta == 'done'){
             // alert(respuesta.fileName);
            $.ajax({
              url:'guardaportada.php',
              type: 'POST'
              ,dataType: 'html'
              ,data: {portada:respuesta.fileName}
              ,success: function(data, textStatus, xhr){
                if(xhr.status==200){
                   // alert(data);
                  document.location.href="index.php";
                }
              }
            });

          }
          else{
            alert(respuesta.mensaje);
            $('#fotografi').attr('src','<?php //echo $portada?>');
          }

        }
      });
    });*/

     var map;
     function pedirPosicion(pos) {
         <?php 

         $avatar=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_SESSION["iduser"]);
         $obtenerlatlongAll=obtenerlatlongAll($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
         $tam=substr_count($obtenerlatlongAll,"&");
          
         ?>
     var centro = new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude);
     
       var myOptions = {
         zoom: 14, //nivel de zoom para poder ver de cerca.
         center: centro,
         mapTypeId: google.maps.MapTypeId.ROADMAP //Tipo de mapa inicial,callejero
       }
       
     map = new google.maps.Map(document.getElementById("gmap"), myOptions);    
      // map.setMapTypeId(google.maps.MapTypeId.ROADMAP); //y lo volvemos un mapa callejero

       var marker=new google.maps.Marker({
         position:centro,
         });
      
       marker.setMap(map);
       var infowindo = new google.maps.InfoWindow({
          content:"<span class='avatar avatar-online' id='estatususerubi' title='<?php echo $_SESSION["user"]?>' style='height:40px;width:40px'><img src='<?php echo $avatar?>' style='height:40px;width:40px'><i></i></span>"  
         });
       
        infowindo.open(map,marker);
     google.maps.event.addListener(marker, 'click', function() {
        infowindo.open(map,marker);
        });
       

       tam='<?php echo $tam?>';
      
       ubicacion='<?php echo $obtenerlatlongAll?>';
       
       ubicacions=ubicacion.split("&");
       for(i=0;i<tam;i++)    
       {
      
       ubicacionsep=ubicacions[i].split(",");  
       var user="user"+i;
       
         user= new google.maps.LatLng(ubicacionsep[2],ubicacionsep[3]);
        
         var markerusu="markerusu"+i;
         markerusu=new google.maps.Marker({
           position:user,
           icon:"../icons/location.png",
           });
       
         markerusu.setMap(map);
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
         var infowindow="infowindow"+i; 
         infowindow= new google.maps.InfoWindow({
            content:"<span class='avatar avatar-"+estus+"' title='"+ubicacionsep[0]+"' style='height:40px;width:40px'><a href='profileExt.php?iduser="+ubicacionsep[8]+"'><img src='"+ubicacionsep[1]+"' style='height:40px;width:40px'></a><i></i></span><br>A: "+ubicacionsep[4]+" Km"
           });

           infowindow.open(map,markerusu);
           
        google.maps.event.addListener(markerusu, 'click', function() {
          infowindow.open(map,markerusu);
          });
       }  
/*
    var myCity = new google.maps.Circle({
      center:centro,
      radius:2000,
      strokeColor:"#0000FF",
      strokeOpacity:0.8,
      strokeWeight:2,
      fillColor:"#0000FF",
      fillOpacity:0.4,
      });

    myCity.setMap(map);
   */
   
}
     
     function geolocalizame(){
       navigator.geolocation.getCurrentPosition(pedirPosicion);
     }
     
    
    /*function codeLatLng() {
    	  geocoder = new google.maps.Geocoder();
    	  var lat = parseFloat(<?php echo $latlog[1]?>);
    	  var lng = parseFloat(<?php echo $latlog[2]?>);
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
    	                if(tam==6)
    	                    $('#address').text("Col. "+dir[1]+", "+dir[2]+","+dir[3]+","+dir[4]+","+dir[5]);
    	                  else
    	                    $('#address').text("Col. "+dir[1]+", "+dir[2]+","+dir[3]+","+dir[4]);
    	                direccion="Col. "+dir[1]+", "+dir[2]+","+dir[3]+","+dir[4];
    	        $.ajax({
    	            url:'../includes/consultas.php',
    	            type: 'POST'
    	            ,dataType: 'html'
    	            ,data:({num:15,direccion:direccion})
    	            ,success: function(data, textStatus, xhr){
    	              if (xhr.status == 200) {
    	              }
    	            }
    	        });
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
*/
  /// actualizar Notificaciones
      var news=1;
      function actnews(){ 
         
          if(news>0){
          	news--;
              //$("#contis").val(news);
              setTimeout('actnews()',1000);
         }else{
      	   news=1; 
             notispend(); 
             actnews();
          }
      }

     // mostrar notificaciones nuevas
     function notispend(){
  	   pe=$("#pendnotis").val();
  	   $.ajax({
  	      url:'../includes/consultas.php',
  	      type: 'POST'
  	      ,dataType: 'html'
  	      ,data: {num:17} 
  	      ,success: function(data, textStatus, xhr){
  	      if(xhr.status==200){  
  	         dato=data.split(";");
  	         newss=dato[0]-pe;
  	         if(newss>0)
  	         {  
  	           if(pe<dato[0])
  	           {
  	              $('<audio id="audio_not" src="../sonidos/whatsapp.mp3" preload="auto" ></audio>').appendTo("body"); 
  	              $('#audio_not')[0].play(); 
  	              $("#pendnotis").val(dato[0]);
  				  $("#numnotis").html('<i class="icon wb-bell" aria-hidden="true"></i><span class="badge badge-danger up">'+dato[0]+'</span>');
  				  $.ajax({
  		              url:'notificaciones.php',
  		              type: 'POST'
  		              ,dataType: 'html'
  		              ,data:({})
  		              ,success: function(data, textStatus, xhr){
  		                 if (xhr.status == 200) {
  		                	 $("#notifi").html(data);
  		                 }
  		              }
  				  });
  	           }	           
  	         } 
  	         else
  	         { 
  		       if(pe<=0)
  		       {    
  			     $("#numnotis").html('<i class="icon wb-bell" aria-hidden="true"></i><span class="badge badge-danger up"></span>');
  		       }
  		       else
  		       {
  		    	 $("#numnotis").html('<i class="icon wb-bell" aria-hidden="true"></i><span class="badge badge-danger up">'+dato[0]+'</span>');
  		    	 $("#pendnotis").val(dato[0]);
  		       }  
  	        }
  	       }
  	     }
  	  }); 
    }
  </script>
  
  <!--link href="../css/bootstrap-slider.css" rel="stylesheet">
    <style type='text/css'>
		/* Example 1 custom styles */
		#ex1Slider .slider-selection {
   			background: #BABABA;
  		}

    </style-->
</head>
<body class="dashboard"><!--oad="geolocalizame()"-->
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

  <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided"
      data-toggle="menubar">
        <span class="sr-only">Toggle navigation</span>
        <span class="hamburger-bar"></span>
      </button>
      <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse"
      data-toggle="collapse">
        <i class="icon wb-more-horizontal" aria-hidden="true"></i>
      </button>
      <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-search"
      data-toggle="collapse">
        <span class="sr-only">Toggle Search</span>
        <i class="icon wb-search" aria-hidden="true"></i>
      </button>
      <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
        <img class="navbar-brand-logo" src="../../assets/images/logo.png" title="Punto de Encuentro">
        <span class="navbar-brand-text">Punto de Encuentro</span>
      </div>
    </div>

    <div class="navbar-container container-fluid">
      <!-- Navbar Collapse -->
      <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
        <!-- Navbar Toolbar -->
        <ul class="nav navbar-toolbar">
          <li class="hidden-float" id="toggleMenubar">
            <a data-toggle="menubar" href="#" role="button">
              <i class="icon hamburger hamburger-arrow-left">
                  <span class="sr-only">Toggle menubar</span>
                  <span class="hamburger-bar"></span>
                </i>
            </a>
          </li>
          <li class="hidden-xs" id="toggleFullscreen">
            <a class="icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
              <span class="sr-only">Toggle fullscreen</span>
            </a>
          </li>
          <!--li class="hidden-float">
            <a class="icon wb-search" data-toggle="collapse" href="#site-navbar-search" role="button">
              <span class="sr-only">Toggle Search</span>
            </a>
          </li-->
          <li class="dropdown dropdown-fw dropdown-mega">
          <ul class="dropdown-menu" role="menu">
            <li role="presentation">
                <div class="mega-content">
                  <div class="row">
                    <div class="col-sm-4">
                      <h5>UI Kit</h5>
                      <ul class="blocks-2">
                        <li class="mega-menu margin-0">
                          <ul class="list-icons">
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="advanced/animation.html">Animation</a>
                            </li>
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="uikit/buttons.html">Buttons</a>
                            </li>
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="uikit/colors.html">Colors</a>
                            </li>
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="uikit/dropdowns.html">Dropdowns</a>
                            </li>
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="uikit/icons.html">Icons</a>
                            </li>
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="advanced/lightbox.html">Lightbox</a>
                            </li>
                          </ul>
                        </li>
                        <li class="mega-menu margin-0">
                          <ul class="list-icons">
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="uikit/modals.html">Modals</a>
                            </li>
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="uikit/panels.html">Panels</a>
                            </li>
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="structure/overlay.html">Overlay</a>
                            </li>
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="uikit/tooltip-popover.html ">Tooltips</a>
                            </li>
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="advanced/scrollable.html">Scrollable</a>
                            </li>
                            <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                              <a
                              href="uikit/typography.html">Typography</a>
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                    <div class="col-sm-4">
                      <h5>Media
                        <span class="badge badge-success">4</span>
                      </h5>
                      <ul class="blocks-3">
                        <li>
                          <a class="thumbnail margin-0" href="javascript:void(0)">
                            <img class="width-full" src="../../assets/photos/placeholder.png" alt="..." />
                          </a>
                        </li>
                        <li>
                          <a class="thumbnail margin-0" href="javascript:void(0)">
                            <img class="width-full" src="../../assets/photos/placeholder.png" alt="..." />
                          </a>
                        </li>
                        <li>
                          <a class="thumbnail margin-0" href="javascript:void(0)">
                            <img class="width-full" src="../../assets/photos/placeholder.png" alt="..." />
                          </a>
                        </li>
                        <li>
                          <a class="thumbnail margin-0" href="javascript:void(0)">
                            <img class="width-full" src="../../assets/photos/placeholder.png" alt="..." />
                          </a>
                        </li>
                        <li>
                          <a class="thumbnail margin-0" href="javascript:void(0)">
                            <img class="width-full" src="../../assets/photos/placeholder.png" alt="..." />
                          </a>
                        </li>
                        <li>
                          <a class="thumbnail margin-0" href="javascript:void(0)">
                            <img class="width-full" src="../../assets/photos/placeholder.png" alt="..." />
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-sm-4">
                      <h5 class="margin-bottom-0">Accordion</h5>
                      <!-- Accordion -->
                      <div class="panel-group panel-group-simple" id="siteMegaAccordion" aria-multiselectable="true"
                      role="tablist">
                        <div class="panel">
                          <div class="panel-heading" id="siteMegaAccordionHeadingOne" role="tab">
                            <a class="panel-title" data-toggle="collapse" href="#siteMegaCollapseOne" data-parent="#siteMegaAccordion"
                            aria-expanded="false" aria-controls="siteMegaCollapseOne">
                                Collapsible Group Item #1
                              </a>
                          </div>
                          <div class="panel-collapse collapse" id="siteMegaCollapseOne" aria-labelledby="siteMegaAccordionHeadingOne"
                          role="tabpanel">
                            <div class="panel-body">
                              De moveat laudatur vestra parum doloribus labitur sentire partes, eripuit praesenti
                              congressus ostendit alienae, voluptati ornateque
                              accusamus clamat reperietur convicia albucius.
                            </div>
                          </div>
                        </div>
                        <div class="panel">
                          <div class="panel-heading" id="siteMegaAccordionHeadingTwo" role="tab">
                            <a class="panel-title collapsed" data-toggle="collapse" href="#siteMegaCollapseTwo"
                            data-parent="#siteMegaAccordion" aria-expanded="false"
                            aria-controls="siteMegaCollapseTwo">
                                Collapsible Group Item #2
                              </a>
                          </div>
                          <div class="panel-collapse collapse" id="siteMegaCollapseTwo" aria-labelledby="siteMegaAccordionHeadingTwo"
                          role="tabpanel">
                            <div class="panel-body">
                              Praestabiliorem. Pellat excruciant legantur ullum leniter vacare foris voluptate
                              loco ignavi, credo videretur multoque choro fatemur
                              mortis animus adoptionem, bello statuat expediunt
                              naturales.
                            </div>
                          </div>
                        </div>

                        <div class="panel">
                          <div class="panel-heading" id="siteMegaAccordionHeadingThree" role="tab">
                            <a class="panel-title collapsed" data-toggle="collapse" href="#siteMegaCollapseThree"
                            data-parent="#siteMegaAccordion" aria-expanded="false"
                            aria-controls="siteMegaCollapseThree">
                                Collapsible Group Item #3
                              </a>
                          </div>
                          <div class="panel-collapse collapse" id="siteMegaCollapseThree" aria-labelledby="siteMegaAccordionHeadingThree"
                          role="tabpanel">
                            <div class="panel-body">
                              Horum, antiquitate perciperet d conspectum locus obruamus animumque perspici probabis
                              suscipere. Desiderat magnum, contenta poena desiderant
                              concederetur menandri damna disputandum corporum.
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- End Accordion -->
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </li>
        </ul>
        <!-- End Navbar Toolbar -->

        <!-- Navbar Toolbar Right -->
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
          <li class="dropdown">
<ul class="dropdown-menu" role="menu">
            <li role="presentation">
                <a href="javascript:void(0)" role="menuitem">
                  <span class="flag-icon flag-icon-gb"></span> English</a>
              </li>
              <li role="presentation">
                <a href="javascript:void(0)" role="menuitem">
                  <span class="flag-icon flag-icon-fr"></span> French</a>
              </li>
              <li role="presentation">
                <a href="javascript:void(0)" role="menuitem">
                  <span class="flag-icon flag-icon-cn"></span> Chinese</a>
              </li>
              <li role="presentation">
                <a href="javascript:void(0)" role="menuitem">
                  <span class="flag-icon flag-icon-de"></span> German</a>
              </li>
              <li role="presentation">
                <a href="javascript:void(0)" role="menuitem">
                  <span class="flag-icon flag-icon-nl"></span> Dutch</a>
              </li>
            </ul>
          </li>
          <li class="dropdown">
            <a class="navbar-avatar dropdown-toggle" href="profile.php">
              <span class="avatar avatar-online" id="estatususer" style="height:35px;width:35px">
                <img src="<?php echo $avatar ?>" style="height:35px;width:35px">
                <i></i>
              </span>
            </a>
            <!--ul class="dropdown-menu" role="menu">
              <li role="presentation">
                <a href="../html/pages/profile.php" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Profile</a>
              </li>
              <li role="presentation">
                <a href="javascript:void(0)" role="menuitem"><i class="icon wb-payment" aria-hidden="true"></i> Billing</a>
              </li>
              <li role="presentation">
                <a href="javascript:void(0)" role="menuitem"><i class="icon wb-settings" aria-hidden="true"></i> Settings</a>
              </li>
              <li class="divider" role="presentation"></li>
              <li role="presentation">
                <a class="logout" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
              </li>
            </ul-->
          </li>
          <li class="dropdown">
            <a data-toggle="dropdown" href="javascript:void(0)" title="Notificaciones" aria-expanded="false"
            data-animation="scale-up" role="button">
              <div id="numnotis">
              <i class="icon wb-bell" aria-hidden="true"></i>              
                <span class="badge badge-danger up"></span>
               </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
              <li class="dropdown-menu-header" role="presentation">
                <h5>NOTIFICACIONES</h5>
              </li>
             
				<li class="list-group" role="presentation">
                 <div data-role="container">
                  <div data-role="content" id="notifi">
                   <?php 
				$notis=explode("&",$not[1]);
   
  				 for($i=0;$i<$not[0];$i++){
   	
   					$dato=explode(",",$notis[$i]);
   					$avatarusu=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$dato[1]);
  				 	$nombreusers=nombreusus($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$dato[1]);
  				 	if($dato[3]==5 || $dato[3]==6)
  				 		$userr=$dato[5];
  				 	else
  				 		$userr=$dato[1];
  				 
  				 	if($dato[5]==$_SESSION["iduser"])
				      $usus=2;
				    else 
				      $usus=1;
				    
   				$idalbum=vercoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$dato[1],$dato[6]);
   				$verfoto=verfotocoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$idalbum[1]);
   				
   				$confirmarusuado=usuconfir($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$dato[1]);
   				$fechaagregado=fechaagregado($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$dato[1]);
                
			    if(($confirmarusuado==0 && $dato[5]==$_SESSION["iduser"] && ($dato[3]==1 || $dato[3]==6)) || ($confirmarusuado==1 && $fechaagregado <= $dato[7] && $dato[5]==$_SESSION["iduser"]))
			   	{
   	          ?>
                    <a class="list-group-item" id="<?php echo $dato[1].",".$dato[3].",".$usus.",".$dato[4].",".$idalbum[0]?>" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-online" style="height:50px;width:50px">
                            <img src="<?php echo $avatarusu ?>" style="height:50px;width:50px" />
                          </span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading"><?php echo $nombreusers ?></h6>
                          <div class="media-meta">
                            <time datetime="2015-06-17T20:22:05+08:00"><?php echo $dato[2] ?></time>
                          </div>
                          <div class="media-detail"><?php echo $dato[0] ?></div>
                        </div>
                        <?php 
                        if($dato[3]==6){?>
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-online" style="height:50px;width:50px">
                            <img src="<?php echo $verfoto ?>" style="height:50px;width:50px" />
                          </span>
                        </div>
                        <?php }?>
                      </div>
                    </a>
                       <?php 
   				}
  				 }
  				 ?> 
                  </div>
                </div>
              </li>
              
                 <li class="dropdown-menu-footer" role="presentation">
                <a href="profile.php?c=1" style="cursor: pointer">
                    Todas las Notificaciones
                  </a>
              </li>
            </ul>
          </li>
          <!--  
          <li class="dropdown">
            <a data-toggle="dropdown" href="javascript:void(0)" title="Messages" aria-expanded="false"
            data-animation="scale-up" role="button">
              <i class="icon wb-envelope" aria-hidden="true"></i>
              <span class="badge badge-info up">3</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
              <li class="dropdown-menu-header" role="presentation">
                <h5>MESSAGES</h5>
                <span class="label label-round label-info">New 3</span>
              </li>

              <li class="list-group" role="presentation">
                <div data-role="container">
                  <div data-role="content">
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-online">
                            <img src="../../assets/portraits/2.jpg" alt="..." />
                            <i></i>
                          </span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Mary Adams</h6>
                          <div class="media-meta">
                            <time datetime="2015-06-17T20:22:05+08:00">30 minutes ago</time>
                          </div>
                          <div class="media-detail">Anyways, i would like just do it</div>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-off">
                            <img src="../../assets/portraits/3.jpg" alt="..." />
                            <i></i>
                          </span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Caleb Richards</h6>
                          <div class="media-meta">
                            <time datetime="2015-06-17T12:30:30+08:00">12 hours ago</time>
                          </div>
                          <div class="media-detail">I checheck the document. But there seems</div>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-busy">
                            <img src="../../assets/portraits/4.jpg" alt="..." />
                            <i></i>
                          </span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">June Lane</h6>
                          <div class="media-meta">
                            <time datetime="2015-06-16T18:38:40+08:00">2 days ago</time>
                          </div>
                          <div class="media-detail">Lorem ipsum Id consectetur et minim</div>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-away">
                            <img src="../../assets/portraits/5.jpg" alt="..." />
                            <i></i>
                          </span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Edward Fletcher</h6>
                          <div class="media-meta">
                            <time datetime="2015-06-15T20:34:48+08:00">3 days ago</time>
                          </div>
                          <div class="media-detail">Dolor et irure cupidatat commodo nostrud nostrud.</div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </li>
              <li class="dropdown-menu-footer" role="presentation">
                <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                  <i class="icon wb-settings" aria-hidden="true"></i>
                </a>
                <a href="javascript:void(0)" role="menuitem">
                    See all messages
                  </a>
              </li>
            </ul>
          </li>
          <li id="toggleChat">
            <a data-toggle="site-sidebar" href="javascript:void(0)" title="Chat" data-url="../site-sidebar.tpl">
              <i class="icon wb-chat" aria-hidden="true"></i>
            </a>
          </li>-->
        </ul>
        <!-- End Navbar Toolbar Right -->
      </div>
      <!-- End Navbar Collapse -->

      <!-- Site Navbar Seach -->
      <div class="collapse navbar-search-overlap" id="site-navbar-search">
        <form role="search">
          <div class="form-group">
            <div class="input-search">
              <i class="input-search-icon wb-search" aria-hidden="true"></i>
              <input type="text" class="form-control" name="site-search" placeholder="Search...">
              <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search"
              data-toggle="collapse" aria-label="Close"></button>
            </div>
          </div>
        </form>
      </div>
      <!-- End Site Navbar Seach -->
    </div>
  </nav>
  <div class="site-menubar">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu">
            <li class="site-menu-category">General</li>
            <li class="site-menu-item has-sub active open">
              <a href="javascript:void(0)" data-slug="dashboard">
                <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                <span class="site-menu-title">Encuentra</span>
                <div class="site-menu-badge">
                  <span class="badge badge-success"></span>
                </div>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item active">
                  <a class="animsition-link" href="index.php" data-slug="dashboard">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Dashboard</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="user.php?order=1&nom=&pag=0" data-slug="profile">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Revista</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="profile.php?c=0" data-slug="profile">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Perfil</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="gallery.php?idalbum=1" data-slug="profile">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Fotos</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="map-google.php" data-slug="">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Cerca de mi</span>
                  </a>
                </li>              
                <li class="site-menu-item">
                  <a class="animsition-link" href="preferencias.php" data-slug="">
                   <i class="site-menu-icon " aria-hidden="true"></i>
                   <span class="site-menu-title">Preferencias</span>
                 </a> 
                </li> 
            </ul>
          <li class="site-menu-item"></li>
          </ul>

          <!--div class="site-menubar-section">
           <h5>
            Distancia
            <?php 
           /* if($datosPerfil[9]=="")
              $km=3;
            else 
              $km=$datosPerfil[9];	
            if($datosPerfil[10]=="")
              $edad=3;
            else 
              $edad=$datosPerfil[10];*/
          ?>
            <span class="pull-right"><div id="km"><?php //echo $km ?></div></span>
          </h5>
          	<input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="1" data-slider-max="10" data-slider-step="1" data-slider-value="<?php //echo $km ?>"/>
		  <h5>
            Edad
            <span class="pull-right"><div id="age">18-<?php //echo $edad ?></div></span>
          </h5>
               <input id="ex2" data-slider-id='ex1Slider' type="text" data-slider-min="18" data-slider-max="55" data-slider-step="5" data-slider-value="<?php //echo $edad ?>"/>
         </div-->
        </div>
      </div>
    </div>

    <div class="site-menubar-footer">
      <a href="javascript: void(0);"  data-placement="top" data-toggle="tooltip">
        <span class="" aria-hidden="false"></span>
      </a>
      <a href="lockscreen.php" data-placement="top" data-toggle="tooltip" data-original-title="Bloquear Sesion">
        <span class="icon wb-eye-close" aria-hidden="true"></span>
      </a>
      <a class="logout" data-placement="top" data-toggle="tooltip" data-original-title="Cerrar Sesion">
        <span class="icon wb-power" aria-hidden="true"></span>
      </a>
    </div>
  </div>
  <div class="site-gridmenu">
    <ul>
      <li>
        <a href="../apps/mailbox/mailbox.html">
          <i class="icon wb-envelope"></i>
          <span>Mailbox</span>
        </a>
      </li>
      <li>
        <a href="../apps/calendar/calendar.html">
          <i class="icon wb-calendar"></i>
          <span>Calendar</span>
        </a>
      </li>
      <li>
        <a href="../apps/contacts/contacts.html">
          <i class="icon wb-user"></i>
          <span>Contacts</span>
        </a>
      </li>
      <li>
        <a href="../apps/media/overview.html">
          <i class="icon wb-camera"></i>
          <span>Media</span>
        </a>
      </li>
      <li>
        <a href="../apps/documents/categories.html">
          <i class="icon wb-order"></i>
          <span>Documents</span>
        </a>
      </li>
      <li>
        <a href="../apps/projects/projects.html">
          <i class="icon wb-image"></i>
          <span>Project</span>
        </a>
      </li>
      <li>
        <a href="../apps/forum/forum.html">
          <i class="icon wb-chat-group"></i>
          <span>Forum</span>
        </a>
      </li>
      <li> <a href="index.php"> <em class="icon wb-dashboard"></em> <span>Dashboard</span> </a> </li>
    </ul>
  </div>


  <!-- Page -->
  <div class="page">
    <div class="page-header padding-0">
      <!--div class="widget widget-article type-flex">
        <div class="widget-header cover overlay">
          <img class="cover-image height-300" id="fotografi" src="../<?php //echo $portada?>">
          <div class="overlay-panel text-center vertical-align">
            <div class="widget-metas vertical-align-middle blue-grey-800" style="width:100%">
              <div class="widget-title font-size-50 margin-bottom-35 blue-grey-800" style="width:100%"><?php //echo $_SESSION["user"] ?></div>
                <ul class="list-inline font-size-16">
                <li class="margin-left-5"> 
				    <li> <em class="icon wb-map margin-right-5" aria-hidden="true"></em><div id="address" style="float:right"></div>
				</li>
                <li class="margin-left-20">
                  <i class="icon wb-heart margin-right-5" aria-hidden="true"></i><?php //echo $tam ?> cerca de ti.
                </li>
              </ul>
            </div>
          </div>&nbsp;&nbsp;&nbsp;
          <a class="avatar" style="width:20px;height:20px">
            <img id="addImg" src="../icons/photo.png">
          </a>

        </div>
      </div-->
      <div class="widget widget-shadow" id="widgetGmap">
            <div class="map height-full" id="gmap"></div>
          </div>

    </div>

    <div class="page-content container-fluid">
      <div class="row" data-plugin="matchHeight" data-by-row="true">
       
        <div class="col-xlg-12 col-lg-12 col-md-12">
          <!-- Panel Traffic -->
          <div class="panel" id="Revistaers">
            <div class="panel-heading">
              <h3 class="panel-title">
                Cerca de ti
              </h3>
            </div>
            <div class="panel-body">
              <ul class="list-group list-group-dividered list-group-full">
              <?php 
                 $ubicacion=obtenerlatlongAll($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
                 $tam=substr_count($ubicacion,"&");
               	
                 $ubicacions=explode("&",$ubicacion);
                 if($tam>=10)
                   $tot=10;
                 else
                   $tot=$tam;
                 for($a=0;$a<$tot;$a++)
                 {
                   // echo $ubicacions[$a];
					$users=explode(",",$ubicacions[$a]);
					$users[6]=str_replace(",",";",$users[6]);
					
					$tim=explode(" ",$users[5]);
				  if($tim[2]=="min")	
				  {
                 	if($tim[0]<60){
                 		$estus="online";
                 	}
                 	if($tim[0]>=60 && $tim[0]<120){
                 		$estus="away";
                 	}
                 	if($tim[0]>=120 && $tim[0]<150){
                 		$estus="busy";
                 	}
                 	if($tim[0]>=150){
                 		$estus="off";
                 	}
                  }
                  else
                  {
                  	if($users[5]!="Hace un momento")
                 	  $estus="off";
                  	else 
                  	  $estus="online";	
                  }
              ?>
                <li class="list-group-item">
                  <div class="media">
                    <div class="media-left">
                      <a class="verperfil" id="<?php echo $users[8] ?>">
                        <i class="avatar avatar-<?php echo $estus?>" style="height:50px;width:50px">
                         <img src="<?php echo $users[1]?>" style="height:50px;width:50px">
                        <i></i>
                      </i>
                      </a>
                    </div>
                    <div class="media-body">
                   
                      <div class="pull-right" id="btn<?php echo $users[8] ?>">
                        <?php
                        // si el usuario ya esta agregado o no
                       $usuconfir=usuconfir($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $users[8]);
                       
                      if($usuconfir==0) 
                      {
                    ?>
                      <a class="agregar" id="<?php echo $users[8] ?>"><button type="button" class="btn btn-outline btn-default btn-sm">Agregar</button></a>
                      <?php 
                      }
                      else 
                      {
                      ?>
                      <a href="user.php?order=1&nom=&pag=0"><button type="button" class="btn btn-success btn-default btn-sm">Revista</button></a>
                      <?php 
                      }
                      ?>   
                      </div>
                      <div><b class="name" href="javascript:void(0)"><?php echo $users[0]?></b>&nbsp;<em class="icon wb-map margin-right-5" aria-hidden="true"></em><?php echo $users[4]." Km."?></div>
                      <?php 
                      $users[6]=str_replace(";",",",$users[6]);
                      ?>
                      <small><?php echo $users[6]?></small>
                    </div>
                  </div>
                </li>
              <?php } ?>  
              </ul>
            </div>
          </div>
        </div><!--col-xlg-12 col-lg-12 col-md-12-->

       
      </div><!--row-->
        
	<input id="crono" type="hidden">
    <input id="pendnotis" type="hidden" value="<?php echo $not[0]?>">

       

    </div>

  </div><!-- End Page -->
  <!-- Footer -->
  <footer class="site-footer">
    <span class="site-footer-legal">© 2015 <a href="index.php">P.E.</a></span>
    <div class="site-footer-right">
      Creada <i class="red-600 wb wb-heart"></i> by <a href="index.php"><?php echo $_SESSION["user"]?></a>
    </div>
  </footer>

  <!-- Core  -->
  <script src="../../assets/vendor/jquery/jquery.js"></script>
  <script src="../../assets/vendor/bootstrap/bootstrap.js"></script>
  <script src="../../assets/vendor/animsition/jquery.animsition.js"></script>
  <script src="../../assets/vendor/asscroll/jquery-asScroll.js"></script>
  <script src="../../assets/vendor/mousewheel/jquery.mousewheel.js"></script>
  <script src="../../assets/vendor/asscrollable/jquery.asScrollable.all.js"></script>
  <script src="../../assets/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>

  <!-- Plugins -->
  <script src="../../assets/vendor/switchery/switchery.min.js"></script>
  <script src="../../assets/vendor/intro-js/intro.js"></script>
  <script src="../../assets/vendor/screenfull/screenfull.js"></script>
  <script src="../../assets/vendor/slidepanel/jquery-slidePanel.js"></script>

  <!-- Plugins For This Page -->
  <script src="../../assets/vendor/chartist-js/chartist.min.js"></script>
  <script src="../../assets/vendor/gmaps/gmaps.js"></script>
  <script src="../../assets/vendor/matchheight/jquery.matchHeight-min.js"></script>

  <!-- Scripts -->
  <script src="../../assets/js/core.js"></script>
  <script src="../../assets/js/site.js"></script>

  <script src="../../assets/js/sections/menu.js"></script>
  <script src="../../assets/js/sections/menubar.js"></script>
  <script src="../../assets/js/sections/sidebar.js"></script>

  <script src="../../assets/js/configs/config-colors.js"></script>
  <script src="../../assets/js/configs/config-tour.js"></script>

  <script src="../../assets/js/components/asscrollable.js"></script>
  <script src="../../assets/js/components/animsition.js"></script>
  <script src="../../assets/js/components/slidepanel.js"></script>
  <script src="../../assets/js/components/switchery.js"></script>

  <!-- Scripts For This Page -->
  <script src="../../assets/js/components/gmaps.js"></script>
  <script src="../../assets/js/components/matchheight.js"></script>
  <!--script type='text/javascript' src="../js/bootstrap-slider.js"></script-->
   <!--script>   
   // para generar ubicacion 
   function pedirPosicion(pos) {
	     
	 //alert(pos.coords.latitude+ ","+pos.coords.longitude+" Rango de localizaci? de +/- "+pos.coords.accuracy+" metros");

	 latitud=pos.coords.latitude;
	 longitud=pos.coords.longitude;
	 rango=pos.coords.accuracy;
	 
	 $.ajax({
         url:'../includes/consultas.php',
         type: 'POST'
         ,dataType: 'html'
         ,data: {num:13,latitud:latitud,longitud:longitud,rango:rango}
         ,success: function(data, textStatus, xhr){
           if(xhr.status==200){
            // alert(data);
           }
         }
       });
   }
	    
   function geolocalizame(){
	   sel='<?php //echo $sel?>';
	   if(sel!="")
		 {
	       navigator.geolocation.getCurrentPosition(pedirPosicion);
		 }
		 else
		 {
			 alert("Su session ha caducado, Ingrese de nuevo Por favor.");
		     document.location.href="login.php"; 
   		 }
    }
	   
   </script--> 

  <script>  
  $(document).ready(function($) {

      Site.run();
/*
      // widget-linearea
      (function() {
        var linearea = new Chartist.Line('#widgetLinearea .ct-chart', {
          labels: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
          series: [
            [0, 2.5, 2, 2.8, 2.6, 3.8, 0],
            [0, 1.4, 0.5, 2, 1.2, 0.9, 0]
          ]
        }, {
          low: 0,
          showArea: true,
          showPoint: false,
          showLine: false,
          fullWidth: true,
          chartPadding: {
            top: 0,
            right: 10,
            bottom: 0,
            left: 0
          },
          axisX: {
            showGrid: false,
            labelOffset: {
              x: -14,
              y: 0
            },
          },
          axisY: {
            labelOffset: {
              x: -10,
              y: 0
            },
            labelInterpolationFnc: function(num) {
              return num % 1 === 0 ? num : false;
            }
          }
        });
      })();

      // widget gmap
      (function() {
        var map = new GMaps({
          el: '#gmap',
          lat: -12.043333,
          lng: -77.028333,
          zoomControl: true,
          zoomControlOpt: {
            style: "SMALL",
            position: "TOP_LEFT"
          },
          panControl: true,
          streetViewControl: false,
          mapTypeControl: false,
          overviewMapControl: false
        });

        map.addStyle({
          styledMapName: "Styled Map",
          styles: $.components.get('gmaps', 'styles'),
          mapTypeId: "map_style"
        });

        map.setStyle("map_style");
      })();*/
    });
  </script>


</body>

</html>