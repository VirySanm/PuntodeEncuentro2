<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
$datosPerfil=datosPerfil($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $_SESSION["iduser"]);
$h= '
  <script src="../js/jquery-1.10.1.js"></script>
  <script src="../js/java.js"></script>

    <div class="col-md-9">
      <div class="panel">
        <div class="panel-body nav-tabs-animate">
          <h3 class="page-title">Perfil de Usuario </h3><br>
            <div class="col-lg-12"><br>
              <label class="col-lg-4 control-label">Sobre mi:</label>
                <div class="col-lg-7">
                   <textarea class="form-control" id="sobremi" placeholder="Escribe algo sobre ti (1000 caracteres max)" rows="5" cols="30">'.$datosPerfil[0].'</textarea>
                </div>
            </div>
            <div class="col-lg-12"><br>
              <label class="col-lg-4 control-label">Fecha de Nacimiento:</label>

                <div class="col-lg-7" style="padding-right: 0px">

                  <div class="col-lg-3" style="padding-left: 0px;">
                    <select id="dia" class="form-control">';
                     for($i=1;$i<32;$i++){
                      if($i==1 || $i==$datosPerfil[1])
                        $h.='<option value="'.$i.'" selected>'.$i.'</option>';
                      else
                        $h.='<option value="'.$i.'">'.$i.'</option>';
                     }
                     $h.='
                    </select>&nbsp;&nbsp;
                  </div>

                  <div class="col-lg-5" style="padding-left: 0px;">
                    <select id="mes" class="form-control">';
                     for($i=1;$i<13;$i++){
                        $mes=date('F', mktime(0, 0, 0, $i, 1, date("Y") ) );
                        if ($mes=="January") $mes="Enero";
                        if ($mes=="February") $mes="Febrero";
                        if ($mes=="March") $mes="Marzo";
                        if ($mes=="April") $mes="Abril";
                        if ($mes=="May") $mes="Mayo";
                        if ($mes=="June") $mes="Junio";
                        if ($mes=="July") $mes="Julio";
                        if ($mes=="August") $mes="Agosto";
                        if ($mes=="September") $mes="Septiembre";
                        if ($mes=="October") $mes="Octubre";
                        if ($mes=="November") $mes="Noviembre";
                        if ($mes=="December") $mes="Diciembre";
                        if($i==1 || $i==$datosPerfil[2]) {
                            $h .= '<option value="' . $i . '" selected>' . $mes . '</option>';
                        }
                        else {
                            $h .= '<option value="' . $i . '">' . $mes . '</option>';
                        }
                    }
                    $h.='</select>&nbsp;&nbsp;
                  </div>

                  <div class="col-lg-4" style="padding-left: 0px;">
                    <select id="annio" class="form-control">';
                    $j=date("Y");
                    $k=$j-80;
                    for($i=$j;$i>$k;$i--){
                      if($i==$j || $i==$datosPerfil[3])
                          $h.='<option value="'.$i.'" selected>'.$i.'</option>';
                      else
                        $h.='<option value="'.$i.'">'.$i.'</option>';
                    }
                    $h.='
                    </select>
                  </div>
                </div>
            </div>
            <div class="col-lg-12"><br>
              <label class="col-lg-4 control-label">Sexo:</label>
              <div class="col-lg-8">
                <select id="sexo" class="form-control" style="width: 110px; height: 35px">';

                if($datosPerfil[4]=="Hombre"){
                    $select="selected";
                }
                else
                {
                    $select="";
                }
                if($datosPerfil[4]=="Mujer"){
                    $select="selected";
                }
                else
                {
                    $select="";
                }

                $h.= ' <option value="Hombre" '.$select.'>Hombre</option>
                 <option value="Mujer" '.$select.'>Mujer</option>
                </select>
              </div>
            </div>
            <div class="col-lg-12"><br>
              <label class="col-lg-4 control-label">Profesi&oacute;n:</label>
              <div class="col-lg-7" style="padding-right: 0px">
                <input type="text" id="profe" class="form-control" placeholder="Profesion o Empleo (Opcional)" value="'.$datosPerfil[5].'">
              </div> 
              		
            </div>
            <div class="col-lg-12" style="text-align: right"><br>
                <a id="guardarperfil"><button class="btn btn-primary"> Guardar </button></a>&nbsp;&nbsp;
                <a href="profile.php"><button class="btn btn-primary"> Cancelar </button></a>
            </div>
            <div class="profile-social" id="result">
              </div>
            <div class="col-lg-12"><br>
             <label class="col-lg-6 control-label">Agregar Medios para Contactarte:</label>
              </div>
            <div class="col-lg-12"><br>
              <label class="col-lg-4 control-label">Redes Sociales:</label>
              <div class="col-lg-7" style="padding-right: 0px">
                <input type="text" id="red" class="form-control" placeholder="Ej: https://www.facebook.com/usuario (Opcional)" value="">
              </div>
              <div class="col-lg-1" id="addr">
                <a id="addred" title="Agregar Red Social"><img src="../icons/plus.png" width="30px" height="30px"></a>
              </div>
            </div>
            <div class="col-lg-12"><br>
             <label class="col-lg-4 control-label">Redes Sociales Agregadas:</label>
              <div class="col-lg-8" style="padding-right: 0px">
              <div class="profile-social" id="redesEP" style="margin-top:0px;text-align:left">';
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
                    $str = "select *from redessociales where nomcorto!='mobile' and nomcorto!='envelope' and estatusRS=0 and iduser=".$_SESSION["iduser"];
                    $Res = mysql_query($str);

                    if (mysql_errno() > 0) {
                        $strResultOp = "No fue posible validar el usuario.";
                        $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
                        $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
                        $strParameters = $str;
                    }
                    else {
                        while ($row = mysql_fetch_array($Res)) {

                            $h.='<a class="icon bd-'.$row["nomcorto"].'"  href="'.$row["red"].'" target="_blank"  style="padding-top: 0px" id="pp'.$row["idredsoc"].'"></a><a class="borrarM" id="'.$row["idredsoc"].'"><img src="../icons/cancel.png" width="15px" height="15px"></a>';

                        }
                    }
                }
              $h.='</div>
                </div>
            </div>
           <div class="col-lg-12"><br>
              <label class="col-lg-4 control-label">Celular:</label>
              <div class="col-lg-7" style="padding-right: 0px">
                <input type="text" id="cel" class="form-control" placeholder="(Opcional)" value="">
              </div>
              <div class="col-lg-1" id="addc">
                <a id="addcel" title="Agregar Celular"><img src="../icons/plus.png" width="30px" height="30px"></a>
              </div>
           </div>

            <div class="col-lg-12"><br>
             <label class="col-lg-4 control-label">Celulares Agregados:</label>
              <div class="col-lg-8" style="padding-right: 0px">
              <div id="celAG" style="margin-top:0px;text-align:left">';
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
                    $str = "select *from redessociales where  nomcorto='mobile' and estatusRS=0 and iduser=".$_SESSION["iduser"];
                    $Res = mysql_query($str);

                    if (mysql_errno() > 0) {
                        $strResultOp = "No fue posible validar el usuario.";
                        $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
                        $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
                        $strParameters = $str;
                    }
                    else {
                        while ($row = mysql_fetch_array($Res)) {

                            $h.='<b class="icon wb-'.$row["nomcorto"].'" style="padding-top: 0px" id="pp'.$row["idredsoc"].'">&nbsp;&nbsp;'.$row["red"].'</b>&nbsp;&nbsp;<a class="borrarM" id="'.$row["idredsoc"].'"><img src="../icons/cancel.png" width="15px" height="15px"></a><br>';
                        }
                    }
                }
                $h.='</div>
                </div>
            </div>
           <div class="col-lg-12"><br>
              <label class="col-lg-4 control-label">E-Mail:</label>
              <div class="col-lg-7" style="padding-right: 0px">
                <input type="text" id="mail" class="form-control" placeholder="(Opcional)" value="">
              </div>
              <div class="col-lg-1" id="addm">
                <a id="addmail" title="Agregar E-Mail"><img src="../icons/plus.png" width="30px" height="30px"></a>
              </div>
           </div>
           <div class="col-lg-12"><br>
             <label class="col-lg-4 control-label">E-Mail Agregados:</label>
              <div class="col-lg-8" style="padding-right: 0px">
              <div id="mailAG" style="margin-top:0px;text-align:left">';
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
                    $str = "select *from redessociales where nomcorto='envelope' and estatusRS=0 and iduser=".$_SESSION["iduser"];
                    $Res = mysql_query($str);

                    if (mysql_errno() > 0) {
                        $strResultOp = "No fue posible validar el usuario.";
                        $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
                        $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
                        $strParameters = $str;
                    }
                    else {
                        while ($row = mysql_fetch_array($Res)) {

                            $h.='<b class="icon wb-'.$row["nomcorto"].'" style="padding-top: 0px" id="pp'.$row["idredsoc"].'">&nbsp;&nbsp;'.$row["red"].'</b>&nbsp;&nbsp;<a class="borrarM" id="'.$row["idredsoc"].'"><img src="../icons/cancel.png" width="15px" height="15px"></a><br>';
                        }
                    }
                }
                $h.='</div>
                </div>
            </div>
        </div>
      </div>
    </div>';

echo $h;
?>