<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");

$comentalbum=comentalbum($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$_POST['album']);

$h='
    <meta charset="UTF-8"/>
    <link href="../orden/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <link href="../orden/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <script src="../orden/js/fileinput.min.js" type="text/javascript"></script>
    <script src="../orden/js/fileinput_locale_es.js" type="text/javascript"></script>

            <div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row" style="text-align:center">
                      <div class="rowC">
                        <h3 class="page-title">Agregar Fotos al Album "'.$comentalbum[0].'"</h3>
                        <input type="hidden" class="album" title="'.$_POST['album'].'" placeholder=" Album sin titulo" size="10" value=" '.$comentalbum[0].'">&nbsp;&nbsp;&nbsp;
                        <input type="hidden" class="coment" id="comen" placeholder=" Comentario sobre el Album" size="10" value=" '.$comentalbum[1].'">
                      </div>
                      <div class="form-group">
                            <input id="file-3" type="file" name="imagenes[]" multiple=true>
                        </div>
                </div>
            </div>

<script>
    $("#file-3").fileinput({
        uploadUrl:"../orden/upload.php?idalbum="+$(".album").attr("title")+"&album="+$(".album").val()+"&coment="+$(".coment").val(),
        uploadAsync:false,
        showUpload: true,
        showRemove:true,
        showCaption:false,
        allowedFileExtensions : ["jpg", "png"],
        maxFileSize: 1000,
        maxFileCount: 20,
    });

</script>';

echo $h;
?>