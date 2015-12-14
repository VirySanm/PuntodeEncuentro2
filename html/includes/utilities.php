<?php
/**
 * Created by PhpStorm.
 * User: Viry
 * Date: 06/10/2015
 * Time: 01:41 PM
 */
include("configuration.php");

// function para validar usuario
function validar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$mail, $pass, $record,$rec){
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
        $str ="select *from user where mailUser='".$mail."' and passUser=password('".$pass."')";
        $Res = mysql_query($str);

        if(mysql_errno()>0){
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
            $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
            $strParameters=$str;
            $html="";
        }
        else
        {
            $html="";
            while($row=mysql_fetch_array($Res)){
                $html=$row["nomUser"];
                $_SESSION["user"]=$row["nomUser"];
                $_SESSION["iduser"]=$row["iduser"];
                if($record==1) {
                   // if(!isset($_COOKIE['Email']) && !isset($_COOKIE['Epass'])){
                        setcookie("Email",$row["mailUser"],time()+ 31536000,'/');
                        setcookie("Epass",$pass,time()+ 31536000,'/');
                        setcookie("Erecor",$rec,time()+ 31536000,'/');
                  //  }
                }
                else{
                     setcookie("Email",$row["mailUser"],time() + 86400,'/');
                     setcookie("Epass",$pass,time() + 86400,'/');
                }

                $strsq ="select *from actividad where iduser=".$row["iduser"];
                $Resu= mysql_query($strsq);

                $fecha= date("Y-m-d H:i:s");
                if(mysql_num_rows($Resu)==0) {

                    $strS = "insert into actividad (fechaconex,iduser) values('".$fecha."',".$row["iduser"].")";
                    $ResS = mysql_query($strS);
                }
                else{
                    $strS ="update actividad set fechaconex='".$fecha."' where iduser=".$_SESSION["iduser"];
                    $ResS = mysql_query($strS);
                }
            }
        }
    }
    return $html;
}
//function para pasar directo
function pasedirecto($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$mail,$pass){
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
		$str ="select *from user where mailUser='".$mail."' and passUser=password('".$pass."')";
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
			  $usus[0]=$row["iduser"];
			  $usus[1]=$row["nomUser"];
			}
		}
	}
	return $usus;
}
// function para registrar usuario
function registrar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$nom,$mail,$cel,$pass){
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
        $str ="insert into user (nomUser,mailUser,celUser,passUser) values('".$nom."','".$mail."','".$cel."', password('".$pass."'))";
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
        	$strs ="Select *from user where mailUser='".$mail."' and celUser='".$cel."' and passUser=password('".$pass."')";
        	$Ress = mysql_query($strs);
        	$row=mysql_fetch_array($Ress);
        	
        	$hoy=date("Y-m-j H:i:s");
        	$hoyhr=date("H:i:s");
        	
        	$fin = strtotime ( '+30 day' , strtotime ( $hoy ) ) ;
        	$fin = date ( 'Y-m-j' , $fin );
        	$fin = $fin." ".$hoyhr;
        	
        	$strq ="insert into lineaCredito (iduser,iniVigencia,finvigencia,tipoMens) values(".$row["iduser"].",'".$hoy."','".$fin."',1)";
        	$Resq = mysql_query($strq);
            $html=1;
        }
    }
    return $html;
}
// function para restaurar contraseña
function restaurar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$mail){
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
        $str ="select *from user where mailUser='".$mail."'";
        $Res = mysql_query($str);

        if(mysql_errno()>0) {
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
            $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
            $strParameters = $str;
            $html= "0";// no conexion
        }
        else
        {
            if(mysql_num_rows($Res)>0){
                $passnew=getRandomCode();
                $strSql ="update user set passUser=password('".$passnew."') where mailUser='".$mail."'";
                $Result = mysql_query($strSql);
               
                $html=mailrestaurar($mail,$passnew); // enviar mail al usuario para reestablecer contraseña
                // se encontro usuario
            }
            else
                $html="2"; // no se encontro usuario
        }
    }
    return $html;
}
//enviar x mail una contraseña aleatoria
function mailrestaurar($email,$passnew){
	require_once('../mail/class.phpmailer.php');
	
	require("../mail/class.smtp.php");
	$mail = new phpmailer();
	$mail->PluginDir = '../mail/';
	
	$mail-> SMTPSecure = "tls";
	$mail-> Host = "smtp.gmail.com";
	$mail-> SMTPAuth = true;
	$mail-> Username = "virysanm@gmail.com";
	$mail-> Password = "viry0704";
	$mail-> Port = 587; //puerto de autenticacion que usa gmail
	
	$mail->AddAddress($email);
	
	
	$mail-> IsHTML = true;
	$mail-> MsgHTML ('Recuperacion de Password <br><br> Punto de Encuentro te envia el siguiente Password, para que puedas entrar a tu usuario<br><br>Password: '.$passnew.'<br><br> Ingresa a este Link: http://proyectospi.com/PuntodeEncuentroP/html/pages/changepassword.php <br><br>para Ingresar a tu sesion con la Password que te enviamos en este correo.');
	
	$mail->SetFrom ("virysanm@gmail.com","Punto de Encuentro");
	$mail­>Subject == "Recuperacion de Password";
	
	//indico destinatario
	$exito = $mail->Send();
	if(!$exito) {
		echo "Error al enviar: " . $mail­>ErrorInfo;
	} else {
		echo "Ok";
	}
}
// function para cambiar contraseña
function chanpass($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$mail,$passant,$passnew,$recordar,$reco){
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
		$strSql ="update user set passUser=password('".$passnew."') where mailUser='".$mail."' and passUser=password('".trim($passant)."')";
		$Result = mysql_query($strSql);

		if(mysql_errno()>0) {
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
			$strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
			$strParameters = $str;
			$html= "0";// no conexion
		}
		else
		{     
			$str ="select *from user where mailUser='".$mail."' and passUser=password('".$passnew."')";
			$Res = mysql_query($str);
			$html="";
            while($row=mysql_fetch_array($Res)){
		        $html=$row["nomUser"];
                $_SESSION["user"]=$row["nomUser"];
                $_SESSION["iduser"]=$row["iduser"];
                if($recordar==1) {
                     //if(!isset($_COOKIE['Email']) && !isset($_COOKIE['Epass']) && !isset($_COOKIE['Erecor'])){
                        setcookie("Email",$row["mailUser"],time()+ 31536000,'/');
                        setcookie("Epass",$passnew,time()+ 31536000,'/');
                        setcookie("Erecor",$reco,time()+ 31536000,'/');
                   // }
                }
                else{

                    setcookie('Email', $row["mailUser"], time() + 86400,'/'); // eliminar cokies en un dia
                    setcookie('Epass', $passnew, time() + 86400,'/');  
                }

                $strsq ="select *from actividad where iduser=".$row["iduser"];
                $Resu= mysql_query($strsq);

                $fecha= date("Y-m-d H:i:s");
                if(mysql_num_rows($Resu)==0) {

                    $strS = "insert into actividad (fechaconex,iduser) values('".$fecha."',".$row["iduser"].")";
                    $ResS = mysql_query($strS);
                }
                else{
                    $str ="update actividad set fechaconex='".$fecha."' where iduser=".$_SESSION["iduser"];
                    $Res = mysql_query($str);
                }
            }	
		}
	}
	return $html;
}
//funcion para generar una contraseña al intentar restaurarla
function getRandomCode(){
    $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $su = strlen($an) - 1;
    return substr($an, rand(0, $su), 1) .
    substr($an, rand(0, $su), 1) .
    substr($an, rand(0, $su), 1) .
    substr($an, rand(0, $su), 1) .
    substr($an, rand(0, $su), 1) .
    substr($an, rand(0, $su), 1);
}

