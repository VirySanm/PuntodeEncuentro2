<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
 /* if(!isset($_COOKIE['Email']) && !isset($_COOKIE['Epass'])){
    $mail="";
    $pass="";
    $sel="";
  }
  else{
    $mail=$_COOKIE['Email'];
    $pass=$_COOKIE['Epass'];
    $sel="checked";
    $dat=pasedirecto($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$mail,$pass);
    $_SESSION["iduser"]=$dat[0];
    $_SESSION["user"]=$dat[1];
}*/
?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">

  <title>Login | Remark Admin Template</title>

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
  <link rel="stylesheet" href="../../assets/css/pages/login.css">

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
  <script>
    Breakpoints();
    $(document).ready(function(){
    // mail='<?php //echo $mail ?>';
    // pass='<?php //echo $pass ?>';
     //sel='<?php //echo $sel ?>';  
     /*
      if(mail!="" && pass!="" && sel!="")
      {
        document.location.href="profile.php";
      }*/
    });
  </script>
</head>
<body class="page-login layout-full page-dark">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


  <!-- Page -->
  <div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
  data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
      <div class="brand">
        <img class="brand-img" src="../../assets/images/logo.png" alt="...">
        <h2 class="brand-text">Punto de Encuentro</h2>
      </div>
      <p>Cambia el Password que se te envio a tu correo, <br> por uno de tu preferencia</p>
        <div class="form-group">
          <label class="sr-only" for="inputEmail">Email</label>
          <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
        </div>
        <div class="form-group">
          <label class="sr-only" for="inputPassword">Password Anterior</label>
          <input type="password" class="form-control" id="inputPasswordant" name="password" placeholder="Password Anterior">
        </div>
        <div class="form-group">
          <label class="sr-only" for="inputPassword">Password Nuevo</label>
          <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password Nuevo">
        </div>
        <div class="form-group">
          <label class="sr-only" for="inputPassword">Confirmar Password Nuevo</label>
          <input type="password" class="form-control" id="inputPasswordconf" name="password" placeholder="Confirmar Password Nuevo">
        </div>
        <div class="form-group clearfix">
          <div class="checkbox-custom checkbox-inline checkbox-primary pull-left">
            <input type="checkbox" id="inputCheckbox" name="remember">
            <label for="inputCheckbox">Recordar</label>
          </div>
          
        </div>
        <div id="result"></div>
        <button id="change" class="btn btn-primary btn-block">Guardar y Entrar</button>
        
      <footer class="page-copyright page-copyright-inverse">
        <p>Sitio de Punto de Encuentro</p>
        <p>© 2015. Derechos Reservados.</p>
        <div class="social"><a href="javascript:void(0)"> <em class="icon bd-twitter" aria-hidden="true"></em> </a> <a href="javascript:void(0)"> <em class="icon bd-facebook" aria-hidden="true"></em> </a> <a href="javascript:void(0)"> <em class="icon bd-dribbble" aria-hidden="true"></em> </a></div>
      </footer>
    </div>
  </div>
  <!-- End Page -->


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
  <script src="../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

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
  <script src="../../assets/js/components/jquery-placeholder.js"></script>

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