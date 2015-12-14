<?php
/**
 * Created by PhpStorm.
 * User: Viry
 * Date: 21/10/2015
 * Time: 07:16 PM
 */
 
$val1 = '2014-03-18 10:34:09';
$val2 = '2014-03-28 09:24:39';

$datetime1 = new DateTime($val1);
$datetime2 = new DateTime($val2);

$interval = date_diff($datetime1, $datetime2);
echo $interval->format('%a'); 
echo $interval->format('%H:%I');


/*
echo "i ".$horaini="02:41:41";
//$horafin="10:40:50";
echo "<br>f".  $horafin=date("H:i:s");
/*echo date("d-m-Y");
function RestarHoras($horaini,$horafin)
//{
    $hi=explode(":",$horaini);
    $horai=$hi[0];
    $mini=$hi[1];
    $segi=$hi[2];

    $hf=explode(":",$horafin);
    $horaf=$hf[0];
    $minf=$hf[1];
    $segf=$hf[2];

    $ini=((($horai*60)*60)+($mini*60)+$segi);
    $fin=((($horaf*60)*60)+($minf*60)+$segf);

  echo "<br>d " .$dif=$fin-$ini;

   echo "<br>df". $difh=floor($dif/3600);
   echo "<br>dff ".date("H",mktime($difh));
   echo "<br>mi ". $difm=floor(($dif-($difh*3600))/60);

   echo "<br>dff ".date("H",mktime($difh));
    $difs=$dif-($difm*60)-($difh*3600);

    echo "<br>dd ". date("H:i:s",mktime($difh,$difm,$difs));
//}

echo $dFecIni="02-10-2015";
echo "<br>". $dFecFin=date("d-m-Y");
/function restaFechas($dFecIni, $dFecFin){
	$dFecIni = str_replace("-","",$dFecIni);
	$dFecIni = str_replace("/","",$dFecIni); 
	$dFecFin = str_replace("-","",$dFecFin);
	$dFecFin = str_replace("/","",$dFecFin);

	ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
	ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

	$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
	$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);

	echo "<br>". round(($date2 - $date1) / (60 * 60 * 24));
//}*/
 ?>