// function para guardar album
function ultimoAlbumUser($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$usu,$album,$coment){
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
    	    $strSql ="select *from album where iduser=".$usu." ORDER BY idalbum DESC LIMIT 0,1";
            $Result = mysql_query($strSql);
            $row=$row=mysql_fetch_array($Result);

            $ultimo=$row["idalbum"]+1;

        if(mysql_errno()>0){
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
            $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
            $strParameters=$str;
            $ultimo=0;
        }
        else
        {

        	$str ="insert into album (idalbum,iduser,album,comentario) values(".$ultimo.",".$usu.",'".$album."','".$coment."')";
        	$Res = mysql_query($str);
        	
            //$ultimo=$ultimo;
        }
        $act=actalbuns($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$ultimo);
    }
    return $ultimo."&".$act;
}
// actualizar lista de albums
function actalbuns($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$idalbum){
$html='  <script src="../js/jquery-1.10.1.js"></script>  
        <script src="../js/java.js"></script>
	<ol class="breadcrumb">
	</ol>
	<h1 class="page-title">Fotos</h1>
	<div class="page-header-actions">';
		if($idalbum!=1 && $idalbum!=2){
			
	       $html.=' <a class="btn btn-sm btn-inverse btn-round" id="agregarfotos" title="'.$idalbum.'">
	          <i class="icon bd-dropbox" aria-hidden="true"></i>
	          <span class="hidden-xs">Agregar Fotos</span>
	        </a>';
	         }
	        $html.='<a class="btn btn-sm btn-inverse btn-round" id="nuevoalbum" title="0">
	          <i class="icon bd-dropbox" aria-hidden="true"></i>
	          <span class="hidden-xs">Nuevo Album</span>
	        </a>';
	      
	      $html.='</div>
	
	      <ul class="nav nav-tabs nav-tabs-line" role="tablist">';
	  
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
	        $str ="select * from album where iduser=".$_SESSION["iduser"]." and estatusalbum=0";
	        $Res = mysql_query($str);
	
	        if(mysql_errno()>0){
	          $strResultOp = "No fue posible validar el usuario.";
	          $strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
	          $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
	          $strParameters=$str;
	          $ultimo=0;
	       }
	       else
	       {
	         while($row=mysql_fetch_array($Res)){
	          if($row["idalbum"]==$idalbum){
	             $activo='class="active"';
	
	        $html.='<li '.$activo.' role="presentation">
	          <a class="albumnes" id="'.$row["idalbum"].'" role="tab" data-filter="*">'.$row["album"].'</a>
	        </li>';
	        } else {
	        $html.='<li role="presentation">
	          <a class="albumnes" id="'.$row["idalbum"].'"  role="tab" data-filter="object">'.$row["album"].'</a>
	        </li>';
	           }
	         } 
	       }
	     } 
	   $html.='</ul>';
	   
	return $html;
}

// function para guardar imagenes
function imagenessave($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$usu,$album,$img){
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
        $str ="insert into imagenes (idalbum,iduser,img) values(".$album.",".$usu.",'".$img."')";
        $Res = mysql_query($str);

        if(mysql_errno()>0){
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
            $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
            $strParameters=$str;
            $img=0;
        }
        else
        {
            $img=1;
        }
    }
    return $img;
}

// function para borrar logicamente imagen
function imagenesdelete($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$usu,$img){
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
        $str ="update imagenes set estatusimg=2 where iduser=".$usu." and img='".$img."'";
        $Res = mysql_query($str);

        if(mysql_errno()>0){
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
            $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
            $strParameters=$str;
            $imgen=0;
        }
        else
        {
            $imgen=1;
        }
    }
    return $imgen;
}

