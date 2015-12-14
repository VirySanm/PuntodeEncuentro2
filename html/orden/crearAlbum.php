<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");

$h='
  <script src="../js/jquery-1.10.1.js"></script>
  <script src="../js/java.js"></script>

            <div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row" style="text-align:center">
                        <h3 class="page-title">Nuevo Album </h3><br>
                        <input type="text" class="album" placeholder=" Album sin titulo" size="40" value=""><br><br>
                        <input type="hidden" class="coment" id="comen" placeholder=" Comentario sobre el Album" size="40" value="">
                        <button class="btn btn-primary btn-file" id="crear"> Crear Album </button>
                </div>
            </div>';

echo $h;
?>