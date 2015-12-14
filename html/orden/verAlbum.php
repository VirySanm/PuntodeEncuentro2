<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
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
          if($_POST["idalbum"]==1) {
              $str = "select * from imagenes";
              $Res = mysql_query($str);
          }
          else{
              $str = "select * from imagenes where idalbum=".$_POST["idalbum"];
              $Res = mysql_query($str);
          }

          if (mysql_errno() > 0) {
              $strResultOp = "No fue posible validar el usuario.";
              $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
              $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
              $strParameters = $str;
              $h ="";
          } else {
              $h ='<ul class="blocks blocks-100 blocks-xlg-4 blocks-md-3 blocks-sm-2" data-filterable="true">';
              while ($row = mysql_fetch_array($Res)) {
                  $h .= '
                <li data-type="'.$row["idimg"].'">
                  <div class="widget widget-shadow">
                    <figure class="widget-header overlay-hover overlay">
                      <img class="overlay-figure overlay-scale" src="../../assets/photos/'.$row["img"].'" alt="...">
                      <figcaption class="overlay-panel overlay-background overlay-fade overlay-icon">
                        <a class="icon wb-search" href="../../assets/photos/'.$row["img"].'"></a>
                      </figcaption>
                    </figure>
                    <!--h4 class="widget-title">Animal Horse</h4-->
                  </div>
                </li>';
              }
              $h .= '</u>';
          }
      }
echo $h;