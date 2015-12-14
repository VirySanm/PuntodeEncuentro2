<?php
session_start();
include("../includes/configuration.php");

    $portada=$_POST["portada"];

    $link=mysql_connect($strHostMYSQL, $strUserMYSQL, $strPWDMYSQL);
    mysql_select_db($strDBMYSQL,$link);
            if(mysql_errno()>0)
            {
                $strResultOp = "No fue posible validar el usuario.";
                $strInfoTec = "No fue posible localizar el host[".mysql_errno()."-".mysql_error()."]";
                $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
                $strParameters= "host:".$strHostMYSQL."~-user:".$strUserMYSQL."~PWD:".$strPWDMYSQL;
            }
            else {//estatus 0= activo, 1= desactivado, 2= eliminado // tipo 1= perfil, 2=portada

            	$strS ="select * from album where iduser=".$_SESSION["iduser"];
            	$ResS = mysql_query($strS);
            	
            	if(mysql_num_rows($ResS)==0){

            		$strsq ="insert into album (idalbum,iduser,album,comentario) values(1,".$_SESSION["iduser"].",'Perfil','Fotos de Perfil')";
            		$Resq = mysql_query($strsq);

            		$strqs ="insert into album (idalbum,iduser,album,comentario) values(2,".$_SESSION["iduser"].",'Portada','Fotos de Portada')";
            		$Resqs = mysql_query($strqs);
            	}            	
	                $query = "update imagenes set estatusimg=1 where tipo=2 and estatusimg!=2 and iduser=" . $_SESSION["iduser"];
	                $res = mysql_query($query);
	
	                $querys = "insert into imagenes (iduser,img,tipo,idalbum) values(" . $_SESSION["iduser"] . ",'" . $portada . "',2,2)";
                    $ress = mysql_query($querys);

                    $tipo=4;// generar una notificacion
                    $fechahr=date("Y-m-d H:i:s");
                    $str ="insert into notificaciones (iduserAct,iduserMov,tipoNotif,fechaHrNotif) values(".$_SESSION["iduser"].",".$_SESSION["iduser"].",".$tipo.",'".$fechahr."')";
                    $Resu = mysql_query($str);
				
                if (mysql_errno() > 0) {
                    $strResultOp = "No fue posible validar el usuario.";
                    $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
                    $strParameters = $query;
                    // echo "Error de Conectividad";
                    //echo $strInfoTec;
                }
            }