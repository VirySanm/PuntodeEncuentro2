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

if($_GET["order"]==1)
{
	$orden="Ultima Actividad";
	$ordenBD="a.fechaconex Desc";
}
if($_GET["order"]==2)
{
	$orden="Ubicacion";
	$ordenBD="distance Asc";
}
if($_GET["order"]==3)
{
	$orden="Nombre Usuario";
	$ordenBD="us.nomUser Asc";
}

?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">

  <title>Revista|Punto de Encuentro</title>

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
  <link rel="stylesheet" href="../../assets/css/pages/user.css">

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
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="../js/simple-slider.js"></script>
  <link href="../css/simple-slider.css" rel="stylesheet" type="text/css" />
  <link href="../css/simple-slider-volume.css" rel="stylesheet" type="text/css" />

  <script>
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
    Breakpoints();
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
  <link href="../css/bootstrap-slider.css" rel="stylesheet">
    <style type='text/css'>
	a{
	cursor:pointer;
	}
    </style>
</head>
<body class="page-user" style="overflow:scroll">
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
          </li>
           -->
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
    <div class="page-content">
      <!-- Panel -->
      <div class="panel">
        <div class="panel-body">
       
            <div class="input-search input-search-dark">
              <i class="input-search-icon wb-search" aria-hidden="true"></i>
              <input type="text" class="form-control" id="inputSearch" name="search" placeholder="Buscar Usuarios">
              <button type="button" class="input-search-close icon wb-close" aria-label="Close"></button>
            </div><br>
        

          <div class="nav-tabs-horizontal">
            <div class="dropdown page-user-sortlist">
              Ordenar por: <a class="dropdown-toggle inline-block" data-toggle="dropdown"
              href="#" aria-expanded="false"><?php echo $orden?><span class="caret"></span></a>
              <ul class="dropdown-menu animation-scale-up animation-top-right animation-duration-250"
              role="menu">
                <li role="presentation"><a href="user.php?order=1&nom=<?php echo $_GET["nom"]?>&pag=0">Ultima Actividad</a></li>
                <li role="presentation"><a href="user.php?order=2&nom=<?php echo $_GET["nom"]?>&pag=0">Ubicacion</a></li>
                <li role="presentation"><a href="user.php?order=3&nom=<?php echo $_GET["nom"]?>&pag=0">Nombre de Usuario</a></li>
              </ul>
            </div>

            <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
              <li role="presentation"><a href="user.php?order=1&nom=&pag=0"  style="color:#98C8F8"
                role="tab">Ver Todos</a></li>
              <!--li role="presentation"><a data-toggle="tab" href="#my_contacts" aria-controls="my_contacts"
                role="tab">Favoritos</a></li>
              <li role="presentation"></li>
              <li class="dropdown" role="presentation">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                  <span class="caret"></span>Contacts </a>
                <ul class="dropdown-menu" role="menu">
                  <li role="presentation"><a data-toggle="tab" href="#all_contacts" aria-controls="all_contacts"
                    role="tab">All Contacts</a></li>
                  <li class="active" role="presentation"><a data-toggle="tab" href="#my_contacts" aria-controls="my_contacts"
                    role="tab">My Contacts</a></li>
                  <li role="presentation"><a data-toggle="tab" href="#google_contacts" aria-controls="google_contacts"
                    role="tab">Google Contacts</a></li-->
                </ul>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane animation-fade active" id="all_contacts" role="tabpanel">
              <?php if($_GET["nom"]!="")
					   $nom=" and us.nomUser like '".$_GET["nom"]."%'";
              		else 
              			$nom="";
              		$total=ceil(totaluser($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$nom)/4);
					
					$ini=$_GET["pag"]*4;
					
					?>
                <ul class="list-group">
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
                	$str="SELECT us.mailUser,us.celUser,u.iduser, us.nomUser, a.fechaconex,u.latitud,u.longitud,p.sobremi,(6371 * ACOS(SIN(RADIANS(u.latitud)) * SIN(RADIANS(19.4456375))+ COS(RADIANS(u.longitud - -99.119641)) * COS(RADIANS(u.latitud)) * COS(RADIANS(19.4456375))
               )) AS distance FROM ubicacion u, perfiluser p, user us, actividad a where u.iduser=p.iduser and u.iduser=us.iduser and u.iduser=a.iduser and u.iduser!=".$_SESSION["iduser"]." ".$nom." ORDER BY ".$ordenBD." limit ".$ini.",4";
                	$Res = mysql_query($str);
                
                	if(mysql_errno()>0){
                		$strResultOp = "No fue posible validar el usuario.";
                		$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
                		$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                		$strParameters=$str;
                		$html=0;
                	}
                	else
                	{
                		while($row=mysql_fetch_array($Res)){
                        //echo "<br>". $row["iduser"];
                		 $usuconfir=usuconfir($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $row["iduser"]);
                      if($usuconfir==1)
                      {
                    	$avatar=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduser"]); 
                			//$tiempoact=timeactividad($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduser"]);
                			$nombreusers=$row["nomUser"];
                			//$nombreusers=nombreusus($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduser"]);
                			$localizacion=localizacion($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduser"]);
                			
                			$hoy=date("Y-m-d H:i:s");
                			
                			$datetime1 = new DateTime($row["fechaconex"]);
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
                				{
                					$time=$hr." Horas";
                				}
                				else
                				{
                					if($hr==1)
                					{
                						$time=$hr." Hora";
                					}
                					else
                						if($min=="00")
                						{
                							$time="Hace un momento";
                						}
                					else
                					{
                						$time=$min." min";
                					}
                				}
                			
                			}
                			else{
                				if($dia==1)
                				{
                					$time=$dia." Dia";
                				}
                				else
                				{
                					$time=$dia." Dias";
                				}
                			}
                			                			
                			$tiempoactividad=explode(" ",$time);
                			//echo "#".$tiempoactividad[1]."#".$tiempoactividad[0]."#";
                			if($tiempoactividad[1]=="min")
                			{
                				if($tiempoactividad[0]<60 && $tiempoactividad[0]>0){
                					$estus="online";
                				}
                				if($tiempoactividad[0]>=60 && $tiempoactividad[0]<120){
                					$estus="away";
                				}
                				if($tiempoactividad[0]>=120 && $tiempoactividad[0]<180){
                					$estus="busy";
                				}
                				if($tiempoactividad[0]>=180){
                					$estus="off";
                				}
                			}
                	        else	
                	        {	
                	          if($time!="Hace un momento")	
                			    $estus="off";
                	          else 
                	          	$estus="online";
                			}
                			$time="&Uacute;lt. Vez: ".$time;
                			if($estus=="online")
                			   $time="";
                			?>
                		 <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <a class="verperfil" id="<?php echo $row["iduser"] ?>">
                        <i class="avatar avatar-<?php echo $estus?>" style="height:50px;width:50px">
                         <img src="<?php echo $avatar?>" style="height:50px;width:50px">
                         <i></i>
                        </i>
                        </a>
                       </div>
                       <div class="media-body">
                        <h4 class="media-heading">
                          <?php echo $nombreusers ?>
                          <small><em class="icon wb-map margin-right-5" aria-hidden="true"></em><?php $km=number_format($row["distance"],2); echo $km ." Km."?>&nbsp; <?php echo $time?></small>
                        </h4>
                        <p>
                        <?php
                        
                        if($localizacion!=""){ ?>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i> 
                          <?php } echo $localizacion?>
                        </p>
                        
                        <div class="profile-social">
                        
                      <b class="icon wb-envelope">&nbsp;&nbsp;<?php echo $row["mailUser"] ?></b>
                      <b class="icon wb-mobile">&nbsp;<?php echo $row["celUser"] ?></b>
                     
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
                  $strq = "select *from redessociales where estatusRS=0 and iduser=".$row["iduser"];
                  $Resu = mysql_query($strq);

                  if (mysql_errno() > 0) {
                    $strResultOp = "No fue posible validar el usuario.";
                    $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
                    $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
                    $strParameters = $str;
                    $exisalbum = 0;// no conexion
                  }
                  else {
                    while ($raw = mysql_fetch_array($Resu)) {
                      
                      if($raw["nomcorto"]!="mobile" && $raw["nomcorto"]!="envelope") {
                        ?>
                        <a class="icon bd-<?php echo $raw["nomcorto"] ?>" href="<?php echo $raw["red"] ?>" target="_blank" title="<?php echo $raw["red"] ?>"></a>
                        <?php
                      }
                      else{
                        ?>
                         <b class="icon wb-<?php echo $raw["nomcorto"] ?>" title="<?php echo $raw["red"] ?>"></b>
                     <?php
                      }
                    }
                  }
                }
               
                ?>                        
                    </div>
                <?php   
               //}
                ?>  
                      </div>
                     <!--div class="media-right">
                      <div class="pull-right" id="btn<?php //echo $row["iduser"] ?>"-->
                        <?php
                        /* si el usuario ya esta agregado o no
                      
                      if($usuconfir==0) 
                      {*/
                    ?>
                        <!--a class="agregar" id="<?php //echo $row["iduser"] ?>"><button type="button" class="btn btn-outline btn-default btn-sm">Agregar</button></a-->
                      <?php 
                      /*}
                      else 
                      {*/
                      ?>
                      <!--a class="verperfil" id="<?php //echo $row["iduser"] ?>"><button type="button" class="btn btn-success btn-default btn-sm"><i class="icon wb-search" aria-hidden="true"></i>Perfil</button></a-->
                      <?php 
                      //}
                      ?>   
                      <!--/div> 
                     </div-->
                    </div>
                  </li>
                		<?php 
                		}
                	}
                }
              }
                if($_GET["pag"]>=0 && $_GET["pag"]<$total)
                  $n=$_GET["pag"]+1; 
                
                if($_GET["pag"]<$total && $_GET["pag"]>0)
                  $p=$_GET["pag"]-1;
                
                if($_GET["pag"]==0)
                	$p=$total-1;
                if($_GET["pag"]==$total-1)
                	$n=0;
                ?>                
                  
                </ul>
                <nav>
                  <ul class="pagination pagination-no-border">
                    <li>
                      <a href="user.php?order=<?php echo $_GET["order"]?>&nom=<?php echo $_GET["nom"]?>&pag=<?php echo $p?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <?php
                    
                      for($i=0;$i<$total;$i++){ 
                      	if($_GET["pag"]==$i)
                      		$clas='class="active"';
                      	else 
                      		$clas='';
                    ?>
                    <li <?php echo $clas?>><a href="user.php?order=<?php echo $_GET["order"]?>&nom=<?php echo $_GET["nom"]?>&pag=<?php echo $i?>"><?php echo $i+1?> <span class="sr-only">(current)</span></a></li>
                    <?php } ?>
                    <li>
                      <a href="user.php?order=<?php echo $_GET["order"]?>&nom=<?php echo $_GET["nom"]?>&pag=<?php echo $n?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>
              
              
              <!--div class="tab-pane animation-fade" id="my_contacts" role="tabpanel">
                <ul class="list-group">
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-online">
                          <img src="../../assets/portraits/13.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"> 
                          Sarah Graves
                          <small>Last Access: 1 hour ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 4190 W Lone Mountain Rd
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-away">
                          <img src="../../assets/portraits/14.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Andrew Hoffman
                          <small>Last Access: 2 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 2849 Spring St
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-success btn-default btn-sm">
                          <i class="icon wb-check" aria-hidden="true"></i>Following
                        </button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-busy">
                          <img src="../../assets/portraits/15.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Camila Lynch
                          <small>Last Access: 3 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 2128 W Campbell St
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-off">
                          <img src="../../assets/portraits/16.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Ramon Dunn
                          <small>Last Access: 4 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 7014 Pecan Acres Ln
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-online">
                          <img src="../../assets/portraits/17.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Scott Sanders
                          <small>Last Access: 5 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 2797 Airport St
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-success btn-default btn-sm">
                          <i class="icon wb-check" aria-hidden="true"></i>Following
                        </button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-away">
                          <img src="../../assets/portraits/18.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Nina Wells  
                          <small>Last Access: 6 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 1020 Crescent Canyon St
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-busy">
                          <img src="../../assets/portraits/19.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Beverly Grant
                          <small>Last Access: 7 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 3356 Crockett St
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-off">
                          <img src="../../assets/portraits/20.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Marvin Nelson
                          <small>Last Access: 8 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 1504 Mcgowen St
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-success btn-default btn-sm">
                          <i class="icon wb-check" aria-hidden="true"></i>Following
                        </button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-online">
                          <img src="../../assets/portraits/1.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Herman Beck
                          <small>Last Access: 9 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 5858 Abby Park St
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-away">
                          <img src="../../assets/portraits/2.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Mary Adams
                          <small>Last Access: 10 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 8901 Genschaw Rd
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-busy">
                          <img src="../../assets/portraits/3.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Caleb Richards
                          <small>Last Access: 11 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 7715 Washington Ave
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                </ul>
                <nav>
                  <ul class="pagination pagination-no-border">
                    <li>
                      <a href="javascript:void(0)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <li class="active"><a href="javascript:void(0)">1 <span class="sr-only">(current)</span></a></li>
                    <li><a href="javascript:void(0)">2</a></li>
                    <li><a href="javascript:void(0)">3</a></li>
                    <li><a href="javascript:void(0)">4</a></li>
                    <li><a href="javascript:void(0)">5</a></li>
                    <li>
                      <a href="javascript:void(0)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>

              <div class="tab-pane animation-fade" id="google_contacts" role="tabpanel">
                <ul class="list-group">
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-online">
                          <img src="../../assets/portraits/8.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Heather Harper
                          <small>Last Access: 1 hour ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 4393 Kelly Dr
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-success btn-default btn-sm">
                          <i class="icon wb-check" aria-hidden="true"></i>Following
                        </button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-away">
                          <img src="../../assets/portraits/9.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Willard Wood
                          <small>Last Access: 2 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 6524 W Craig Rd
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-success btn-default btn-sm">
                          <i class="icon wb-check" aria-hidden="true"></i>Following
                        </button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-busy">
                          <img src="../../assets/portraits/10.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Ronnie Ellis
                          <small>Last Access: 3 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 3045 Locust Rd
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-off">
                          <img src="../../assets/portraits/11.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Gwendolyn Wheeler
                          <small>Last Access: 4 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 4090 Rudder Rd
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-online">
                          <img src="../../assets/portraits/12.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Daniel Russell
                          <small>Last Access: 5 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 5899 Sable St
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-success btn-default btn-sm">
                          <i class="icon wb-check" aria-hidden="true"></i>Following
                        </button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-away">
                          <img src="../../assets/portraits/13.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Sarah Graves
                          <small>Last Access: 6 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 8954 Hamilton Ave
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-busy">
                          <img src="../../assets/portraits/14.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Andrew Hoffman
                          <small>Last Access: 7 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 6056 Airport Ave
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-off">
                          <img src="../../assets/portraits/15.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Camila Lynch
                          <small>Last Access: 8 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 7096 Fourth St
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-success btn-default btn-sm">
                          <i class="icon wb-check" aria-hidden="true"></i>Following
                        </button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-online">
                          <img src="../../assets/portraits/16.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Ramon Dunn
                          <small>Last Access: 9 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 6580 Pinecrest St
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-left">
                        <div class="avatar avatar-away">
                          <img src="../../assets/portraits/17.jpg" alt="...">
                          <i></i>
                        </div>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">
                          Scott Sanders
                          <small>Last Access: 10 hours ago</small>
                        </h4>
                        <p>
                          <i class="icon icon-color wb-map" aria-hidden="true"></i>                          Street 2674 Second St
                        </p>
                        <div>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-twitter" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
                          </a>
                          <a class="text-action" href="javascript:void(0)">
                            <i class="icon icon-color bd-dribbble" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <div class="media-right">
                        <button type="button" class="btn btn-outline btn-success btn-sm">Follow</button>
                      </div>
                    </div>
                  </li>
                </ul>
                <nav>
                  <ul class="pagination pagination-no-border">
                    <li>
                      <a href="javascript:void(0)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <li class="active"><a href="javascript:void(0)">1 <span class="sr-only">(current)</span></a></li>
                    <li><a href="javascript:void(0)">2</a></li>
                    <li><a href="javascript:void(0)">3</a></li>
                    <li><a href="javascript:void(0)">4</a></li>
                    <li><a href="javascript:void(0)">5</a></li>
                    <li>
                      <a href="javascript:void(0)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div-->
              
            </div>
          </div>
        </div>
      </div>
      
      <!-- End Panel -->
    </div>
  </div>
  <!-- End Page -->
  
<input id="crono" type="hidden">
<input id="pendnotis" type="hidden" value="<?php echo $not[0]?>"> 
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
  <script src="../../assets/js/plugins/responsive-tabs.js"></script>
  <script src="../../assets/js/components/tabs.js"></script>
  <!--script type='text/javascript' src="../js/bootstrap-slider.js"></script-->

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