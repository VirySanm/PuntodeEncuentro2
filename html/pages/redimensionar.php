<?php
 ## CONFIGURACION ############################# 

    # ruta de la imagen a redimensionar 
    $nombreimagen='../orden/imagens/1_20112015165254_1.jpg'; 
    # ruta de la imagen final, si se pone el mismo nombre que la imagen, esta se sobreescribe 
    $nuevonombreimagen='../orden/imagens/1_20112015165254_1.jpg'; 
    $nuevoancho=200; 
    $nuevoalto=200; 

## FIN CONFIGURACION ############################# 
    
 function string_pos( $substr, $s ){
  $p = strpos( $s, $substr );
  if($p===false) return -1;
  return $p;
 }

 function obtener_extension( $s ){
  $s = strtolower( $s );
  if( string_pos( '.', $s ) == -1 ) return "";
  $r = '';
  for( $i = strlen( $s )-1; $i>=0; $i-- )
    if( $s[$i] == '.' ) break;
    else $r = $s[$i] . $r;
  return $r;
 }

 function obtener_nombre_sin_extension( $s ){
  $r = '';
  for( $i=0; $i<strlen($s); $i++ ){
    if( $s[$i] == '.' ) break;
    else $r .= $s[$i];
  }
  return $r;
 }

 function es_png( $nombreimagen ){
   return string_pos( '.png', strtolower($nombreimagen) ) != -1;
 }



 // Version que redimensiona al nuevo ancho y alto que le pasemos por parametro
 function redimensionar_imagen( $nombreimagen, $nuevonombreimagen, $nuevoancho, $nuevoalto ){
  if(!file_exists( $nombreimagen ) ) return false;

  $png = es_png( $nombreimagen );

  if( $png )
      $im_original = imagecreatefrompng( $nombreimagen ); 
  else
      $im_original = imagecreatefromjpeg( $nombreimagen ); 

  $ancho = imagesx( $im_original );
  $alto = imagesy( $im_original ); 

  if( $png ){
      imagealphablending( $im_original, false ); // Transparencia
      imagesavealpha( $im_original, true );
  }

  $im = imagecreatetruecolor( $nuevoancho, $nuevoalto);

  if( $png ){
      imagealphablending( $im, false );
      imagesavealpha( $im, true );
      $color = imagecolorallocatealpha( $im, 255, 255, 255, 127 );
      imagefilledrectangle( $im, 0, 0, $ancho, $alto, $color );
  }

  imagecopyresampled( $im, $im_original, 0, 0, 0, 0, $nuevoancho, $nuevoalto, $ancho, $alto );
  imagedestroy( $im_original );

  $png? imagepng( $im, $nuevonombreimagen ) : imagejpeg( $im, $nuevonombreimagen );

  imagedestroy( $im );
  return file_exists( $nuevonombreimagen );
 }


 // Redimensionar imagen manteniendo la proporcion de la imagen original 
 // Valores posibles de "$proporcion":
 // 'a14' = aumentar un cuarto, 'a24' = aumentar 2 cuartos, 'a34' = aumentar 3 cuartos, 'a44' = aumentar el doble
 // 'r14' = reducir un cuarto, 'r24' = reducir a la mitad, 'r34' = reducir 3 cuartos
 function redimensionar_imagen_proporcionalmente( $nombreimagen, $nuevonombreimagen, $proporcion='' ){
  if(!file_exists( $nombreimagen ) ) return false;

  list( $ancho, $alto ) = getimagesize( $nombreimagen );

  if( $proporcion == 'r14' ){ // Reducir un cuarto
      $nuevoancho = $ancho - abs( $ancho / 4 );
      $nuevoalto = $alto - abs( $alto / 4 );
  }
  elseif( $proporcion == 'r24' ){ // Reducir a la mitad
      $nuevoancho = abs( $ancho / 2 );
      $nuevoalto = abs( $alto / 2 );
  }
  elseif( $proporcion == 'r34' ){ // Reducir 3 cuartos
      $nuevoancho = $ancho - abs( 3* $ancho / 4 );
      $nuevoalto = $alto - abs( 3* $alto / 4 );
  }
  elseif( $proporcion == 'a14' ){ // Aumentar un cuarto
      $nuevoancho = $ancho + abs( $ancho / 4 );
      $nuevoalto = $alto + abs( $alto / 4 );
  }
  elseif( $proporcion == 'a24' ){ // Aumentar 2 cuartos
      $nuevoancho = $ancho + abs( 2* $ancho / 4 );
      $nuevoalto = $alto + abs( 2* $alto / 4 );
  }
  elseif( $proporcion == 'a34' ){ // Aumentar 3 cuartos
      $nuevoancho = $ancho + abs( 3* $ancho / 4 );
      $nuevoalto = $alto + abs( 3* $alto / 4 );
  }
  elseif( $proporcion == 'a44' ){ // Aumentar a la mitad
      $nuevoancho = 2 * $ancho;
      $nuevoalto = 2 * $alto;
  }
  else{
      // Por defecto se reduce a la mitad
      $nuevoancho = abs( $ancho / 2 );
      $nuevoalto = abs( $alto / 2 );
  }

  return redimensionar_imagen( $nombreimagen, $nuevonombreimagen, $nuevoancho, $nuevoalto );
 }

 $extension = obtener_extension( $nombreimagen );
 $nombre_sin_extension = obtener_nombre_sin_extension( $nombreimagen );
 $nuevonombreimagen = 'redimensionadas/' . $nombre_sin_extension . '-' . $proporcion . '.' . $extension;

 if( !file_exists( $nuevonombreimagen ) ) // Si no esta cacheada la creo y la guardo en cache
     redimensionar_imagen_proporcionalmente( 'imagenes/' . $nombreimagen, $nuevonombreimagen, $proporcion );

 // Finalmente muestro la imagen redimensionada de la cache
 if( file_exists( $nuevonombreimagen ) ){
     if( $extension == 'png' ){
         $im = imagecreatefrompng( $nuevonombreimagen ); 
         imagealphablending( $im, false );
         imagesavealpha( $im, true );
         header('Content-Type: image/png');
         imagepng( $im );
     }
     else{
         $im = imagecreatefromjpeg( $nuevonombreimagen ); 
         header('Content-Type: image/jpeg');
         imagejpeg( $im );
     }
     imagedestroy( $im );
 }
 else
     print 'Error: La imagen redimensionada no puedo crearse';
    
/*
redim ($imagen,$imagen_final,$ancho_nuevo,$alto_nuevo); 


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
    } */
?>