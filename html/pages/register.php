<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">

  <title>Registrar | Punto de Encuentro</title>

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
  <link rel="stylesheet" href="../../assets/css/pages/register.css">

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
  </script>
</head>
<body class="page-register layout-full page-dark">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


  <!-- Page -->
  <div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
  data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
      <div class="brand">
        <img class="brand-img" src="../../assets/images/logo.png" alt="...">
        <h2 class="brand-text">PUNTO DE ENCUENTRO</h2>
      </div>
      <p>Ingresa tus datos</p>
      <form>
        <div class="form-group">
          <label class="sr-only" for="inputName">Name</label>
          <input type="text" class="form-control" id="inputName" name="name" placeholder="Nombre">
        </div>
        <div class="form-group">
          <label class="sr-only" for="inputEmail">Email</label>
          <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
        </div>
        <div class="form-group">
          <label class="sr-only" for="inputCelular">Celular</label>
          <input type="celular" class="form-control" id="inputCelular" name="celular" placeholder="Celular">
        </div>
        <div class="form-group">
          <label class="sr-only" for="inputPassword">Password</label>
          <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Contraseña">
        </div>
        <div class="form-group">
          <label class="sr-only" for="inputPasswordCheck">Retype Password</label>
          <input type="password" class="form-control" id="inputPasswordCheck" name="passwordCheck" placeholder="Confirmar contraseña">
          <div id="result"></div>
        </div>
        <button id="registro" class="btn btn-primary btn-block">Registrar</button>
      </form>
      <p>¿Ya tienes cuenta? Entonces puedes <a href="login.html">Entrar</a></p>

      <footer class="page-copyright page-copyright-inverse">
        <p>PUNTO DE ENCUENTRO</p>
        <p>© 2015. All RIGHT RESERVED.</p>
        <div class="social">
          <a href="javascript:void(0)">
            <i class="icon bd-twitter" aria-hidden="true"></i>
          </a>
          <a href="javascript:void(0)">
            <i class="icon bd-facebook" aria-hidden="true"></i>
          </a>
          <a href="javascript:void(0)">
            <i class="icon bd-dribbble" aria-hidden="true"></i>
          </a>
        </div>
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
  <script src="../../assets/js/components/animate-list.js"></script>

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