<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");

if(!isset($_COOKIE['Erecor'])){
  $mail=$_COOKIE['Email'];
  $pass=$_COOKIE['Epass'];
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

$noti=notificaciones($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
$not=explode(";",$noti);

$tamnot=substr_count($not[1],"&");
$avatar=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_SESSION["iduser"]);

?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">

  <title>Cerca de mi|Punto de Encuentro</title>

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

  <!-- Fonts -->
  <link rel="stylesheet" href="../../assets/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="../../assets/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
  <!-- Inline-->
  <link rel="stylesheet" href="../../assets/examples/css/pages/map.css">

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

  <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="../js/simple-slider.js"></script>
  <link href="../css/simple-slider.css" rel="stylesheet" type="text/css" />
  <link href="../css/simple-slider-volume.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript">
 
  var map;
  var markeres= []; 

   function cambio(km,edad,sex){

  $.ajax({
        url:'../includes/consultas.php',
        type: 'POST'
        ,dataType: 'html'
        ,data: {num:14,km:km,edad:edad,sex:sex}
        ,success: function(data, textStatus, xhr) {
         if (xhr.status == 200) {   
            changeLayer(data);
            $.ajax({
              url:'cercadeti.php',
              type: 'POST'
              ,dataType: 'html'
              ,data: {}
              ,success: function(data, textStatus, xhr) {
               if (xhr.status == 200) { 
              // alert(data); 
                $("#lista").html(data);
              }
            }
           });
         }
       }
    });
  }
 function changeLayer(data)
  {
   borrar();
   var myLatLng = new google.maps.LatLng(19.4460481, -99.1196811);
  
  map = new google.maps.Map(document.getElementById('gmap'), {
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
  <script>
    Breakpoints();
    $(document).ready(function(){
/// guardar preferencias a un lado
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
              changeLayer(data);
              $.ajax({
                url:'cercadeti.php',
                type: 'POST'
                ,dataType: 'html'
                ,data: {}
                ,success: function(data, textStatus, xhr) {
                 if (xhr.status == 200) { 
                // alert(data); 
                  $("#lista").html(data);
                }
              }
             });
           }
          }
       });
    });
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
                               $("#estatususerubi").attr("class","avatar avatar-online");
                            }
                            if(dato[0]>=60 && dato[0]<120){
                               $("#estatususer").attr("class","avatar avatar-away");
                               $("#estatususerubi").attr("class","avatar avatar-away");
                            }
                            if(dato[0]>=120 && dato[0]<150){
                               $("#estatususer").attr("class","avatar avatar-busy");
                               $("#estatususerubi").attr("class","avatar avatar-busy");
                            }
                            if(dato[0]>=150){
                               $("#estatususer").attr("class","avatar avatar-off");
                               $("#estatususerubi").attr("class","avatar avatar-off");
                            }
   	                      }
                          else{
                        	  if(data!="Hace un momento")
                        	  {
	                          	  $("#estatususer").attr("class","avatar avatar-off");
	                              $("#estatususerubi").attr("class","avatar avatar-off");
                        	  }
		                      else
		                      {
			                      $("#estatususer").attr("class","avatar avatar-online");
			                      $("#estatususerubi").attr("class","avatar avatar-online");
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
        }
     else
     {
      alert("Su session ha caducado, Ingrese de nuevo Por favor.");
      document.location.href="login.php"; 
     } 

    });//ready
   	 ///////////////////////////////////////////////////

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
<body  class="page-map page-map-full">
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
      <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
        <img class="navbar-brand-logo" src="../../assets/images/logo.png" title="Punto de Encuentro">
        <span class="navbar-brand-text">Punto de Encuentro</span>
      </div>
      <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-search"
      data-toggle="collapse">
        <span class="sr-only">Toggle Search</span>
        <i class="icon wb-search" aria-hidden="true"></i>
      </button>
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
            <a class="icon wb-search" data-toggle="collapse" href="#" data-target="#site-navbar-search"
            role="button">
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
                              href="../uikit/panel-structure.html">Panels</a>
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
                <a href="javascript:void(0)" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Profile</a>
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
   				
   				if(($confirmarusuado==0 && ($dato[3]==1 || $dato[3]==6)) || $confirmarusuado==1)
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
                <li class="site-menu-item">
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
                <li class="site-menu-item active">
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
sex=$('input:radio[name=sex]:checked').val()
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
sex=$('input:radio[name=sex]:checked').val()
cambio(km,edad,sex);
});
 </script>          
        </div>
      </div>
    </div><!--site-menubar-->

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
     <!-- Page -->
  <div class="page animsition"> 
    <div class="gmap" id="gmap"></div>

  <div class="col-xlg-12 col-lg-12 col-md-12" style="background:#f1f4f5"><br>
          <!-- Panel Traffic -->
          <div class="panel" id="Revistaers">
            <div class="panel-heading">
              <h3 class="panel-title">
                Cerca de ti
              </h3>
            </div>
            <div class="panel-body" id="lista">
             
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

            </div><!--panel-body-->
          </div><!---panel-->

        </div><!--class="col-xlg-12 col-lg-12 col-md-12"-->
  </div><!--page animsition--> 
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

  <!-- Plugins For This Page -->
  <script src="../../assets/vendor/gmaps/gmaps.js"></script>

  <!-- Scripts -->
  <script src="../../assets/js/core.js"></script>
  <script src="../../assets/js/site.js"></script>

  <script src="../../assets/js/sections/menu.js"></script>
  <script src="../../assets/js/sections/menubar.js"></script>
  <script src="../../assets/js/sections/gridmenu.js"></script>
  <script src="../../assets/js/sections/sidebar.js"></script>

  <script src="../../assets/js/configs/config-colors.js"></script>
  <script src="../../assets/js/configs/config-tour.js"></script>

  <script src="../../assets/js/components/asscrollable.js"></script>
  <script src="../../assets/js/components/animsition.js"></script>
  <script src="../../assets/js/components/slidepanel.js"></script>
  <script src="../../assets/js/components/switchery.js"></script>

  <!-- Scripts For This Page -->
  <!--script src="../../assets/js/components/gmaps.js"></script>

  < script src="../../assets/examples/js/pages/map-google.js"></script-->


 
  <script>
 
 
    (function(document, window, $) {
      'use strict';

      var Site = window.Site;
      $(document).ready(function() {
         
        Site.run();


    });
  })(document, window, jQuery);
</script>


    </style>


</body>

</html>