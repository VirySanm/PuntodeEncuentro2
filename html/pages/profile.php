<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
if(!isset($_COOKIE['Erecor'])){
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
$datosPerfil=datosPerfil($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $_SESSION["iduser"]);
$avatar=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_SESSION["iduser"]);
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

  <title>Profile | Remark Admin Template</title>

  <link rel="apple-touch-icon" href="../../assets/images/apple-touch-icon.png">
  <link rel="shortcut icon" href="../../assets/images/favicon.ico">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap-extend.min.css">
  <link rel="stylesheet" href="../../assets/css/site.min.css">

  <!-- Plugins -->
  <link rel="stylesheet" href="../../assets/vendor/animsition/animsition.css">
  <link rel="stylesheet" href="../../assets/vendor/asscrollable/asScrollable.css">
  <link rel="stylesheet" href="../../assets/vendor/switchery/switchery.css">
  <link rel="stylesheet" href="../../assets/vendor/intro-js/introjs.css">
  <link rel="stylesheet" href="../../assets/vendor/slidepanel/slidePanel.css">
  <link rel="stylesheet" href="../../assets/vendor/flag-icon-css/flag-icon.css">

  <!-- Page -->
  <link rel="stylesheet" href="../../assets/css/pages/profile.css"> 

  <!-- Fonts -->
  <link rel="stylesheet" href="../../assets/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="../../assets/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Noto+Sans:400,400italic,700'>

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
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="../js/simple-slider.js"></script>
  <link href="../css/simple-slider.css" rel="stylesheet" type="text/css" />
  <link href="../css/simple-slider-volume.css" rel="stylesheet" type="text/css" />
  <script>
    Breakpoints();
  function cambio(km,edad,sex){

  $.ajax({
        url:'../includes/consultas.php',
        type: 'POST'
        ,dataType: 'html'
        ,data: {num:14,km:km,edad:edad,sex:sex}
        ,success: function(data, textStatus, xhr) {
         if (xhr.status == 200) {   
         }
       }
    });
  }
    function codeLatLng() {

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
                  cp=dir[2].split(" ");
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
    
  $(document).ready(function(){
       $(".sexo").click(function() {
      km=$("#sli").val();
      edad=$("#sli2").val();
      sex=$('input:radio[name=sex]:checked').val();
      $.ajax({
          url: '../includes/consultas.php',
          type: 'POST'
          , dataType: 'html'
          , data: {num: 14,km:km,edad:edad,sex:sex}
          , success: function (data, textStatus, xhr) {
           if (xhr.status == 200) {
           }
          }
       });
    });
	   pe=$("#pendnotis").val();
	   if(pe!=0)
	   {
		  $("#numnotis").html('<i class="icon wb-bell" aria-hidden="true"></i><span class="badge badge-danger up">'+pe+'</span>');
	   }
	   else{
	   	  $("#numnotis").html('<i class="icon wb-bell" aria-hidden="true"></i><span class="badge badge-danger up"></span>');
	   }
      codeLatLng();
      actnews();       
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
              //alert(contador);
                $.ajax({
                  url:'../includes/consultas.php',
                  type: 'POST'
                  ,dataType: 'html'
                  ,data:({num:9})
                  ,success: function(data, textStatus, xhr){
                     if (xhr.status == 200) {
                    	//alert(data);
                     dato=data.split(" ");
                     if(dato[1]=="min")
      	             {
      	                dato[0]=dato[0]*60;
                        if(dato[0]<60){
                           $("#estatususer").attr("class","avatar avatar-online");
                                // $("#estatususerubi").attr("class","avatar avatar-online");
                        }
                        if(dato[0]>=60 && dato[0]<120){
                           $("#estatususer").attr("class","avatar avatar-away");
                                 //$("#estatususerubi").attr("class","avatar avatar-away");
                        }
                        if(dato[0]>=120 && dato[0]<150){
                           $("#estatususer").attr("class","avatar avatar-busy");
                                 //$("#estatususerubi").attr("class","avatar avatar-busy");
                        }
                        if(dato[0]>=150){
                           $("#estatususer").attr("class","avatar avatar-off");
                                 //$("#estatususerubi").attr("class","avatar avatar-busy");
                        }
      	             } 
                     else{
                       if(data!="Hace un momento")
                       {
   	                  	  $("#estatususer").attr("class","avatar avatar-off");
   	                              //$("#estatususerubi").attr("class","avatar avatar-busy");
                       }
   		               else
   		               {
   			              $("#estatususer").attr("class","avatar avatar-online");
   			                      //$("#estatususerubi").attr("class","avatar avatar-online");
   		               }
                    }
                    }
                  }
                });
                contador=5;
              }
          }
          ,1000);
    }
  
   
   
    $(function() {
      // BotÃ³n para subir las fotos
      //alert("hola");
      var btn_firma = $('#addImg'), interval;
      new AjaxUpload('#addImg', {
        action: 'uploadFile.php',
        onSubmit : function(file , ext){
          if (! (ext && /^(jpg|png)$/.test(ext))){
            // extensiones permitidas
            alert('SÃ³lo se permiten Imagenes .jpg o .png');
            // cancela upload
            return false;
          } else {
            $('.fotografi').attr('src','../orden/img/loader.gif');
            // $('#loaderAjax').show();
            //btn_firma.text('Espere por favor');
            //this.disable();
          }
        },
        onComplete: function(file, response){

          respuesta = $.parseJSON(response);
        // alert(respuesta.respuesta);
          if(respuesta.respuesta == 'done'){
            $.ajax({
              url:'guardaavatar.php',
              type: 'POST'
              ,dataType: 'html'
              ,data: {avatar:respuesta.fileName}
              ,success: function(data, textStatus, xhr){
                if(xhr.status==200){
               //   alert(respuesta.fileName);
                  document.location.href="profile.php";
                }
              }
            });

            //$('.loaderAjax').show();
           // alert("me: "+respuesta.tamanio+"-"+respuesta.mensaje);
          }
          else{
            alert(respuesta.mensaje);
            $('.fotografi').attr('src','<?php echo $avatar?>');
          }

          //  $('#loaderAjax').hide();
          //this.enable();
        }
      });
    });
 });
  
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
       //alert(pe);
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
</head>
<body class="page-profile" onload="geolocalizame()">
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
        <img class="navbar-brand-logo" src="../../assets/images/logo.png" title="Punto de encuentro">
        <span class="navbar-brand-text">Punto de encuentro</span>
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
                                href="../advanced/animation.html">Animation</a>
                          </li>
                          <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                            <a
                                href="../uikit/buttons.html">Buttons</a>
                          </li>
                          <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                            <a
                                href="../uikit/colors.html">Colors</a>
                          </li>
                          <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                            <a
                                href="../uikit/dropdowns.html">Dropdowns</a>
                          </li>
                          <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                            <a
                                href="../uikit/icons.html">Icons</a>
                          </li>
                          <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                            <a
                                href="../advanced/lightbox.html">Lightbox</a>
                          </li>
                        </ul>
                      </li>
                      <li class="mega-menu margin-0">
                        <ul class="list-icons">
                          <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                            <a
                                href="../uikit/modals.html">Modals</a>
                          </li>
                          <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                            <a
                                href="../uikit/panels.html">Panels</a>
                          </li>
                          <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                            <a
                                href="../structure/overlay.html">Overlay</a>
                          </li>
                          <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                            <a
                                href="../uikit/tooltip-popover.html ">Tooltips</a>
                          </li>
                          <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                            <a
                                href="../advanced/scrollable.html">Scrollable</a>
                          </li>
                          <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>
                            <a
                                href="../uikit/typography.html">Typography</a>
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
                    <h5 class="margin-bottom-0"></h5>
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
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" data-animation="scale-up"
             aria-expanded="false" role="button">
          </a>
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
              <a id="editarperfil2" class="lista" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Profile</a>
            </li>
            <li role="presentation">
              <a class="lista" role="menuitem"><i class="icon wb-payment" aria-hidden="true"></i> Billing</a>
            </li>
            <li role="presentation">
              <a class="lista" role="menuitem"><i class="icon wb-settings" aria-hidden="true"></i> Settings</a>
            </li>
            <li class="divider" role="presentation"></li>
            <li role="presentation">
              <a class="logout" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
            </li>
          </ul-->
        </li>
        <li class="dropdown">
            <a data-toggle="dropdown"  title="Notificaciones" aria-expanded="false"
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
  				 	if($dato[3]==6)
  				 		$userr=$dato[5];
  				 	else
  				 		$userr=$dato[1];
  				 	
  				 	if($userr==$_SESSION["iduser"])
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
                    <a class="list-group-item" id="<?php echo $userr.",".$dato[3].",".$usus.",".$dato[4].",".$idalbum[0]?>" role="menuitem">
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
                        if($dato[3]==6) {?>
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-online" style="height:50px;width:50px">
                            <img src="<?php echo $verfoto?>" style="height:50px;width:50px" />
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
        </li> -->
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
            <li class="site-menu-category"></li>
            <li class="site-menu-item has-sub active open">
              <a href="javascript:void(0)" data-slug="dashboard">
                <!--i class="site-menu-icon wb-dashboard" aria-hidden="true"></i-->
                <!--span class="site-menu-title">Encuentra</span-->
                <!--div class="site-menu-badge">
                  <span class="badge badge-success"></span>
                </div-->
              </a>
              <ul class="site-menu-sub">
                <!--li class="site-menu-item">
                  <a class="animsition-link" href="index.php" data-slug="dashboard">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Dashboard</span>
                  </a>
                </li-->
                 <li class="site-menu-item">
                  <a class="animsition-link" href="user.php?order=1&nom=&pag=0" data-slug="profile">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Revista</span>
                  </a>
                </li>
                <li class="site-menu-item active">
                  <a class="animsition-link" href="profile.php?c=0" data-slug="profile">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Perfil</span>
                  </a>
                </li>
                 <!--li class="site-menu-item">
                  <a class="animsition-link" href="gallery.php?idalbum=1" data-slug="profile">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Fotos</span>
                  </a>
                </li-->
                <li class="site-menu-item">
                  <a class="animsition-link" href="map-google.php" data-slug="">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Cerca de mi</span>
                  </a>
               </li>                           
                
            </ul>
          <li class="site-menu-item has-sub active open">
            <span class="site-menu-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>Preferencias</i></span>
            <div class="site-menu-badge">
              <span class="badge badge-success"></span>
            </div>  
          </ul>

         <div id="header-wrapper">
    
<div class="site-menubar-section" style="margin-top:15px;margin-bottom:20px">
<h5>Distancia 1Km - 10Km</h5>
 <?php 
    if($datosPerfil[9]=="")
      $km=3;
    else 
      $km=$datosPerfil[9];  
    if($datosPerfil[10]=="")
      $edad=3;
    else 
      $edad=$datosPerfil[10]; 
    
    if($datosPerfil[11]=="")
      $check="";
    else 
    {
      if($datosPerfil[11]=="todos")
        $check="checked";
      else
        $check="";
      if($datosPerfil[11]=="Hombre")
        $check1="checked";
      else
        $check1="";
      if($datosPerfil[11]=="Mujer")
        $check2="checked";
      else
        $check2="";
    }
  ?>
<input id="sli" data-slider="true"  value="<?php echo $km?>" data-slider-values="1,2,3,4,5,6,7,8,9,10"
 data-slider-highlight="true" data-slider-nap="true" type="text" />
<br>
<h5>Edad 18 Años- 55 Años</h5>
<input id="sli2" data-slider="true" value="<?php echo $edad?>" data-slider-values="18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55"
 data-slider-highlight="true" data-slider-snap="true" type="text" />
 <br><br>
  <input value="todos" name="sex" class="sexo" type="radio" <?php echo $check?>>&nbsp;&nbsp;Todos&nbsp;&nbsp;<img src="../icons/mujer.png" style="width:20px;height:20px"><img src="../icons/hombre.png" style="width:20px;height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <br>
  <input value="Hombre" name="sex" class="sexo" type="radio" <?php echo $check1?>/>&nbsp;&nbsp;Chicos&nbsp;&nbsp;<img src="../icons/hombre.png" style="width:20px;height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <br>
  <input value="Mujer" name="sex" class="sexo" type="radio" <?php echo $check2?>/>&nbsp;&nbsp;Chicas&nbsp;&nbsp;<img src="../icons/mujer.png" style="width:20px;height:20px">

 </div>
</div>
 
 <script type="text/javascript">

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
sex=$('input:radio[name=sex]:checked').val();
cambio(km,edad,sex);
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
sex=$('input:radio[name=sex]:checked').val();
cambio(km,edad,sex);
});
 </script>  
      </div>
    </div>
  </div>

  <div class="site-menubar-footer">
    <!--a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip" data-original-title="Settings">
      <span class="icon wb-settings" aria-hidden="true"></span>
    </a-->
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
      <a href="apps/mailbox/mailbox.html">
        <i class="icon wb-envelope"></i>
        <span>Mailbox</span>
      </a>
    </li>
    <li>
      <a href="apps/calendar/calendar.html">
        <i class="icon wb-calendar"></i>
        <span>Calendar</span>
      </a>
    </li>
    <li>
      <a href="apps/contacts/contacts.html">
        <i class="icon wb-user"></i>
        <span>Contacts</span>
      </a>
    </li>
    <li>
      <a href="apps/media/overview.html">
        <i class="icon wb-camera"></i>
        <span>Media</span>
      </a>
    </li>
    <li>
      <a href="apps/documents/categories.html">
        <i class="icon wb-order"></i>
        <span>Documents</span>
      </a>
    </li>
    <li>
      <a href="apps/projects/projects.html">
        <i class="icon wb-image"></i>
        <span>Project</span>
      </a>
    </li>
    <li>
      <a href="apps/forum/forum.html">
        <i class="icon wb-chat-group"></i>
        <span>Forum</span>
      </a>
    </li>
    <li> <a href="index.php"> <em class="icon wb-dashboard"></em> <span>Dashboard</span> </a> </li>
  </ul>