// function de album para saber comentario
function comentalbum($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$idalbum){
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
        $str ="select *from album where idalbum=".$idalbum;
        $Res = mysql_query($str);

        if(mysql_errno()>0) {
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
            $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
            $strParameters = $str;
            $datosalbum= "";// no conexion
        }
        else
        {
            while($row=mysql_fetch_array($Res)){
                $datosalbum[0]=$row["album"];
                $datosalbum[1]=$row["comentario"];
            }
        }
    }
    return $datosalbum;
}

// function de album para saber si existe
function existealbum($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$idalbum){
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
        $str ="select *from album where idalbum=".$idalbum;
        $Res = mysql_query($str);

        if(mysql_errno()>0) {
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
            $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
            $strParameters = $str;
            $exisalbum= 0;// no conexion
        }
        else
        {
            if(mysql_num_rows($Res)>0){
                $exisalbum=1;
            }
            else{
                $exisalbum=0;
            }
        }
    }
    return $exisalbum;
}
// function para guardar red
function guardarred($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$red,$tipo){
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
        if($tipo!="mobile" && $tipo!="envelope") {
            $str = "select *from redes";
            $Res = mysql_query($str);

            if (mysql_errno() > 0) {
                $strResultOp = "No fue posible validar el usuario.";
                $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
                $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
                $strParameters = $str;
                $corto = "No";// no conexion
            } else {
                $r = 0;
                while ($row = mysql_fetch_array($Res)) {
                    if ($r == 0) {
                        $pos = strpos($red, $row["red"]);
                        if ($pos !== false) {

                            $strsq = "select *from redessociales where iduser=" . $_SESSION["iduser"] . " and nomcorto='" . $row["red"] . "'";
                            $Resul = mysql_query($strsq);

                            if (mysql_num_rows($Resul) == 0) {

                                $strS = "insert into redessociales (iduser,red, nomcorto) values(" . $_SESSION["iduser"] . ",'" . $red . "','" . $row["red"] . "')";
                                $Resu = mysql_query($strS);

                                $corto = $row["red"];
                                $r = 1;
                            } else {
                                $r = 1;
                                $corto = "Ya";
                            }
                        } else {
                            $corto = "";
                        }
                    }
                }
            }
            $strsql = "select *from redessociales where iduser=".$_SESSION["iduser"]." and red='".$red."'";
            $Result = mysql_query($strsql);
            $row=mysql_fetch_array($Result);
            $total=$corto."&".$row["idredsoc"];
        }
        else{
            $strS = "insert into redessociales (iduser,red, nomcorto) values(".$_SESSION["iduser"].",'" . $red . "','" . $tipo . "')";
            $Resu = mysql_query($strS);
            if (mysql_errno() > 0) {
                $strResultOp = "No fue posible validar el usuario.";
                $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
                $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
                $strParameters = $str;
                $corto = "No&";// no conexion
            }
            else {

                $corto = "Si";
            }

            $strsql = "select *from redessociales where iduser=".$_SESSION["iduser"]." and red='".$red."'";
            $Result = mysql_query($strsql);
            $row=mysql_fetch_array($Result);
            $total=$corto."&".$row["idredsoc"];
        }
    }
    return $total;
}

// function para guardar perfil
function guardarperfil($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $sobremi, $dia, $mes, $annio, $sexo, $profe){
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
        $strS ="select *from perfiluser where iduser=".$_SESSION["iduser"];
        $Resu = mysql_query($strS);

        if(mysql_num_rows($Resu)==0) {
            $str = "insert into perfiluser (iduser,dianac,mesnac,anionac,sexo,profesion,sobremi) values(" . $_SESSION["iduser"] . "," . $dia . "," . $mes . "," . $annio . ",'" . $sexo . "','" . $profe . "','" . $sobremi . "')";
            $Res = mysql_query($str);
        }
        else{
            $str = "update perfiluser set dianac=".$dia.", mesnac=".$mes.", anionac=".$annio.", sexo='".$sexo."', profesion='".$profe."', sobremi='". $sobremi ."' where iduser=". $_SESSION["iduser"];
            $Res = mysql_query($str);
        }

        if(mysql_errno()>0){
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
            $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
            $strParameters=$str;
            $img=0;
        }
        else
        {
            $img=1;
        }
    }
    return $img;
}

