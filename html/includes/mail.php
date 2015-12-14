<?php
/**
 * Created by PhpStorm.
 * User: Viry
 * Date: 17/11/2015
 * Time: 01:42 PM
 */
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

$mail->AddAddress("vsanmartin@plumidea.com");


$mail-> IsHTML = true;
$mail-> MsgHTML ('Recuperacion de Contraseña <br><br> Contraseña: <br><br> Ingresa a este Link: http://proyectospi.com/PuntodeEncuentroP/html/pages/forgot-password.html <br><br>para Ingresar a tu sesion con la contraseña que te enviamos en este correo.');

$mail->SetFrom ("virysanm@gmail.com","Punto de Encuentro");
$mail­>Subject == "Recuperacion de Contraseña";

//indico destinatario 
 $exito = $mail->Send();
if(!$exito) {
	echo "Error al enviar: " . $mail­>ErrorInfo;
} else {
	echo "Mensaje enviado!";
}