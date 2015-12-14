<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
$noti=notificaciones($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL);
$not=explode(";",$noti);
$tamnot=substr_count($not[1],"&");

$h= ' 
  <script src="../js/jquery-1.10.1.js"></script>
  <script src="../js/java.js"></script>';

   $notis=explode("&",$not[1]);
   
   for($i=0;$i<$not[0];$i++){ 
   	
   	$dato=explode(",",$notis[$i]);

   	$avatarusu=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$dato[1]);
   	$nombreusers=nombreusus($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$dato[1]);

   
   if($dato[5]==$_SESSION["iduser"])
	  $usus=2;
   else 
	  $usus=1;
   
   	if($dato[3]==6)
   		$userr=$dato[5];
   	else
   		$userr=$dato[1];
   	
   	$idalbum=vercoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$dato[1],$dato[6]);
   	$verfoto=verfotocoment($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$idalbum[1]);
   	
   	$confirmarusuado=usuconfir($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$dato[1]);
   	
    $fechaagregado=fechaagregado($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$dato[1]);
                
    if(($confirmarusuado==0 && $dato[5]==$_SESSION["iduser"] && ($dato[3]==1 || $dato[3]==6)) || ($confirmarusuado==1 && $fechaagregado <= $dato[7] && $dato[5]==$_SESSION["iduser"]))
   	{
      $h.='<a class="list-group-item" id="'.$userr.','.$dato[3].','.$usus.",".$dato[4].','.$idalbum[0].'" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-online" style="height:50px;width:50px">
                            <img src="'.$avatarusu.'" style="height:50px;width:50px" />
                          </span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">'.$nombreusers.'</h6>
                          <div class="media-meta">
                            <time datetime="2015-06-17T20:22:05+08:00">'.$dato[2].'</time>
                          </div>
                          <div class="media-detail">'.$dato[0].'</div>
                        </div>';
      			if($dato[3]==6){
                        $h.='<div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-online" style="height:50px;width:50px">
                            <img src="'.$verfoto.'" style="height:50px;width:50px" />
                          </span>
                        </div>';
      			}   
                    $h.='</div>
                    </a>';
   	}
   }

echo $h;
?>