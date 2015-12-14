<?php
session_start();
include("../includes/configuration.php");

    $avatar=$_POST["avatar"];

    $link=mysql_connect($strHostMYSQL, $strUserMYSQL, $strPWDMYSQL);
    mysql_select_db($strDBMYSQL,$link);
            if(mysql_errno()>0)
            {
                $strResultOp = "No fue posible validar el usuario.";
                $strInfoTec = "No fue posible localizar el host[".mysql_errno()."-".mysql_error()."]";
                $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                $strParameters= "host:".$strHostMYSQL."~-user:".$strUserMYSQL."~PWD:".$strPWDMYSQL;
            }
            else { //estatus 0= activo, 1= desactivado, 2= eliminado // tipo 1= perfil, 2=portada
                    $query = "update imagenes set estatusimg=1 where tipo=1 and estatusimg!=2 and iduser=" . $_SESSION["iduser"];
                    $res = mysql_query($query);

                    $querys = "insert into imagenes (iduser,img,tipo,idalbum) values(" . $_SESSION["iduser"] . ",'" . $avatar . "',1,1)";
                    $ress = mysql_query($querys);
                    
                    $tipo=2;// generar notificacion
		        	$fechahr=date("Y-m-d H:i:s");
		        	$str ="insert into notificaciones (iduserAct,iduserMov,tipoNotif,fechaHrNotif) values(".$_SESSION["iduser"].",".$_SESSION["iduser"].",".$tipo.",'".$fechahr."')";
		        	$Resu = mysql_query($str);

                if (mysql_errno() > 0) {
                    $strResultOp = "No fue posible validar el usuario.";
                    $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
                    $strParameters = $query;
                    // echo "Error de Conectividad";
                    echo $strInfoTec;
                }
            }