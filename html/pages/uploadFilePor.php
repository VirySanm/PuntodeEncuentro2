<?php
session_start();
sleep(3);
//Definimos valores y límites que deben ser respetados por las fotos a subir, tamaño en KBs y dimensiones del archivo, además del nombre y url para guardarlo

//define("maxUpload", 500000);
//define("maxWidth", 130);
//define("maxHeight", 130);
// la carpeta donde vamos a depositar nuestras fotos debe tener permisos de escritura 777
// De lo contrario obtendremos error
define("uploadURL", '../orden/imagens/');
//define("fileName", 'foto_');
//Como lo comenté anteriormente no solamente basta con validar la extensión del archivo en el javascript, para esto existe la definición de tipos de archivo MIME que simplemente es la descripción del archivo y que comúnmente se usa del lado del servidor y es necesaria para este ejemplo de jquery para fotos.

$fileType = array('image/jpeg','image/pjpeg','image/jpg','image/png');
//Creamos un par de baderas para saber cuando se sigue ejecutando el script jQuery para fotos y un mensaje inicial.

// Bandera para procesar las fotos si pasa el tamaño definido
$pasaImgSize = false;

//bandera de error al procesar las fotos
$respuestaFile = '';

// nombre por default de las fotos a subir
$fileName = '';

// error del lado del servidor
$mensajeFile = 'ERROR EN EL SCRIPT';
//Obtenemos la informacón del archivo que se esta subiendo, esto mediante la variable de servidor $_FILES[]

// Obtenemos los datos del archivo
$tamanio = $_FILES['userfile']['size'];
$tipo = $_FILES['userfile']['type'];
$archivo = $_FILES['userfile']['name'];

// Tamaño de la imagen
$imageSize = getimagesize($_FILES['userfile']['tmp_name']);
//Extraemos la extensión del nombre de archivo y generamos el nuevo nombre del mismo, si se dan cuenta estoy agregado una marca de tiempo, esto debido a que al cambiar el atributo src con javascript no refresca, de tal manera que si el nombre del archivo es diferente lo hace sin problema.

//Nota: La línea $imgFile = fileName.mktime().’.’.$extension[$num]; se modificó a $imgFile = fileName.time().’.’.$extension[$num];, esto enviaba un warning de php en tiempo de ejecución.

// Verificamos la extensión del archivo independiente del tipo mime
$extension = explode('.',$_FILES['userfile']['name']);
$num = count($extension)-1;

// Creamos el nombre del archivo dependiendo la opción
$usu=$_SESSION["iduser"];// session del usuario
$fecha=date("dmYHis");
$imgFile = $usu."_".$fecha."_2.".$extension[1];
//Validamos que el tamaño de la imagen sea correcto.

// Verificamos el tamaño válido para las fotos
//if($imageSize[0] <= maxWidth && $imageSize[1] <= maxHeight)
//    $pasaImgSize = true;
//Ahora lo que hacemos es verificar si la bandera del tamaño de imagen tiene valor TRUE y ejecutamos la validación de tipo y peso en KBs, verificamos si el archivo existe en la carpeta temporal del servidor y finalmennte comprobamos si se pudo copiar a la carpeta que definimos al principio del script.

// Verificamos el status de las dimensiones de la imagen a publicar mediante nuestro jQuery para fotos
//if($pasaImgSize == true)
//{

    // Verificamos Tamaño y extensiones
  //  if(in_array($tipo, $fileType) && $tamanio>0 && $tamanio<=maxUpload && ($extension[$num]=='jpg' || $extension[$num]=='png'))
    //{
        // Intentamos copiar el archivo
        if(is_uploaded_file($_FILES['userfile']['tmp_name']))
        {
                        // Verificamos si se pudo copiar el archivo a nustra carpeta
            if(move_uploaded_file($_FILES['userfile']['tmp_name'], uploadURL.$imgFile))
            {
                $respuestaFile = 'done';
                $fileName = $imgFile;
                $mensajeFile = $imgFile;
                //guardaravatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$fileName);
            }
            else
                // error del lado del servidor
                $mensajeFile = 'No se pudo subir el archivo';
        }
        else
            // error del lado del servidor
            $mensajeFile = 'No se pudo subir el archivo';
    //}
   // else
        // Error en el tamaño y tipo de imagen
  //      $mensajeFile = 'Verifique el tamaño y tipo de imagen (Max. 50Kb)';

//}
//else
    // Error en las dimensiones de la imagen
   // $mensajeFile = 'Verifique las dimensiones de la Imagen (Max. 130x130)';
//Armamos el array a convertir en cadena jSON y lo imprimimos.

$salidaJson = array("respuesta" => $respuestaFile,
                    "mensaje" => $mensajeFile,
                    "fileName" => $fileName,
                    "ancho"=>$imageSize[0],
                    "alto"=>$imageSize[1]);

echo json_encode($salidaJson);
?>