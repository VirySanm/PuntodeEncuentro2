<?php
session_start();
include("utilities.php");
// validar usuario
if($_POST["num"]==0){
    echo validar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["email"], $_POST["pass"], $_POST["recordar"], $_POST["reco"]);
}
// registrar usuario
if($_POST["num"]==1){
    echo registrar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["nom"],$_POST["email"],$_POST["cel"],$_POST["pass"]);
}
// cerrar session de usuario
if($_POST["num"]==2){
    unset($_SESSION["user"]);
}
// restaurar password
if($_POST["num"]==3){
    echo restaurar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["email"]);
}
// guardar album
if($_POST["num"]==4){
    echo ultimoAlbumUser($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $_SESSION["iduser"],$_POST["album"],$_POST["coment"]);
}
// guardar red, cel, mail
if($_POST["num"]==5){
    echo guardarred($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $_POST["red"], $_POST["tipo"]);
}
// guardar perfil
if($_POST["num"]==6){
    echo guardarperfil($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $_POST["sobremi"], $_POST["dia"], $_POST["mes"], $_POST["annio"], $_POST["sexo"], $_POST["profe"], $_POST["kmm"]);
}
// borrar contacto, red, cel, mail
if($_POST["num"]==7){
    echo borrarred($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $_POST["id"]);
}
// actividad
if($_POST["num"]==8){
    echo actividad($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
}
// tiempo actividad
if($_POST["num"]==9){
    echo timeactividad($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_SESSION["iduser"]);
}
// tiempo actividad 
if($_POST["num"]==10){
    echo reactivarsession($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["pass"]);
}
// dejar de recordar usuario
if($_POST["num"]==11){
    setcookie('Erecor', '', time() - 60,'/'); // empty value and old timestamp
}
// guardar km y edad
if($_POST["num"]==12){
    echo savekmyedad($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["valor"],$_POST["tipo"]);
}
// guardar ubicacion
if($_POST["num"]==13){
	echo saveubicacion($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["latitud"],$_POST["longitud"],$_POST["rango"]);
}
// guardar km y edad
if($_POST["num"]==14){
    echo savekmyedad2($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["km"],$_POST["edad"],$_POST["sex"]);
}
// guardar colonia
if($_POST["num"]==15){
    echo savecol($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["direccion"]);
}
// agregar usuario
if($_POST["num"]==16){
    echo agregarusu($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["usu"]);
}
// obtener notificaciones
if($_POST["num"]==17){
    echo notificaciones($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
}
// obtener obtener el numero de album de las uttimas imagenes subidas del usuario
if($_POST["num"]==18){
    echo albumultimaimg($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["usu"]);
}
// obtener obtener el numero de album de las uttimas imagenes subidas del usuario
if($_POST["num"]==19){
    echo notifvista($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["noti"]);
}
// obtener obtener el numero de album de las uttimas imagenes subidas del usuario
if($_POST["num"]==20){
	echo borrarimg($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["id"]);
}
// convertir imagen de album a portada
if($_POST["num"]==21){
	echo imgaportada($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["id"],$_POST["img"]);
}
// convertir imagen de album a perfil
if($_POST["num"]==22){
	// Tamaño de la imagen
	//$imageSize = getimagesize("../orden/imagens/".$_POST["img"]);
	//if($imageSize[0] <= 130 && $imageSize[1] <= 130)
//	{
		echo imgaperfil($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["id"],$_POST["img"]);
	//}
	//else 
	//{
		//echo "2"; 	
	//}
}
// guardar comentario
if($_POST["num"]==23){
	echo savecoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["idalbum"],$_POST["idimg"],$_POST["iduser"],$_POST["coment"]);
}
// ver comentarios
if($_POST["num"]==24){
	echo vercoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["idalbum"],$_POST["idimg"]);
}
// cambiar password
if($_POST["num"]==25){
	echo chanpass($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["email"], $_POST["passant"], $_POST["passnew"], $_POST["recordar"], $_POST["reco"]);
}
//borrar album
if($_POST["num"]==26){
	echo deletealbum($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST["id"]);
}