// function para extraer los datos de perfil
function datosPerfil($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$iduser){
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
        $str ="select *from perfiluser where iduser=".$iduser;
        $Res = mysql_query($str);

        if(mysql_errno()>0) {
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
            $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
            $strParameters = $str;
            $exisalbum= 0;// no conexion
        }
        else
        {
            while($row=mysql_fetch_array($Res)) {
                $datos[0] = $row["sobremi"];
                $datos[1] = $row["dianac"];
                $datos[2] = $row["mesnac"];
                $datos[3] = $row["anionac"];
                $datos[4] = $row["sexo"];
                $datos[5] = $row["profesion"];
                
                $strs ="SELECT count(iduserAdo) as agregado FROM agregados where iduserAdo=".$iduser;
                $Ress = mysql_query($strs);
                $raw=mysql_fetch_array($Ress);
                
                $datos[6] = $raw["agregado"];

                $strsq ="SELECT count(iduserAgo) as agrego FROM agregados where iduserAgo=".$iduser;
                $Ressq = mysql_query($strsq);
                $rew=mysql_fetch_array($Ressq);
                
                $datos[7] = $rew["agrego"];
                
                $strsql ="SELECT DATE_FORMAT(fechaHRVisita,'%d-%m-%Y') as fecha, iduservisitante FROM visitas where iduservisitado=".$iduser." group by fecha";
                $Ressql = mysql_query($strsql);
                if(mysql_num_rows($Ressql)>0)
                  $num= mysql_num_rows($Ressql); 
                else
                  $num= 0;
                $datos[8] = $num;
                
                $datos[9] = $row["km"];
                $datos[10] = $row["edad"];
                $datos[11] = $row["presex"];
                $datos[12] = $row["localizacion"];
                
                $strsqls ="SELECT * FROM lineaCredito where iduser=".$iduser;
                $Ressqls = mysql_query($strsqls);
                $ruw=mysql_fetch_array($Ressqls);
                
                $datos[17]= mysql_num_rows($Ressqls);

                $datos[13] = $ruw["iniVigencia"];
                $datos[14] = $ruw["finvigencia"];
                $datos[15] = $ruw["tipoMens"];
                
                $st ="SELECT count(iduserAgo) as agrego FROM agregados where iduserAgo=".$iduser." and fecha >='".$datos[13]."' and fecha<'".$datos[14]."'";
                $Re = mysql_query($st);
                $rw=mysql_fetch_array($Re);
                
                $datos[16] = $rw["agrego"];

                $strU ="select *from user where iduser=".$iduser;
                $ResU = mysql_query($strU);
                $mc=mysql_fetch_array($ResU);

                $datos[18] = $mc["mailUser"];
                $datos[19] = $mc["celUser"];

            }
        }
    }
    return $datos;
}

// function para saber la foto de perfil
function avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$iduser){
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
        $str ="select *from imagenes where estatusimg=0 and tipo=1 and iduser=".$iduser;
        $Res = mysql_query($str);

        if(mysql_errno()>0) {
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
            $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
            $strParameters = $str;
            $exisalbum= 0;// no conexion
        }
        else
        {
            if(mysql_num_rows($Res)==0)
            {
                $ava="../orden/imagens/user.png";
            }
            else
            {
                while($row=mysql_fetch_array($Res))
                {
                    $ava="../orden/imagens/".$row["img"];
                }
            }
        }
    }
    return $ava;
}

// function para saber la foto de perfil
function portada($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$iduser){
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
        $str ="select *from imagenes where estatusimg=0 and tipo=2 and iduser=".$iduser;
        $Res = mysql_query($str);

        if(mysql_errno()>0) {
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
            $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
            $strParameters = $str;
            $exisalbum= 0;// no conexion
        }
        else
        {
            if(mysql_num_rows($Res)==0)
            {
                $ava="orden/imagens/login.jpg";
            }
            else
            {
                while($row=mysql_fetch_array($Res))
                {
                    $ava="orden/imagens/".$row["img"];
                }
            }
        }
    }
    return $ava;
}

// function para borrar red, cel, mail
function borrarred($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$id){
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
        $str ="update redessociales set estatusRS=1 where idredsoc=".$id;
        $Res = mysql_query($str);

        if(mysql_errno()>0) {
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
            $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
            $strParameters = $str;
            $exisalbum= 0;// no conexion
        }
        else
        {
            $exisalbum=1;
        }
    }
    return $exisalbum;
}

// function para guardar actividad
function actividad($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL){
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
        $fecha=date("Y-m-d H:i:s");
        $str ="update actividad set fechaconex='".$fecha."' where iduser=".$_SESSION["iduser"];
        $Res = mysql_query($str);
    }
} 
// function para saber tiempo de actividad
function timeactividad($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$iduser){
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
        $str ="select *from actividad where iduser=".$iduser;
        $Res = mysql_query($str);

        $row=mysql_fetch_array($Res);
    }
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
    

    return $time;
}

function restaFechas($dFecIni, $dFecFin){
	$dFecIni = str_replace("-","",$dFecIni);
	$dFecIni = str_replace("/","",$dFecIni);
	$dFecFin = str_replace("-","",$dFecFin);
	$dFecFin = str_replace("/","",$dFecFin);

	ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
	ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

	$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
	$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);

	return round(($date2 - $date1) / (60 * 60 * 24));
}
function RestarHoras($horaini,$horafin)
{
    $hi=explode(":",$horaini);
    $horai=$hi[0];
    $mini=$hi[1];
    $segi=$hi[2];

    $hf=explode(":",$horafin);
    $horaf=$hf[0];
    $minf=$hf[1];
    $segf=$hf[2];

    $ini=((($horai*60)*60)+($mini*60)+$segi);
    $fin=((($horaf*60)*60)+($minf*60)+$segf);
    
    $dif=$fin-$ini;
    
    if($dif<0)
    	$dif=floor($dif/3600);
    
    return $dif;

   /* $difh=floor($dif/3600);
    $difm=floor(($dif-($difh*3600))/60);
    $difs=$dif-($difm*60)-($difh*3600);

     date("H:i:s",mktime($difh,$difm,$difs));*/
}

