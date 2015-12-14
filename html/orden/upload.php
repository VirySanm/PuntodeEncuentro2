<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");

$carpetaAdjunta="../orden/imagens/";

$usu=$_SESSION["iduser"];// session del usuario 
$fecha=date("dmYHis");

$album=$_GET["idalbum"];// idalbum

//contar imagenes que envía por el plugin
$Imagenes=count($_FILES['imagenes']['name']);
for($i=0;$i<$Imagenes;$i++) {
    $ext=explode(".",$_FILES['imagenes']['name'][$i]);
    $nombreArchivo = $usu."_".$fecha."_".$album.".".$ext[1];
    $nombreTemporal = $_FILES['imagenes']['tmp_name'][$i];
    $rutaArchivo = $carpetaAdjunta.$nombreArchivo;

    //funcion para guardar las imagenes
    imagenessave($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$usu,$album,$nombreArchivo);

    // subir imagenes
    move_uploaded_file($nombreTemporal, $rutaArchivo);

    //$infoImagenesSubidas[$i]=array("caption"=>"$nombreArchivo","url"=>"../orden/borrar.php", "key"=>$nombreArchivo);
   // $ImagenesSubidas[$i]="<img src='$rutaArchivo' class='file-preview-image'>";

//$arr= array("file_id"=>0,"overwriteInitial"=>true,"initialPreview"=>$ImagenesSubidas);
//echo json_encode($arr);
}

  $tipo=2;// agregar usuario	 
  $fechahr=date("Y-m-d H:i:s");
  $str ="insert into notificaciones (iduserAct,iduserMov,tipoNotif,fechaHrNotif) values(".$_SESSION["iduser"].",".$_SESSION["iduser"].",".$tipo.",'".$fechahr."')";
  $Resu = mysql_query($str);

  echo $album;  


?>
