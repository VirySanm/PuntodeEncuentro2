<?php
/**
 * Created by PhpStorm.
 * User: Viry
 * Date: 09/10/2015
 * Time: 01:08 PM
 */
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");

$usu=$_SESSION["iduser"];// session del usuario

$carpetaAdjunta="imagens/";

if($_SERVER['REQUEST_METHOD']=="DELETE"){
    parse_str(file_get_contents("php://input"),$datosDELETE);

    $img=$datosDELETE['key'];

    // funcion para eliminar imagenes
    imagenesdelete($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$usu,$img);

    unlink($carpetaAdjunta.$key);

    echo 0;
}