// function para desbloquear session
function reactivarsession($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$pass){
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
        $str ="select *from user where passUser=password('".$pass."') and iduser=".$_SESSION["iduser"];
        $Res = mysql_query($str);

        if(mysql_errno()>0) {
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[" . mysql_errno() . "-" . mysql_error() . "]";
            $strModulo = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF']);
            $strParameters = $str;
            $datos= 0;// no conexion
        }
        else
        {
            if($row=mysql_num_rows($Res)>0){
                $datos=1;
            }
        }
    }
    return $datos;
}
// function para saber si hay albumnes
function abumprincipal($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$usu){
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
		$strS ="select * from album where iduser=".$usu;
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$html=0;
		}
		else
		{	
            if($row=mysql_num_rows($Res)>0){
                $html=1;
            }
		}
	}
	return $html;
}
// function para guardar km y edad
function savekmyedad($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$valor,$tipo){
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
		$strS ="select *from perfiluser where iduser=".$_SESSION["iduser"];
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$html=0;
		}
		else
		{	
			$row = mysql_fetch_array($Res);
			$r=0;
            if(mysql_num_rows($Res)>0){
            	if($tipo==1)
            	{
            	 if($row["km"]!=$valor)
            	 {
            	  $str ="update perfiluser set km=".$valor." where iduser=".$_SESSION["iduser"];
            	  $Ress = mysql_query($str);
            	  $html=1;
            	  $r++;
            	 }
            	 else 
            	 {
            	  $html=2;            	 	
            	 }
            	}
            	else{
            	 if($row["edad"]!=$valor)
            	 {
            	  $str ="update perfiluser set edad=".$valor." where iduser=".$_SESSION["iduser"];
            	  $Ress = mysql_query($str);
            	  $html=1;
            	  $r++;
            	 }
            	 else {
            	   $html=2;            	 	
            	 }
            	}
            }
            else{
            	if($tipo==1)
            	{
            	 if($row["km"]!=$valor)
            	 {
            	  $strss = "insert into perfiluser (iduser, km) values(" . $_SESSION["iduser"] . ",".$valor.")";
            	  $Ress = mysql_query($strss);
            	  $html=1;
            	 }
            	 else 
            	 {
            	  $html=2;            	 	
            	 }
            	}
            	else
            	{
            	 if($row["edad"]!=$valor)
            	 {
            	  $strss = "insert into perfiluser (iduser, edad) values(" . $_SESSION["iduser"] . ",".$valor.")";
            	  $Ress = mysql_query($strss);
            	  $html=1;
            	 }
            	 else 
            	 {
            	   $html=2;            	 	
            	 }
              }
		   }
		}
	}
	return $tipo."-".$row["km"]."-".$html."-".$r;
}

// function para guardar km y edad
function savekmyedad2($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$km,$edad,$sex){
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
		$strS ="select *from perfiluser where iduser=".$_SESSION["iduser"];
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$html=0;
		}
		else
		{
			if(mysql_num_rows($Res)>0){
			     $str ="update perfiluser set km=".$km.", edad=".$edad.", presex='".$sex."' where iduser=".$_SESSION["iduser"];
				 $Ress = mysql_query($str);
				 $html=1;				
			}
			else{
				 $strss = "insert into perfiluser (iduser, km, edad, presex) values(" . $_SESSION["iduser"] . ",".$km.",".$edad.",'".$sex."')";
				 $Ress = mysql_query($strss);
				 $html=1;
		   }
		}
	}
    $obtenerlatlongAll=obtenerlatlongAll($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
     $tam=substr_count($obtenerlatlongAll,"&");
	return $obtenerlatlongAll."/-/".$tam;
}
// function para guardar ubicacion
function saveubicacion($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$latitud,$longitud,$rango){
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
		 $strS ="select *from ubicacion where iduser=".$_SESSION["iduser"];
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$html=0;
		}
		else
		{	
            if($row=mysql_num_rows($Res)>0){
              $str ="update ubicacion set latitud='".$latitud."', longitud='".$longitud."', rango=".$rango." where iduser=".$_SESSION["iduser"];
              $Res = mysql_query($str);
            }
            else{
              $strs = "insert into ubicacion (iduser, latitud, longitud, rango) values(".$_SESSION["iduser"].",'".$latitud."','".$longitud."',".$rango.")";
              $Ress = mysql_query($strs);
           }
		}
	 }
}

// function para obtener ubicacion
function obtenerlatlong($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL){
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
		$strS ="select us.nomUser, u.latitud, u.longitud from user us, ubicacion u where us.iduser=u.iduser and us.estatusUser=0 and us.iduser=".$_SESSION["iduser"];
		$Res = mysql_query($strS);

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
				$ubi[0]=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_SESSION["iduser"]);
				$ubi[1]=$row["latitud"];
				$ubi[2]=$row["longitud"];
			}
		}
	}
	return $ubi;
}

// function para obtener nombre de usarios
function nombreusus($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $usu){
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
		$strS ="select *from user where iduser=".$usu;
		$Res = mysql_query($strS);

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
				$usunom=$row["nomUser"];
			}
		}
	}
	return $usunom;
}
// function para obtener ubicación de todos los usuarios
function obtenerlatlongAll($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL){
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
		$datosPerfil=datosPerfil($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $_SESSION["iduser"]);
		if($datosPerfil[11]=="todos")
		  $prefe="";
		else 
		  $prefe="and p.sexo ='".$datosPerfil[11]."'";		
		$anno=date("Y");
        
		$str="SELECT u.iduser,u.latitud,u.longitud,p.sobremi,p.anionac,(6371 * ACOS(SIN(RADIANS(u.latitud)) * SIN(RADIANS(19.4456375))+ COS(RADIANS(u.longitud - -99.119641)) * COS(RADIANS(u.latitud)) * COS(RADIANS(19.4456375))
               )) AS distance FROM ubicacion u, perfiluser p where u.iduser=p.iduser and ((".$anno."- p.anionac) <= ".$datosPerfil[10].") ".$prefe." and u.iduser!=".$_SESSION["iduser"]." HAVING distance <= ".$datosPerfil[9]." ORDER BY distance ASC";
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
				
				$avatar=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduser"]);
				$tiempoact=timeactividad($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduser"]);
				//$timeactividad=explode(",",$tiempoact);
				$nombreusers=nombreusus($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduser"]);
				$km=number_format($row["distance"],2);
				$row["sobremi"]=str_replace(",",";",$row["sobremi"]);
				$ubi.=$nombreusers.",".$avatar.",".$row["latitud"].",".$row["longitud"].",".$km.",".$tiempoact.",".$row["sobremi"].",".$tiempoact.",".$row["iduser"]."&";				
			}
		}
	}
	return $ubi;
}

