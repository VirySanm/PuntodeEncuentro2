<?php 
session_start();
include("../includes/configuration.php");
include("../includes/utilities.php");
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
		$strS ="select c.iduser,u.nomUser, c.fechaHR, c.comentario, i.img from comentarios c,user u, imagenes i
                where c.idalbum=".$_POST["idalbum"]." and c.idimg=".$_POST["idimg"]." and c.estatuscoment=0 and c.iduser=u.iduser and estatusimg=0 and u.iduser=i.iduser and i.tipo=1 group by c.idcomentario order by idcomentario desc";
		$Res = mysql_query($strS);

		if(mysql_errno()>0){
			$strResultOp = "No fue posible validar el usuario.";
			$strInfoTec = "No fue posible ejecutar la consulta[".mysql_errno()."-".mysql_error()."]";
			$strModulo = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
			$strParameters=$str;
			$h="";
		}
		else
		{
			while($row=mysql_fetch_array($Res))
			{                
   				$hoy=date("Y-m-d H:i:s");
				
				$datetime1 = new DateTime($row["fechaHR"]);
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
					{
						$time=$hr." Horas";
					}
					else 
					{
					  if($hr==1)
					  {
					  	$time=$hr." Hora";
					  }
					  else 
                        if($min=="00")
                        {
                        	$time="Hace un momento";
                        }
					  	else
					  	{
					  		$time=$min." min";
					  	}
					}
					 
				}
				else{
					if($dia==1)
					{
					  $time=$dia." Dia";
					}
					else 
					{
					  $time=$dia." Dias";
					}
				}
   	 
      $h.='                   
                    <a class="list-group-item" id="'.$row["iduser"].',1,1" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-online">
                            <img src="../orden/imagens/'.$row["img"].'" alt="..." />
                          </span>
                        </div>
                        <div class="media-body">
                          <h4 class="media-heading">'.$row["nomUser"].'&nbsp;&nbsp;&nbsp;<small>'.$time.'</small></h4>
                          <div class="media-detail">'.$row["comentario"].'</div>
                        </div>
                      </div>
                    </a>';
			}
		}
   }

echo $h;
?>