</div>

<div class="page animsition"><!-- Page -->
  <div class="page-content container-fluid"><!-- page-content container-fluid -->
    <div class="row"><!-- row -->
      <div class="col-md-3">
        <!-- Page Widget -->
        <div class="editar" style="background-color: #FFFFFF;width:100%;height:30px;padding-top: 4px;padding-right: 10px;text-align: right">
         <a id="editarperfil" title="Editar Perfil"><img src="../icons/edit.png" style="width:15px;height:20px;cursor:pointer">&nbsp;
           <?php
          if(($datosPerfil[3]=="2015" || $datosPerfil[3]=="") && $avatar=="../orden/imagens/user.png") 
          {
          ?>
            Personalizar tu perfil 
          <?php	
          }
          ?>
          </a>
        </div>
        <div class="widget widget-shadow text-center">
          <div class="widget-header" style="padding-top: 0px">
            <div class="widget-header-content">
              <a class="avatar avatar-lg">
                <img id="addImg" class="fotografi" src="<?php echo $avatar?>" style="height:130px;width:130px"/>
              </a>
              <h4 class="profile-user"><?php echo $_SESSION["user"]?></h4>
              <p class="profile-job"><?php echo $datosPerfil[5]?></p>
              <p><?php echo $datosPerfil[0]?></p>
              <div class="profile-social">
                <?php
                $link=mysql_connect($strHostMYSQL, $strUserMYSQL, $strPWDMYSQL);
                mysql_select_db($strDBMYSQL,$link);
                if(mysql_errno()>0)
                {
                  $strResultOp = "No fue posible validar el usuario.";
                  $strInfoTec = "No fue posible localizar el host[".mysql_errno()."-".mysql_error()."]";
                  $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                  $strParameters= "host:".$strHostMYSQL."~-user:".$strUserMYSQL."~PWD:".$strPWDMYSQL."bd:".$strDBMYSQL;
                }
                else {
                  $str = "select *from redessociales where estatusRS=0 and iduser=" . $_SESSION["iduser"];
                  $Res = mysql_query($str);

                  if (mysql_errno() > 0) {
                    $strResultOp = "No fue posible validar el usuario.";
                    $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
                    $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
                    $strParameters = $str;
                    $exisalbum = 0;// no conexion
                  }
                  else {
                    while ($row = mysql_fetch_array($Res)) {
                      if($row["nomcorto"]!="mobile" && $row["nomcorto"]!="envelope") {
                        ?>
                        <a class="icon bd-<?php echo $row["nomcorto"] ?>" href="<?php echo $row["red"] ?>" target="_blank" title="<?php echo $row["red"] ?>"></a>
                        <?php
                      }
                      else{
                        ?>
                         <b class="icon wb-<?php echo $row["nomcorto"] ?>" title="<?php echo $row["red"] ?>"></b>
                     <?php
                      }
                    }
                  }
                }
                ?>

              </div>
              <a href="gallery.php?idalbum=1"><button type="button" class="btn btn-primary">Fotos</button></a>
             </div>
          </div>
          <div class="widget-footer">
            <div class="row no-space">
            <?php if($datosPerfil[6]!="" || $datosPerfil[7]!="" || $datosPerfil[8]!=""){?>
              <div class="col-xs-4">              
                 <strong class="profile-stat-count"><?php echo $datosPerfil[7] ?></strong>
                <a href="user.php?order=1&nom=&pag=0"  style="cursor: pointer">
                 <span>Agregaste</span>
                </a>
              </div>
              <div class="col-xs-4">
                <strong class="profile-stat-count"><?php echo $datosPerfil[6] ?></strong>
                <a data-toggle="tab" href="#agregados" aria-controls="agregados" id="ag">
                <span>Agregado</span>
                </a>
              </div>
              <div class="col-xs-4">
                <strong class="profile-stat-count"><?php echo $datosPerfil[8] ?></strong>
               <a data-toggle="tab" href="#visita" aria-controls="visita" id="vi">
                <span>Vistas</span>
                </a>
              </div>
              <?php }?>
            </div>
          </div>

        </div>
        <!-- End Page Widget -->
      </div>

      <div class="col-md-9">
       
        <div class="panel"> <!-- Panel -->
          <div class="panel-body nav-tabs-animate">
            <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
             <?php 
             $c="";
             $cc="class='tab-pane animation-slide-left'";
             $cl="";
             $cll="class='tab-pane animation-slide-left'";
            if($_GET["c"]==0)
            {
              $c="class='active'";
              $cc="class='tab-pane active animation-slide-left'";
            }
            if($_GET["c"]==1)
            {
              $cl="class='active'";
              $cll="class='tab-pane active animation-slide-left'";
            }
          ?>
              <li <?php echo $c ?> id="act" role="presentation"><a data-toggle="tab" href="#activities" aria-controls="activities" role="tab">Mi Actividad</a></li>
              <li <?php echo $cl ?> id="pro" role="presentation"><a data-toggle="tab" href="#profile" aria-controls="profile" role="tab">Notificaciones</a></li>
              <li id="agr" role="presentation"><a data-toggle="tab" href="#agregados" aria-controls="agregados" role="tab">Te Agreg&oacute;</a></li>
              <li id="vis" role="presentation"><a data-toggle="tab" href="#visita" aria-controls="visita" role="tab">Visitas</a></li>
            </ul>

            <div class="tab-content">

              <div <?php echo $cc ?> id="activities" role="tabpanel">
                <ul class="list-group">
                
                  <li class="list-group" style="cursor:pointer">
                    <div class="media media-lg">
                      <div class="media-left">
                       <?php 
                        $link=mysql_connect($strHostMYSQL, $strUserMYSQL, $strPWDMYSQL);
                        	mysql_select_db($strDBMYSQL,$link);
                        	if(mysql_errno()>0)
                        	{
                        		$strResultOp = "No fue posible validar el usuario.";
                        		$strInfoTec = "No fue posible localizar el host[".mysql_errno()."-".mysql_error()."]";
                        		$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                        		$strParameters= "host:".$strHostMYSQL."~-user:".$strUserMYSQL."~PWD:".$strPWDMYSQL."bd:".$strDBMYSQL;
                        	}
                        	else
                        	{
                        		$strS ="select tipoNotif, descripcion, iduserMov,iduserAct, fechaHrNotif, idnotif, idcomentario from notificaciones n, tiponotificacion t where n.tipoNotif=t.idtipoNotif and iduserMov=".$_SESSION["iduser"]." order by fechaHrNotif desc";
                        		$Res = mysql_query($strS);

                        		if(mysql_errno()>0){
                        			$strResultOp = "No fue posible validar el usuario.";
                        			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
                        			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                        			$strParameters=$str;
                        			$localizacion="";
                        		}
                        		else
                        		{
                        			while($row=mysql_fetch_array($Res)){
                        							
                        				$hoy = date("Y-m-d H:i:s");
                        				
                        				$datetime1 = new DateTime($row["fechaHrNotif"]);
                        				$datetime2 = new DateTime($hoy);
                        				
                        				$interval = date_diff($datetime1, $datetime2);
                        				$dia= $interval->format('%a');
                        				$horas= $interval->format('%H:%I');
                        				$hrs=explode(":",$horas);
                        				$hr=$hrs[0];
                        				$min=$hrs[1];
                        				
                        				if($dia<1)
                        				{
                        					if($hr>1)
                        					  $time=$hr." Horas";
                        					else 
                        					{
                        					  if($hr==1)
                        						$time=$hr." Hora";
                        					  else 
                                                if($min=="00")
                                                	$time="Hace un momento";
                        					  	else
                        					  		$time=$min." min";
                        					}
                        					 
                        				}
                        				else{
                        					if($dia==1)
                        					  $time=$dia." Dia";
                        					else 
                        					  $time=$dia." Dias";
                        				}

                        				if($row["tipoNotif"]==1)
                        					$row["descripcion"]="Agregaste como Contacto a ";
                        				if($row["tipoNotif"]==2)
                        					$row["descripcion"]="Agregaste Nuevas Fotos";
                        				if($row["tipoNotif"]==3)
                        					$row["descripcion"]="Cambiaste tu Foto de Perfil";
                        				if($row["tipoNotif"]==4)
                        					$row["descripcion"]="Cambiaste tu Foto de Portada";
                        				if($row["tipoNotif"]==5)
                        					$row["descripcion"]="Enviaste un Mensaje";
                        				if($row["tipoNotif"]==6)
                        					$row["descripcion"]="Comentaste una Foto";
                        				
                        				if($row["iduserAct"]==$_SESSION["iduser"])
                        				   $usus=2;
                        				else 
                        				   $usus=1;
                        				if($row["tipoNotif"]==5 || $row["tipoNotif"]==6 || $row["tipoNotif"]==1 )
                        				{
                        					$userr=$row["iduserAct"];

                        					$avatarusus=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduserAct"]);
                        					$nombreuserse=nombreusus($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduserAct"]);
                        				  
                        				  if($row["tipoNotif"]==6){
                        				    $idalbum=vercoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_SESSION["iduser"],$row["idcomentario"]);
                        					$avatarusus=verfotocoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$idalbum[1]);
                        					if($row["iduserAct"]==$_SESSION["iduser"])
                        						$nombreuserse="";
                        					else 
                        						$nombreuserse=" de ".$nombreuserse;
                        				 }
                        				}
                        			else
                        				{
                        					$userr=$row["iduserMov"];
                        					$nombreuserse="";
                        					$avatarusus="";
                        				}
                        					?>
                        					<a class="list-group-item" id="<?php echo $row["iduserAct"].",".$row["tipoNotif"].",".$usus.",".$row["idnotif"].",".$idalbum[0]?>" role="menuitem">
                                              <div class="media">
                                                <div class="media-left padding-right-10">
                                                  <span class="avatar avatar-sm avatar-online">
                                                    <img src="<?php echo $avatar?>" style="height:50px;width:50px"/>
                                                  </span>
                                                </div>
                                                <div class="media-body">
                                                  <h6 class="media-heading"><?php echo $nombreus?></h6>
                                                  <div class="media-meta">
                                                    <time datetime="2015-06-17T20:22:05+08:00"><?php echo $time ?></time>
                                                  </div>
                                                  <div class="media-detail"><?php echo $row["descripcion"].$nombreuserse?></div>
                                                </div>
                                                <?php if($row["tipoNotif"]==5 || $row["tipoNotif"]==6 || $row["tipoNotif"]==1 )
                        							{
                        						?>
                                                <div class="media-left padding-right-10">
                                                  <span class="avatar avatar-sm avatar-online">
                                                    <img src="<?php echo $avatarusus?>" style="height:50px;width:50px" />
                                                  </span>
                                                </div>
                                                <?php } ?>
                                              </div>
                                            </a> 
                                          <?php 
                        			   }
                        	   	     }
                        	        }
                        			?>
                  
                      </div>
                    </div>
                  </li>
                </ul>
              </div>

              
              <div <?php echo $cll ?> id="profile" role="tabpanel" >
                <ul class="list-group">
                 <li class="list-group" style="cursor:pointer" >
                    <div class="media media-lg">
                      <div class="media-left" >
                         <?php 
                          $link=mysql_connect($strHostMYSQL, $strUserMYSQL, $strPWDMYSQL);
                      	mysql_select_db($strDBMYSQL,$link);
                      	if(mysql_errno()>0)
                      	{
                      		$strResultOp = "No fue posible validar el usuario.";
                      		$strInfoTec = "No fue posible localizar el host[".mysql_errno()."-".mysql_error()."]";
                      		$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                      		$strParameters= "host:".$strHostMYSQL."~-user:".$strUserMYSQL."~PWD:".$strPWDMYSQL."bd:".$strDBMYSQL;
                      	}
                      	else
                      	{
                      		$strS ="select tipoNotif, descripcion, iduserMov, iduserAct, fechaHrNotif, idnotif, idcomentario from notificaciones n, tiponotificacion t where n.tipoNotif=t.idtipoNotif
                      				and ((iduserMov!=".$_SESSION["iduser"]." and iduserAct=".$_SESSION["iduser"].") or (iduserMov!=".$_SESSION["iduser"]." and iduserAct!=".$_SESSION["iduser"].")) group by idnotif order by fechaHrNotif desc";
                      		$Res = mysql_query($strS);

                      		if(mysql_errno()>0){
                      			$strResultOp = "No fue posible validar el usuario.";
                      			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
                      			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                      			$strParameters=$str;
                      			$localizacion="";
                      		}
                      		else
                      		{
                      			while($row=mysql_fetch_array($Res)){
                      							
                      				$hoy = date("Y-m-d H:i:s");
                      				
                      				$datetime1 = new DateTime($row["fechaHrNotif"]);
                      				$datetime2 = new DateTime($hoy);
                      				
                      				$interval = date_diff($datetime1, $datetime2);
                      				$dia= $interval->format('%a');
                      				$horas= $interval->format('%H:%I');
                      				$hrs=explode(":",$horas);
                      				$hr=$hrs[0];
                      				$min=$hrs[1];
                      				
                      			    if($dia<1)
                      				{
                      					if($hr>1)
                      					  $time=$hr." Horas";
                      					else 
                      					{
                      					  if($hr==1)
                      						$time=$hr." Hora";
                      					  else 
                                              if($min=="00")
                                              	$time="Hace un momento";
                      					  	else
                      					  		$time=$min." min";
                      					}
                      					 
                      				}
                      				else{
                      					if($dia==1)
                      					  $time=$dia." Dia";
                      					else 
                      					  $time=$dia." Dias";
                      				}

                      				$avatarusu=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduserMov"]);
                      				$nombreusers=nombreusus($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduserMov"]);
                      				if($row["iduserAct"]==$_SESSION["iduser"])
                      				   $usus=2;
                      				else 
                      				   $usus=1;
                      			
                      				if($row["tipoNotif"]==5 || $row["tipoNotif"]==6)
                      				{
                      					$userr=$row["iduserAct"];
                      				  
                      				  if($row["tipoNotif"]==6){
                      					$idalbum=vercoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduserMov"],$row["idcomentario"]);
                      					$avatarusus=verfotocoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$idalbum[1]);
                      				
                      				 }
                      				 
                      				}
                      			else
                      				{
                      					$userr=$row["iduserMov"];
                      					$nombreuserse="";
                      					$avatarusus="";
                      				}

                      				$confirmarusuado=usuconfir($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $row["iduserMov"]);
                      				$fechaagregado=fechaagregado($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $row["iduserMov"]);
                              
                      				if(($confirmarusuado==0 && $row["iduserAct"]==$_SESSION["iduser"] && ($row["tipoNotif"]==1 || $row["tipoNotif"]==6)) || ($confirmarusuado==1 && $fechaagregado <= $row["fechaHrNotif"] && $row["iduserAct"]==$_SESSION["iduser"]))
                      				{
                      					?>
                               <a class="list-group-item" id="<?php echo $userr.",".$row["tipoNotif"].",".$usus.",".$row["idnotif"].",".$idalbum[0]?>" role="menuitem">
                                    <div class="media">
                                      <div class="media-left padding-right-10">
                                        <span class="avatar avatar-sm avatar-online">
                                          <img src="<?php echo $avatarusu?>" style="height:50px;width:50px" />
                                        </span>
                                      </div>
                                      <div class="media-body">
                                        <h6 class="media-heading"><?php echo $nombreusers?></h6>
                                        <div class="media-meta">
                                          <time datetime="2015-06-17T20:22:05+08:00"><?php echo $time ?></time>
                                        </div>
                                        <div class="media-detail"><?php echo $row["descripcion"]?></div>
                                      </div>
                                        <?php 
                                      if($row["tipoNotif"]==6) {?>
                                      <div class="media-left padding-right-10">
                                        <span class="avatar avatar-sm avatar-online">
                                          <img src="<?php echo $avatarusus?>" style="height:50px;width:50px" />
                                        </span>
                                      </div>
                                      <?php }?>
                                    </div>
                                  </a>                       
                                <?php 
                          				}
                          			   }
                          	   	     }
                          	        }
                          			?>
               
                      </div>
                    </div>
                  </li>   
                </ul>
              </div>

              <div class='tab-pane animation-slide-left' id="agregados" role="tabpanel" >
                <ul class="list-group">
                  <li class="list-group" style="cursor:pointer" >
                    <div class="media media-lg">
                      <div class="media-left" >
                         <?php 
                          $link=mysql_connect($strHostMYSQL, $strUserMYSQL, $strPWDMYSQL);
                        mysql_select_db($strDBMYSQL,$link);
                        if(mysql_errno()>0)
                        {
                          $strResultOp = "No fue posible validar el usuario.";
                          $strInfoTec = "No fue posible localizar el host[".mysql_errno()."-".mysql_error()."]";
                          $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                          $strParameters= "host:".$strHostMYSQL."~-user:".$strUserMYSQL."~PWD:".$strPWDMYSQL."bd:".$strDBMYSQL;
                        }
                        else
                        {
                          $strS ="SELECT DATE_FORMAT(fecha,'%d-%m-%Y') AS fecha, iduserAgo FROM agregados  where iduserAdo=".$_SESSION["iduser"]." and estatusAgr=0 order by fecha desc";
                          $Res = mysql_query($strS);

                          if(mysql_errno()>0){
                            $strResultOp = "No fue posible validar el usuario.";
                            $strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
                            $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                            $strParameters=$str;
                            $localizacion="";
                          }
                          else
                          {
                            while($row=mysql_fetch_array($Res)){
                                    
                              $avatarusu=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduserAgo"]);
                              $nombreusers=nombreusus($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduserAgo"]);
                              
                                ?>
                               <a class="list-group-item" href="profileExt.php?iduser=<?php echo $row["iduserAgo"] ?>" role="menuitem">
                                    <div class="media">
                                      <div class="media-left padding-right-10">
                                        <span class="avatar avatar-sm avatar-online">
                                          <img src="<?php echo $avatarusu?>" style="height:50px;width:50px" />
                                        </span>
                                      </div>
                                      <div class="media-body">
                                        <h6 class="media-heading"><?php echo $nombreusers?></h6>
                                        <div class="media-detail">Te Agreg&oacute; <?php echo $row["fecha"] ?></div>
                                      </div>
                                    </div>
                                  </a>                       
                                <?php 
                                  }
                                }
                              }
                             ?>               
                      </div>
                    </div>
                  </li>   
                </ul>
              </div>

              <div class='tab-pane animation-slide-left' id="visita" role="tabpanel" >
                <ul class="list-group">
                  <li class="list-group" style="cursor:pointer" >
                    <div class="media media-lg">
                      <div class="media-left" >
                         <?php 
                          $link=mysql_connect($strHostMYSQL, $strUserMYSQL, $strPWDMYSQL);
                        mysql_select_db($strDBMYSQL,$link);
                        if(mysql_errno()>0)
                        {
                          $strResultOp = "No fue posible validar el usuario.";
                          $strInfoTec = "No fue posible localizar el host[".mysql_errno()."-".mysql_error()."]";
                          $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                          $strParameters= "host:".$strHostMYSQL."~-user:".$strUserMYSQL."~PWD:".$strPWDMYSQL."bd:".$strDBMYSQL;
                        }
                        else
                        {
                          $strS ="SELECT DATE_FORMAT(fechaHRVisita,'%d-%m-%Y') AS fecha, v.iduservisitante, u.nomUser FROM visitas v, user u where v.iduservisitante=u.iduser and v.iduservisitado=".$_SESSION["iduser"]." group by fecha order by v.idvisitas desc";
                          $Res = mysql_query($strS);

                          if(mysql_errno()>0){
                            $strResultOp = "No fue posible validar el usuario.";
                            $strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
                            $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                            $strParameters=$str;
                            $localizacion="";
                          }
                          else
                          {
                            while($row=mysql_fetch_array($Res)){
                              $hoy = date("Y-m-d H:i:s");
                              
                              $datetime1 = new DateTime($row["fecha"]);
                              $datetime2 = new DateTime($hoy);
                              
                              $interval = date_diff($datetime1, $datetime2);
                              $dia= $interval->format('%a');
                              $horas= $interval->format('%H:%I');
                              $hrs=explode(":",$horas);
                              $hr=$hrs[0];
                              $min=$hrs[1];
                              
                                if($dia<1)
                              {
                                if($hr>1)
                                  $time=$hr." Horas";
                                else 
                                {
                                  if($hr==1)
                                  $time=$hr." Hora";
                                  else 
                                              if($min=="00")
                                                $time="Hace un momento";
                                    else
                                      $time=$min." min";
                                }
                                 
                              }
                              else{
                                if($dia==1)
                                  $time=$dia." Dia";
                                else 
                                  $time=$dia." Dias";
                              }

                                    
                              $avatarusu=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduservisitante"]);
                              $nombreusers=nombreusus($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduservisitante"]);
                              
                                ?>
                               <a class="list-group-item" href="profileExt.php?iduser=<?php echo $row["iduservisitante"] ?>" role="menuitem">
                                    <div class="media">
                                      <div class="media-left padding-right-10">
                                        <span class="avatar avatar-sm avatar-online">
                                          <img src="<?php echo $avatarusu?>" style="height:50px;width:50px" />
                                        </span>
                                      </div>
                                      <div class="media-body">
                                        <h6 class="media-heading"><?php echo $nombreusers?></h6>
                                        <div class="media-detail">Te visit&oacute; hace <?php echo $time ?></div>
                                      </div>
                                    </div>
                                  </a>                       
                                <?php 
                                  }
                                }
                              }
                             ?>               
                      </div>
                    </div>
                  </li>   
                </ul>
              </div>

            </div><!--End tab-content-->

          </div><!--panel-body nav-tabs-animate-->     
        </div><!-- End Panel -->
      </div><!--col-md-9"-->
      
        <div class="col-xlg-3 col-md-12">
          <div class="row height-full">
            <div class="col-xlg-12 col-md-6" style="height:50%;">
              <!-- Panel Overall Sale-->
              <div class="widget widget-shadow bg-blue-600 white">
                <div class="widget-content padding-30">
                  <div class="counter counter-lg counter-inverse text-left">
                    <div class="counter-label margin-bottom-20">
                      <div>Suscripción individual</div>
                      <div>Agrega a tu revista solo lo que necesitas</div>
                    </div>
                    <div class="counter-number-group margin-bottom-15">
                      <span class="counter-number-related">$</span>
                      <span class="counter-number">175</span>
                    </div>
                    <div class="counter-label">
                      <div class="progress progress-xs margin-bottom-10 bg-blue-800">
                        <?php 
                        if($datosPerfil[15]==1)
                        {
                          $porcentaje=number_format(($datosPerfil[16]*100)/12);
                        }
                        else 
                        {
                          $porcentaje=60;
                          $datosPerfil[16]=7;
                        }
                        ?>
                        <div class="progress-bar progress-bar-info bg-white" style="width: <?php echo $porcentaje?>%" aria-valuemax="100"
                        aria-valuemin="0" aria-valuenow="42" role="progressbar">
                          <span class="sr-only"><?php echo $porcentaje?>%</span>
                        </div>
                      </div>
                      <div class="counter counter-sm text-left">
                        <div class="counter-number-group">
                          <span class="counter-number font-size-14"><?php echo $porcentaje?>%</span>&nbsp;&nbsp;&nbsp;
                          <span class="counter-number-related font-size-14"><?php echo $datosPerfil[16] ?>/12&nbsp;&nbsp;AGREGADOS</span><br>
                        <?php
                         if($datosPerfil[15]==1)
                        {
                        ?>
                          <span class="counter-number-related font-size-14">Vigencia:&nbsp;&nbsp;<?php echo  $datosPerfil[14] ?></span>
                        <?php }?>  
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--End Panel Overall Sales-->
            </div><!--col-xlg-12 col-md-6-->

            <div class="col-xlg-12 col-md-6" style="height:50%;">
              <!--Panel Today's Sale-->
              <div class="widget widget-shadow bg-red-600 white">
                <div class="widget-content padding-30">
                  <div class="counter counter-lg counter-inverse text-left">
                    <div class="counter-label margin-bottom-20">
                      <div>Suscripción Mensual</div>
                      <div>Agrega a tu revista sin mesura</div>
                    </div>
                    <div class="counter-number-group margin-bottom-10">
                      <span class="counter-number-related">$</span>
                      <span class="counter-number">300</span>
                    </div>
                    <div class="counter-label">
                      <div class="progress progress-xs margin-bottom-10 bg-red-800">
                        <div class="progress-bar progress-bar-info bg-white" style="width: 100%" aria-valuemax="100"
                        aria-valuemin="0" aria-valuenow="70" role="progressbar">
                          <span class="sr-only">70%</span>
                        </div>
                      </div>
                      <div class="counter counter-sm text-left">
                        <div class="counter-number-group">
                          <span class="counter-number font-size-14">ILIMITADO</span>
                          <span class="counter-number-related font-size-14"></span><br>
                       <?php 
                         if($datosPerfil[15]==2)
                        {
                        ?>
                          <span class="counter-number-related font-size-14">Vigencia:&nbsp;&nbsp;<?php echo  $datosPerfil[14] ?></span>
                        <?php }
                         else ?><br> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!--End Panel Today's Sales-->
            </div><!--col-xlg-12 col-md-6-->
          </div><!--row height-full-->
        </div><!--col-xlg-3 col-md-12-->

    </div><!--row"-->
  </div><!--page-content container-fluid-->
</div><!-- End Page-animsition -->

<input id="crono" type="hidden">
<input id="pendnotis" type="hidden" value="<?php echo $not[0]?>">

<!-- Footer -->
<footer class="site-footer">
  <span class="site-footer-legal">Â© 2015 <a href="index.php">P.E.</a></span>
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
  <!--script type='text/javascript' src="../js/bootstrap-slider.js"></script-->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
   <script>   
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
     mail='<?php echo $mail?>';
     pass='<?php echo $pass?>';
	 if(mail!= "" && pass!="")
	 {
       navigator.geolocation.getCurrentPosition(pedirPosicion);
	 }
	 else
	 {
		 alert("Su session ha caducado, Ingrese de nuevo Por favor.");
	     document.location.href="login.php";
	 }    
    }
	   
   </script> 
   
<!-- Scripts For This Page -->


<script>
  (function(document, window, $) {
    'use strict';

    var Site = window.Site;
    $(document).ready(function() {

        Site.run();
   
    });
  })(document, window, jQuery);
</script>


</body>

</html>