/// function para guardar colonia
function savecol($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $direccion){
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
		$strS ="update perfiluser set localizacion='".$direccion."' where iduser=".$_SESSION["iduser"];
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$html=0;
		}
		else
		{
			$html=1;
		}
	}
	return $html;
}

/// function para guardar colonia
function localizacion($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $usu){
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
		$strS ="select *from perfiluser where iduser=".$usu;
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
				$localizacion=$row["localizacion"];
			}
		}
	}
	return $localizacion;
}

/// function para aregar usuario
function agregarusu($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $usu){
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
	  $datosPerfil=datosPerfil($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $_SESSION["iduser"]);
	 if($datosPerfil[17]>0)
	 {	  	
	  if(($datosPerfil[15]==1 && $datosPerfil[16]<12) || $datosPerfil[15]=2)
	  {		
	  	$fecha=date("Y-m-d H:i:s");
		$strS ="insert into agregados (iduserAgo,iduserAdo,fecha) values(".$_SESSION["iduser"].",".$usu.",'".$fecha."')";
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h=0;
		}
		else
		{
		    $tipo=1;// agregar usuario	
	        $fechahr=date("Y-m-d H:i:s");
			$str ="insert into notificaciones (iduserAct,iduserMov,tipoNotif,fechaHrNotif) values(".$usu.",".$_SESSION["iduser"].",".$tipo.",'".$fechahr."')";
			$Resu = mysql_query($str);
			$h=1;
		}
	  }
	  else{
	  	$fechahr=date("Y-m-d H:i:s");
	  	if(($datosPerfil[15]==1 || $datosPerfil[15]==2) && $datosPerfil[14]<$fechahr)
	  	  $h=2; // suscripcion vencida
	  	else  
	  	  	if($datosPerfil[15]==1 && $datosPerfil[16]==12)
	  	  		$h=3; // susc.ilimitada pero ya agrego a 12 contactos
	  }
	 }
	 else{
	 	$h=4; // no tiene suscripcion 
	 }
	}
	return $h;
}

/// function para saber si usuario esta o no agregado
function usuconfir($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $usu){
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
		$strS ="select *from agregados where iduserAdo=".$usu." and estatusAgr=0 and iduserAgo=".$_SESSION["iduser"];
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h=0;
		}
		else
		{
			if(mysql_num_rows($Res)>0){
			 $h=1;
			}
			else {
				$h=0; 
			}
			
		}
	}
	return $h;
}

/// function para ver notificaciones
function notificaciones($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL){
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
		/*$str ="select count(idnotif) as total from notificaciones n, tiponotificacion t where n.tipoNotif=t.idtipoNotif
			   and ((iduserMov!=".$_SESSION["iduser"]." and iduserAct=".$_SESSION["iduser"].") or (iduserMov!=".$_SESSION["iduser"]." and iduserAct!=".$_SESSION["iduser"].")) and estatusNotif=0 group by idnotif order by fechaHrNotif desc";
		$Resu = mysql_query($str);*/
		
		$strS ="select tipoNotif, descripcion, iduserMov, iduserAct, fechaHrNotif, idnotif, idcomentario from notificaciones n, tiponotificacion t where n.tipoNotif=t.idtipoNotif
				and ((iduserMov!=".$_SESSION["iduser"]." and iduserAct=".$_SESSION["iduser"].") or (iduserMov!=".$_SESSION["iduser"]." and iduserAct!=".$_SESSION["iduser"].")) and estatusNotif=0 group by idnotif order by fechaHrNotif desc";
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$notif="";
		}
		else
		{
			
			   $total=0;
			

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
					  		$time="Ahora";
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
				$desc.=$row["descripcion"].",".$row["iduserMov"].",".$time.",".$row["tipoNotif"].",".$row["idnotif"].",".$row["iduserAct"].",".$row["idcomentario"].",".$row["fechaHrNotif"]."&";
				$confirmarusuado=usuconfir($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduserMov"]);
                $fechaagregado=fechaagregado($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduserMov"]);
                if(($confirmarusuado==0 && $row["iduserAct"]==$_SESSION["iduser"] && ($row["tipoNotif"]==1 || $row["tipoNotif"]==6)) || ($confirmarusuado==1 && $fechaagregado <= $row["fechaHrNotif"] && $row["iduserAct"]==$_SESSION["iduser"])){
				    $total++;
				}
			}
			$notif=$total.";".$desc; 
		}
	}
	return $notif;
}
/// obtener obtener el numero de album de las uttimas imagenes subidas del usuario
function fechaagregado($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$usu){
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
        $strS ="SELECT * FROM agregados where iduserAgo=".$usu." and iduserAdo=".$_SESSION["iduser"];
        $Res = mysql_query($strS);

        if(mysql_errno()>0){
            $strResultOp = "No fue posible validar el usuario.";
            $strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
            $strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
            $strParameters=$str;
            $h=0;
        }
        else
        {
            while($row=mysql_fetch_array($Res)){
               $h=$row["fecha"];
            }   
        }
    }
    return $h;
}
/// obtener obtener el numero de album de las uttimas imagenes subidas del usuario
function albumultimaimg($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $usu){
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
		$strS ="SELECT * FROM imagenes where iduser=".$usu." and idalbum!=1 and idalbum!=2 order by idimg desc limit 0,1";
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h=0;
		}
		else
		{
			while($row=mysql_fetch_array($Res)){
			   $h=$row["idalbum"];
			}	
		}
	}
	return $h;
}

