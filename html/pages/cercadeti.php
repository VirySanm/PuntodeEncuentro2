<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
?>
  <script src="../js/jquery-1.10.1.js"></script>  
  <script src="../js/java.js"></script>
  <ul class="list-group list-group-dividered list-group-full">
 <?php 
   
     $ubicacion=obtenerlatlongAll($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
     $tam=substr_count($ubicacion,"&");
                
        
         $ubicacions=explode("&",$ubicacion);
         if($tam>=10)
           $tot=10;
         else
           $tot=$tam;
         for($a=0;$a<$tot;$a++)
         {
           // echo $ubicacions[$a];
		  $users=explode(",",$ubicacions[$a]);
		  $users[6]=str_replace(",",";",$users[6]);
		  
		  $tim=explode(" ",$users[5]);
		  if($tim[2]=="min")  
		  {
          if($tim[0]<60){
            $estus="online";
          }
          if($tim[0]>=60 && $tim[0]<120){
            $estus="away";
          }
          if($tim[0]>=120 && $tim[0]<150){
            $estus="busy";
          }
          if($tim[0]>=150){
            $estus="off";
          }
          }
          else
          {
            if($users[5]!="Hace un momento")
            $estus="off";
            else 
              $estus="online";  
          }
      ?>
        <li class="list-group-item">
          <div class="media">
            <div class="media-left">
              <a class="verperfil" id="<?php echo $users[8] ?>" style="cursor:pointer">
                <i class="avatar avatar-<?php echo $estus?>" style="height:50px;width:50px">
                 <img src="<?php echo $users[1]?>" style="height:50px;width:50px">
                <i></i>
              </i>
              </a>
            </div>
            <div class="media-body">
           
              <div class="pull-right" id="btn<?php echo $users[8] ?>">
                <?php
                // si el usuario ya esta agregado o no
               $usuconfir=usuconfir($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL, $users[8]);
               
              if($usuconfir==0) 
              {
            ?>
              <a class="agregar" id="<?php echo $users[8] ?>"><button type="button" class="btn btn-outline btn-default btn-sm">Agregar</button></a>
              <?php 
              }
              else 
              {
              ?>
              <a href="user.php?order=1&nom=&pag=0"><button type="button" class="btn btn-success btn-default btn-sm">Revista</button></a>
              <?php 
              }
              ?>   
              </div>
              <div><b class="name" href="javascript:void(0)"><?php echo $users[0]?></b>&nbsp;<em class="icon wb-map margin-right-5" aria-hidden="true"></em><?php echo $users[4]." Km."?></div>
              <?php 
              $users[6]=str_replace(";",",",$users[6]);
              ?>
              <small><?php echo $users[6]?></small>
            </div>
          </div>
        </li>
      <?php } ?>  
      </ul>

