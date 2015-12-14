<?php
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
?>
             
                <ul class="list-group">
                 <li class="list-group" style="cursor:pointer" >
                    <div class="media media-lg">
                      <div class="media-left" >
   <?php 
    $link=mysql_connect($strHostMYSQL, $strUserMYSQL, $strPWDMYSQL);
	mysql_select_db($strDBMYSQL,$link);
	if(mysql_errno()>0)
	{
		$strResultOp = "No fue posible validar el usuario.";
		$strInfoTec = "No fue posible localizar el host[".mysql_errno()."-".mysql_error()."]";
		$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
		$strParameters= "host:".$strHostMYSQL."~-user:".$strUserMYSQL."~PWD:".$strPWDMYSQL."bd:".$strDBMYSQL;
	}
	else
	{
		$strS ="select tipoNotif, descripcion, iduserAct, fechaHrNotif from notificaciones n, tiponotificacion t where n.tipoNotif=t.idtipoNotif and iduserMov=".$_SESSION["iduser"]." and iduserAct!=".$_SESSION["iduser"]." order by fechaHrNotif desc ";
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$localizacion="";
		}
		else
		{
			while($row=mysql_fetch_array($Res)){
							
				$hoy = date("Y-m-d H:i:s");
				
				$datetime1 = new DateTime($row["fechaHrNotif"]);
				$datetime2 = new DateTime($hoy);
				
				$interval = date_diff($datetime1, $datetime2);
				$dia= $interval->format('%a');
				$horas= $interval->format('%H:%I');
				$hrs=explode(":",$horas);
				$hr=$hrs[0];
				$min=$hrs[1];
				
				if($dia<1)
				{
					if($hr>1)
					  $time=$hr." Horas";
					else 
					{
					  if($hr==1)
						$time=$hr." Hora";
					  else 

					  	$time=$min." min";
					}
					 
				}
				else{
					if($dia==1)
					  $time=$dia." Dia";
					else 
					  $time=$dia." Dias";
				}

				$avatarusu=avatar($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduserAct"]);
				$nombreusers=nombreusus($strHostMYSQL,$strUserMYSQL,$strPWDMYSQL,$strDBMYSQL,$row["iduserAct"]);
				$usus=2;
					?>
                 <a class="list-group-item" id="<?php echo $row["iduserAct"].",".$row["tipoNotif"].",".$usus?>" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-online">
                            <img src="<?php echo $avatarusu?>" alt="..." />
                          </span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading"><?php echo $nombreusers?></h6>
                          <div class="media-meta">
                            <time datetime="2015-06-17T20:22:05+08:00"><?php echo $time ?></time>
                          </div>
                          <div class="media-detail"><?php echo $row["descripcion"]?></div>
                        </div>
                      </div>
                    </a>
                       
                  <?php 
			   }
	   	     }
	        }
			?>
               
                      </div>
                    </div>
                  </li>   
                </ul>