/// notificacion vista
function notifvista($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $noti){
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
		$strS ="update notificaciones set estatusNotif=1 where idnotif=".$noti;
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h=0;
		}
		else
		{
				$h=1;
		}
	}
	return $h;
}

/// borrar imagen
function borrarimg($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $id){
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
		$strS ="update imagenes set estatusimg=2 where idimg=".$id;
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h=0;
		}
		else
		{
			$h=1;
		}
	}
	return $h;
}

/// convertir imagen de album en portada
function imgaportada($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $id,$img){
	$link=mysql_connect($strHostMYSQL, $strUserMYSQL, $strPWDMYSQL);
	mysql_select_db($strDBMYSQL,$link);
	if(mysql_errno()>0)
	{
		$strResultOp = "No fue posible validar el usuario.";
		$strInfoTec = "No fue posible localizar el host[".mysql_errno()."-".mysql_error()."]";
		$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
		$strParameters= "host:".$strHostMYSQL."~-user:".$strUserMYSQL."~PWD:".$strPWDMYSQL."bd:".$strDBMYSQL;
		$h=0;
	}
	else
	{
		$st="select *from imagenes where idimg=".$id;
		$r=mysql_query($st);
		$rew=mysql_fetch_array($r);
		if($rew["tipo"]==2)
		{

			$query = "update imagenes set estatusimg=1 where tipo=2 and estatusimg!=2 and iduser=" . $_SESSION["iduser"];
			$res = mysql_query($query);
			
			$querys = "update imagenes set estatusimg=0 where idimg=".$id;
			$ress = mysql_query($querys);
			
			$tipo=4;// generar notificacion
			$fechahr=date("Y-m-d H:i:s");
			$str ="insert into notificaciones (iduserAct,iduserMov,tipoNotif,fechaHrNotif) values(".$_SESSION["iduser"].",".$_SESSION["iduser"].",".$tipo.",'".$fechahr."')";
			$Resu = mysql_query($str);
			$h=1; 
		}	
		else 
		{
			$query = "update imagenes set estatusimg=1 where tipo=2 and estatusimg!=2 and iduser=" . $_SESSION["iduser"];
			$res = mysql_query($query);
			
			$querys = "insert into imagenes (iduser,img,tipo,idalbum) values(" . $_SESSION["iduser"] . ",'" . $img . "',2,2)";
        	$ress = mysql_query($querys);
        	
        	$tipo=4;// generar notificacion
        	$fechahr=date("Y-m-d H:i:s");
        	$str ="insert into notificaciones (iduserAct,iduserMov,tipoNotif,fechaHrNotif) values(".$_SESSION["iduser"].",".$_SESSION["iduser"].",".$tipo.",'".$fechahr."')";
        	$Resu = mysql_query($str);
			$h=1;
		}
	}
	return $h;
}

/// convertir imagen de album en perfil
function imgaperfil($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $id,$img){
	$link=mysql_connect($strHostMYSQL, $strUserMYSQL, $strPWDMYSQL);
	mysql_select_db($strDBMYSQL,$link);
	if(mysql_errno()>0)
	{
		$strResultOp = "No fue posible validar el usuario.";
		$strInfoTec = "No fue posible localizar el host[".mysql_errno()."-".mysql_error()."]";
		$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
		$strParameters= "host:".$strHostMYSQL."~-user:".$strUserMYSQL."~PWD:".$strPWDMYSQL."bd:".$strDBMYSQL;
		$h=0;
	}
	else
	{
		$st="select *from imagenes where idimg=".$id;
		$r=mysql_query($st);
		$rew=mysql_fetch_array($r);
		if($rew["tipo"]==1)
		{
			$query = "update imagenes set estatusimg=1 where tipo=1 and estatusimg!=2 and iduser=" . $_SESSION["iduser"];
			$res = mysql_query($query);

			$querys = "update imagenes set estatusimg=0 where idimg=".$id;
			$ress = mysql_query($querys);
			
			$tipo=3;// generar una notificacion
			$fechahr=date("Y-m-d H:i:s");
			$str ="insert into notificaciones (iduserAct,iduserMov,tipoNotif,fechaHrNotif) values(".$_SESSION["iduser"].",".$_SESSION["iduser"].",".$tipo.",'".$fechahr."')";
			$Resu = mysql_query($str);
			$h=1; 
		}	
		else 
		{
			$query = "update imagenes set estatusimg=1 where tipo=1 and estatusimg!=2 and iduser=" . $_SESSION["iduser"];
	    	$res = mysql_query($query);
			
	    	$querys = "insert into imagenes (iduser,img,tipo,idalbum) values(" . $_SESSION["iduser"] . ",'" . $img . "',1,1)";
        	$ress = mysql_query($querys);
        	
        	$tipo=3;// generar una notificacion 
        	$fechahr=date("Y-m-d H:i:s");
        	$str ="insert into notificaciones (iduserAct,iduserMov,tipoNotif,fechaHrNotif) values(".$_SESSION["iduser"].",".$_SESSION["iduser"].",".$tipo.",'".$fechahr."')";
        	$Resu = mysql_query($str);
			$h=1;
	  }
	}
	return $h;
}
/// guardar comentario
function savecoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$idalbum,$idimg,$iduser,$coment){
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
		$fecha=date("Y-m-d H:i:s");
		$strS ="insert into comentarios (iduser,idalbum,idimg,comentario,fechaHR)values(".$_SESSION["iduser"].",".$idalbum.",".$idimg.",'".$coment."','".$fecha."')";
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h=0;
		}
		else
		{
			if($iduser==0)
			   $tipo=5;// mensaje
			else 
				$tipo=6;//comentario en foto
			$strSq ="select *from comentarios where iduser=".$_SESSION["iduser"]." order by idcomentario desc limit 1";
			$Resq = mysql_query($strSq);
			$rew=mysql_fetch_array($Resq);
			
			$fechahr=date("Y-m-d H:i:s");
			$str ="insert into notificaciones (iduserAct,iduserMov,tipoNotif,fechaHrNotif,idcomentario) values(".$iduser.",".$_SESSION["iduser"].",".$tipo.",'".$fechahr."',".$rew["idcomentario"].")";
			$Resu = mysql_query($str);
			
			$h=1;
		}
	}
	return $h;
}

/// para saber el ultimo comentario en foto(album)
function vercoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$iduser,$idcomentario){
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
		$strS ="select * from comentarios where iduser=".$iduser." and estatuscoment=0 and idcomentario=".$idcomentario;
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h=0;
		}
		else
		{
			  while($row=mysql_fetch_array($Res))
			  {
				$h[0]=$row["idalbum"];
				$h[1]=$row["idimg"];
			 }
		}
	}
	return $h;
}
/// para ver foto que comentaron 
function verfotocoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$idimg){
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
		$strS ="select * from imagenes where idimg=".$idimg." and estatusimg=0";
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h=0;
		}
		else
		{
			if(mysql_num_rows($Res)==0)
			{
				$h="../orden/imagens/eliminada.jpg";
			}
			else
			{
			  while($row=mysql_fetch_array($Res))
			  {
				$h="../orden/imagens/".$row["img"];
			  }
			}
		}
	}
	return $h;
}
/// guardar visita
function visita($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$iduser, $idvisitado){
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
		$fecha=date("Y-m-d H:i:s");
		$strS ="insert into visitas (iduservisitante,iduservisitado,fechaHrVisita) values(".$iduser.",".$idvisitado.",'".$fecha."')";
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h=0;
		}
		else
		{
			$h=1;
		}
	}
	return $h;
}

/// total de user
function totaluser($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $nom){
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
		$strS ="SELECT count(u.iduser) as total FROM ubicacion u, perfiluser p, user us, actividad a where u.iduser=p.iduser and u.iduser=us.iduser and u.iduser=a.iduser and u.iduser!=".$_SESSION["iduser"]." ".$nom;
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h=0;
		}
		else
		{
			$row=mysql_fetch_array($Res);
			$h=$row["total"];
		}
	}
	return $h;
}
/// borrar album
function deletealbum($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $album){
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
		$strS ="update album set estatusalbum=1 where idalbum=".$album." and iduser=".$_SESSION["iduser"];
		$Res = mysql_query($strS);
		$str ="update imagenes set estatusimg=1 where idalbum=".$album." and iduser=".$_SESSION["iduser"];
		$Resu= mysql_query($str);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h=0;
		}
		else
		{
			$h=1;
		}
	}
	return $h;
}

function redim($ruta1,$ruta2,$ancho,$alto)
{
	# se obtene la dimension y tipo de imagen
	$datos=getimagesize ($ruta1);
	 
	$ancho_orig = $datos[0]; # Anchura de la imagen original
	$alto_orig = $datos[1];    # Altura de la imagen original
	$tipo = $datos[2];
	 
	if ($tipo==1){ # GIF
		if (function_exists("imagecreatefromgif"))
			$img = imagecreatefromgif($ruta1);
			else
				return false;
	}
	else if ($tipo==2){ # JPG
		if (function_exists("imagecreatefromjpeg"))
			$img = imagecreatefromjpeg($ruta1);
			else
				return false;
	}
	else if ($tipo==3){ # PNG
		if (function_exists("imagecreatefrompng"))
			$img = imagecreatefrompng($ruta1);
			else
				return false;
	}
	 
	# Se calculan las nuevas dimensiones de la imagen
	if ($ancho_orig>$alto_orig)
	{
		$ancho_dest=$ancho;
		$alto_dest=($ancho_dest/$ancho_orig)*$alto_orig;
	}
	else
	{
		$alto_dest=$alto;
		$ancho_dest=($alto_dest/$alto_orig)*$ancho_orig;
	}

	// imagecreatetruecolor, solo estan en G.D. 2.0.1 con PHP 4.0.6+
	$img2=@imagecreatetruecolor($ancho_dest,$alto_dest) or $img2=imagecreate($ancho_dest,$alto_dest);

	// Redimensionar
	// imagecopyresampled, solo estan en G.D. 2.0.1 con PHP 4.0.6+
	@imagecopyresampled($img2,$img,0,0,0,0,$ancho_dest,$alto_dest,$ancho_orig,$alto_orig) or imagecopyresized($img2,$img,0,0,0,0,$ancho_dest,$alto_dest,$ancho_orig,$alto_orig);

	// Crear fichero nuevo, según extensión.
	if ($tipo==1) // GIF
		if (function_exists("imagegif"))
			imagegif($img2, $ruta2);
		else
			return false;

		if ($tipo==2) // JPG
			if (function_exists("imagejpeg"))
				imagejpeg($img2, $ruta2);
			else
				return false;

			if ($tipo==3)  // PNG
				if (function_exists("imagepng"))
					imagepng($img2, $ruta2);
				else
					return false;
				 
				return true;
}