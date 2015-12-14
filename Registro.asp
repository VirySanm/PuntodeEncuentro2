<%
'Portar los datos del cliente que se desea agregar
Dim objStateList
Dim objXmlTransform 
dim strXMLValidaCaseta

Dim strXMLStateList

Set objStateList = Server.CreateObject("FBUtilities.State")
Set objXmlTransform = server.CreateObject ("FBDOMUtilities.XMLConstruct")

'Obtiene la lista de estados
strXMLStateList = objStateList.List 
strXMLStateList=objXmlTransform.XMLTransform ("ComboEstados.xsl", strXMLStateList)
			
Set objStateList = nothing
Set objXmlTransform = nothing
%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos.css" rel="stylesheet" type="text/css">
<script LANGUAGE="JavaScript">
var img1 = new Image();
img1.src = "images/arrow.gif";
var img2 = new Image();
img2.src = "images/arrow_f2.gif";

function doOutline() {
	
  var srcId, srcElement, targetElement;
  srcElement = window.event.srcElement;
  if (srcElement.className.toUpperCase() == "LEVEL1" || srcElement.className.toUpperCase() == "FAQ") {
		 srcID = srcElement.id.substr(0, srcElement.id.length-1);
		 targetElement = document.all(srcID + "s");
		 srcElement = document.all(srcID + "i");

  	if (targetElement.style.display == "none") {			
				 targetElement.style.display = "";
		 		 if (srcElement.className == "LEVEL1") srcElement.src = img2.src;
     	} else {
				 targetElement.style.display = "none";
				 if (srcElement.className == "LEVEL1") srcElement.src = img1.src;
     }
  }
}

document.onclick = doOutline;

function AbreVentana(){

	window.showModalDialog("productDescription.htm","Desc","dialogHeight:350px;dialogWidth:600px;dialogTop:150px;dialogLeft:200px;center:Yes;help:No;resizable:No;status:No;");

}

</script>
<script language="JavaScript" type="text/JavaScript">
<!--


function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_nbGroup(event, grpName) { //v6.0
  var i,img,nbArr,args=MM_nbGroup.arguments;
  if (event == "init" && args.length > 2) {
    if ((img = MM_findObj(args[2])) != null && !img.MM_init) {
      img.MM_init = true; img.MM_up = args[3]; img.MM_dn = img.src;
      if ((nbArr = document[grpName]) == null) nbArr = document[grpName] = new Array();
      nbArr[nbArr.length] = img;
      for (i=4; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
        if (!img.MM_up) img.MM_up = img.src;
        img.src = img.MM_dn = args[i+1];
        nbArr[nbArr.length] = img;
    } }
  } else if (event == "over") {
    document.MM_nbOver = nbArr = new Array();
    for (i=1; i < args.length-1; i+=3) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = (img.MM_dn && args[i+2]) ? args[i+2] : ((args[i+1])? args[i+1] : img.MM_up);
      nbArr[nbArr.length] = img;
    }
  } else if (event == "out" ) {
    for (i=0; i < document.MM_nbOver.length; i++) {
      img = document.MM_nbOver[i]; img.src = (img.MM_dn) ? img.MM_dn : img.MM_up; }
  } else if (event == "down") {
    nbArr = document[grpName];
    if (nbArr)
      for (i=0; i < nbArr.length; i++) { img=nbArr[i]; img.src = img.MM_up; img.MM_dn = 0; }
    document[grpName] = nbArr = new Array();
    for (i=2; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = img.MM_dn = (args[i+1])? args[i+1] : img.MM_up;
      nbArr[nbArr.length] = img;
  } }
}
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
<!--

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);



function ValidarGafete(){
	var strNoGafete;
	var lngNoGafete;
	var regEspacios = new RegExp(" ","gi");
	
	strNoGafete = new String(frmGafetes.txtNoGafete.value);
	lngNoGafete = new Number(frmGafetes.txtNoGafete.value);
	//alert(isNaN(lngNoGafete));
	if (isNaN(lngNoGafete) || lngNoGafete == 0 ){
		alert("El no. de gafete es incorrecto");
		return false;
	}
	else{
		//Quitamos los Espacios
		strNoGafete = strNoGafete.replace(regEspacios, "")
		if(strNoGafete.length >= 4)
			return true;	
		else{
			alert("El no. de gafete es incorrecto");
			return false;
		}
	}
}

function ValidarNombre(){
	var regEspacios = new RegExp(" ","gi");
	var strNombre;
	var strApellidoPat;
	var strApellidoMat;
	
	strNombre = new String(frmGafetes.txtNombre.value);
	strApellidoPat = new String(frmGafetes.txtApellidoPat.value);
	strApellidoMat = new String(frmGafetes.txtApellidoMat.value);
	
	//Quitamos los espacios
	strNombre = strNombre.replace(regEspacios,"");
	strApellidoPat = strApellidoPat.replace(regEspacios, "");
	strApellidoMat = strApellidoMat.replace(regEspacios,"");
	
	if (strNombre.length > 0)
		if (strApellidoPat.length > 0)
			if (strApellidoMat.length > 0) 
				return true;
			else{
				alert("Verifique su Apellido Materno");
				return false;
			}
		else{
			alert("Verifique su apellido Paterno");
			return false;
		}
	else{
		alert("Verifique su nombre");
		return false;
	}
	
}

function ValidarDireccion(){
	var regEspacios = new RegExp(" ","gi");
	var strCalle;
	var strNoExt;
	var strColonia;
	var strCodigoPostal;
	//Cargamos los valores
	strCalle = new String(frmGafetes.txtCalle.value);
	strNoExt = new String(frmGafetes.txtNoExt.value);
	strColonia = new String(frmGafetes.txtColonia.value);
	strCodigoPostal = new String(frmGafetes.txtCodigoPostal.value);
	
	//Quitamos los espacios
	strCalle = strCalle.replace(regEspacios, "");
	strNoExt = strNoExt.replace(regEspacios, "");
	strColonia = strColonia.replace(regEspacios, "");
	strCodigoPostal = strCodigoPostal.replace(regEspacios, "");
	
	//Validamos que tenga datos
	if(strCalle.length > 0)
		if (strNoExt.length > 0)
			if (strColonia.length > 0)
				if(strCodigoPostal.length > 0)
					return true;
				else{
					alert("Verifique su Codigo Postal");
					return false;
				}
			else{
				alert("Verifique su Colonia");
				return false;
			}
		else{
			alert("Verifique su No. Exterior");
			return false;
		}
	else{
		alert("Verifique su Calle");
		return false;
	}
	
}

function ValidarTelefonos(){
	var regEspacios = new RegExp(" ","gi");
	var strTelefono;
	
	strTelefono = new String(frmGafetes.txtTelefono1.value);
	
	//Quitamos los espacios
	strTelefono = strTelefono.replace(regEspacios, "");
	
	//Validamos si existen datos en el telefono
	if (strTelefono.length > 0)
		return true;
	else{
		alert("Verifique su Telefono");
		return false;
	}
}
function Validar(){
	if (ValidarGafete()) 
		if (ValidarNombre())
			if (ValidarDireccion())
				if (ValidarTelefonos()){
					frmGafetes.action ="GuardarGafete.asp";
					frmGafetes.submit();
				}
		
}


//-->
function CheckInfo(pobjText){
var txtValue;
var lblBlank;
	
	if ((event.keyCode>=33 && event.keyCode<=43) || (event.keyCode==45) || (event.keyCode>=91 && event.keyCode<=96) || (event.keyCode>=60 && event.keyCode<=63) || (event.keyCode>=123 && event.keyCode<=126) || (event.keyCode==180) || (event.keyCode==168) || (event.keyCode==161) || (event.keyCode==191) || (event.keyCode==172) || (event.keyCode==176)) event.keyCode=""; 
	pobjText.focus();
	if (pobjText.name=="Password" && event.keyCode==13){sendit()}
	
}


/*function CheckInfo(pobjText){
var txtValue;
var lblBlank;
		
	if ((event.keyCode>=33 && event.keyCode<=43) || (event.keyCode==45) || (event.keyCode>=91 && event.keyCode<=96) || (event.keyCode>=60 && event.keyCode<=63) || (event.keyCode>=123 && event.keyCode<=126) || (event.keyCode==180) || (event.keyCode==168) || (event.keyCode==161) || (event.keyCode==191) || (event.keyCode==172) || (event.keyCode==176)) 
		{
		alert("Caracter no válido");
		event.keyCode=""; 
		pobjText.focus();
		}
	if (pobjText.name=="Password" && event.keyCode==13){sendit()}
	
}
*/
function sendit(){  
  document.frmMain.action = "LoginUser.asp";
  document.frmMain.submit();
}
</script>
<style type="text/css">
<!--
.style2 {color: #FF0000}
.style3 {color: #000000}
-->
</style>
</head>

<body background="../images2/backleft.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../images2/top_r3_c1_f3.gif','../images2/top_r3_c1_f2.gif','../images2/top_r3_c4_f3.gif','../images2/top_r3_c4_f2.gif','../images2/top_r3_c6_f3.gif','../images2/top_r3_c6_f2.gif','../images2/top_r3_c8_f3.gif','../images2/top_r3_c8_f2.gif','../images2/top_r3_c10_f3.gif','../images2/top_r3_c10_f2.gif','../images2/LEFT_r6_c1_f3.gif','../images2/LEFT_r6_c1_f2.gif')">
<form name="frmGafetes" id="frmGafetes" Method="post">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../images2/backtop.gif">
              <tr> 
                <td width="169" valign="bottom"><p><a href="index.asp"><img src="../images2/logo.gif" border="0"></a></p></td>
                <td width="569" align="center" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="56" align="right" bgcolor="#345C9E"><img src="../images2/top1.gif" width="56" height="51"></td>
                      <td valign="bottom"><table border="0" cellpadding="0" cellspacing="0" width="452">
                          <!-- fwtable fwsrc="topbohn.png" fwbase="top.gif" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="1" -->
                          <tr> 
                            <td><table border="0" cellpadding="0" cellspacing="0" width="452">
                                <tr> 
                                  <td><img name="top_r1_c1" src="../images2/top_r1_c1.gif" width="21" height="23" border="0"></td>
                                  <td><img name="top_r1_c2" src="../images2/top_r1_c2.gif" width="431" height="23" border="0"></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <td><img name="top_r2_c1" src="../images2/top_r2_c1.gif" width="452" height="13" border="0"></td>
                          </tr>
                          <tr> 
                            <td><table border="0" cellpadding="0" cellspacing="0" width="452">
                                <tr> 
                                  <td><table border="0" cellpadding="0" cellspacing="0" width="95">
                                      <tr> 
                                        <td><a href="index.asp" target="_top"  onClick="MM_nbGroup('down','navbar1','top_r3_c1','../images2/top_r3_c1_f3.gif',1)"  onMouseOver="MM_nbGroup('over','top_r3_c1','../images2/top_r3_c1_f2.gif','../images2/top_r3_c1_f3.gif',1)" onMouseOut="MM_nbGroup('out');" ><img name="top_r3_c1" src="../images2/top_r3_c1.gif" width="95" height="9" border="0"></a></td>
                                      </tr>
                                      <tr> 
                                        <td><img name="top_r5_c1" src="../images2/top_r5_c1.gif" width="95" height="3" border="0"></td>
                                      </tr>
                                    </table></td>
                                  <td><img name="top_r3_c3" src="../images2/top_r3_c3.gif" width="22" height="12" border="0"></td>
                                  <td><a href="productos.asp?Category=0" target="_top"  onClick="MM_nbGroup('down','navbar1','top_r3_c4','../images2/top_r3_c4_f3.gif',1)"  onMouseOver="MM_nbGroup('over','top_r3_c4','../images2/top_r3_c4_f2.gif','../images2/top_r3_c4_f3.gif',1)" onMouseOut="MM_nbGroup('out');" ><img name="top_r3_c4" src="../images2/top_r3_c4.gif" width="65" height="12" border="0"></a></td>
                                  <td><img name="top_r3_c5" src="../images2/top_r3_c5.gif" width="22" height="12" border="0"></td>
                                  <td><table border="0" cellpadding="0" cellspacing="0" width="56">
                                      <tr> 
                                        <td><a href="servicios.asp" target="_top"  onClick="MM_nbGroup('down','navbar1','top_r3_c6','../images2/top_r3_c6_f3.gif',1)"  onMouseOver="MM_nbGroup('over','top_r3_c6','../images2/top_r3_c6_f2.gif','../images2/top_r3_c6_f3.gif',1)" onMouseOut="MM_nbGroup('out');" ><img name="top_r3_c6" src="../images2/top_r3_c6.gif" width="56" height="9" border="0"></a></td>
                                      </tr>
                                      <tr> 
                                        <td><img name="top_r5_c6" src="../images2/top_r5_c6.gif" width="56" height="3" border="0"></td>
                                      </tr>
                                    </table></td>
                                  <td><img name="top_r3_c7" src="../images2/top_r3_c7.gif" width="21" height="12" border="0"></td>
                                  <td><table border="0" cellpadding="0" cellspacing="0" width="86">
                                      <tr> 
                                        <td><a href="distribuidores.asp" target="_top"  onClick="MM_nbGroup('down','navbar1','top_r3_c8','../images2/top_r3_c8_f3.gif',1)"  onMouseOver="MM_nbGroup('over','top_r3_c8','../images2/top_r3_c8_f2.gif','../images2/top_r3_c8_f3.gif',1)" onMouseOut="MM_nbGroup('out');" ><img name="top_r3_c8" src="../images2/top_r3_c8_f3.gif" width="86" height="9" border="0"></a></td>
                                      </tr>
                                      <tr> 
                                        <td><img name="top_r5_c8" src="../images2/top_r5_c8.gif" width="86" height="3" border="0"></td>
                                      </tr>
                                    </table></td>
                                  <td><img name="top_r3_c9" src="../images2/top_r3_c9.gif" width="22" height="12" border="0"></td>
                                  <td><table border="0" cellpadding="0" cellspacing="0" width="63">
                                      <tr> 
                                        <td><a href="contacto.asp" target="_top"  onClick="MM_nbGroup('down','navbar1','top_r3_c10','../images2/top_r3_c10_f3.gif',1)"  onMouseOver="MM_nbGroup('over','top_r3_c10','../images2/top_r3_c10_f2.gif','../images2/top_r3_c10_f3.gif',1)" onMouseOut="MM_nbGroup('out');" ><img name="top_r3_c10" src="../images2/top_r3_c10.gif" width="63" height="8" border="0"></a></td>
                                      </tr>
                                      <tr> 
                                        <td><img name="top_r4_c10" src="../images2/top_r4_c10.gif" width="63" height="4" border="0"></td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <td><img name="top_r6_c1" src="../images2/top_r6_c1.gif" width="452" height="3" border="0"></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td align="right" bgcolor="#345C9E"><img src="../images2/top2.gif" width="56" height="21"></td>
                      <td valign="middle" bgcolor="#749FD6">&nbsp;</td>
                    </tr>
                  </table></td>
                <td align="left" valign="bottom" bgcolor="#345C9E"><img src="../images2/remate.gif"></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="parrafo-g">
              <tr> 
                <td width="128" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="128">
                    <!-- fwtable fwsrc="interfazFINAL3.png" fwbase="LEFT.gif" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="1" -->
                    <tr> 
                      <td><img name="top_left" src="../images2/top_left.gif" width="128" height="168" border="0"></td>
                    </tr>
                    <tr> 
                      <td><img name="LEFT_r3_c1" src="../images2/LEFT_r3_c1.gif" width="128" height="10" border="0"></td>
                    </tr>
                    <tr> 
                      <td><table border="0" cellpadding="0" cellspacing="0" width="128">
                          <tr> 
                            <td><img name="usuarioclave" src="../images2/usuarioclave.gif" width="51" height="61" border="0"></td>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td class="espacio" height="12"></td>
                                </tr>
                                <tr> 
                                  <td align="left"><input name="Login" type="text" class="parrafo" size="7" maxlength=20 onkeypress="return CheckInfo(frmMain.Login)"></td>
                                </tr>
                                <tr> 
                                  <td height="8" align="left"></td>
                                </tr>
                                <tr> 
                                  <td align="left"><input name="Password" type="password" class="parrafo" size="7" maxlength=20 onkeypress="return CheckInfo(frmMain.Password)"></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td><table border="0" cellpadding="0" cellspacing="0" width="128">
                          <tr> 
                            <td><img name="LEFT_r5_c1" src="../images2/LEFT_r5_c1.gif" width="101" height="46" border="0"></td>
                            <td><img name="LEFT_r5_c3" src="../images2/LEFT_r5_c3.gif" width="27" height="46" border="0"></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td><table border="0" cellpadding="0" cellspacing="0" width="128">
                          <tr> 
                            <td><a href="../Clientes/Default.htm" target="_top"  onClick="MM_nbGroup('down','navbar1','LEFT_r6_c1','../images2/LEFT_r6_c1_f3.gif',1)"  onMouseOver="MM_nbGroup('over','LEFT_r6_c1','../images2/LEFT_r6_c1_f2.gif','../images2/LEFT_r6_c1_f3.gif',1)" onMouseOut="MM_nbGroup('out');" ><img name="LEFT_r6_c1" src="../images2/LEFT_r6_c1.gif" width="101" height="24" border="0"></a></td>
                            <td><img name="LEFT_r6_c3" src="../images2/LEFT_r6_c3.gif" width="27" height="24" border="0"></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td><img name="complemento" src="../images2/complemento.gif" width="128" height="267" border="0"></td>
                    </tr>
                  </table></td>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top"> 
                      <td width="957"><table width="630" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td width="77" align="left" valign="top"><img src="../images2/corner.gif" width="77" height="112"></td>
                            <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="9%">&nbsp;</td>
                                        <td width="91%" align="right"><img src="../images/t_bohnificate.gif" width="464" height="58"></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td valign="top">                                          <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                              <td width="17" valign="top" bgcolor="#A7C2E4"><img src="../images2/a.gif" width="17" height="17"></td>
                                              <td bgcolor="#A7C2E4">&nbsp;</td>
                                              <td width="17" align="right" valign="top" bgcolor="#A7C2E4"><img src="../images2/b.gif" width="17" height="17"></td>
                                            </tr>
                                            <tr bgcolor="#A7C2E4">
                                              <td width="17">&nbsp;</td>
                                              <td bgcolor="#A7C2E4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td valign="top"><p class="parrafo">Ingrese sus datos tal y como aparecen en su credencial para empezar a gozar los beneficios de ser cliente BOHN</p>
                                                      <p class="parrafo style2"><strong><!--Favor de ingresar Nombre, Apellido Paterno, su n&uacute;mero de gafete ya est&aacute; registrado --></strong></p>
                                                      <TABLE width="100%" border=0 cellPadding=0 cellSpacing=3 class="parrafo">
                                                          <TBODY>
                                                            <TR>
                                                              <TD height=27 align=right class="parrafo">Gafete No.<span class="style2">*</span> </TD>
                                                              <TD height=27><span class="titulos2normal">
                                                                <input name="txtNoGafete" id="txtNoGafete" class="titulos2normal" size=6 maxlength="4">
                                                              </span></TD>
                                                            </TR>
                                                            <TR>
                                                              <TD width="40%" height=27 align=right class="parrafo">Nombre<span class="style2">*</span></TD>
                                                              <TD width="60%" height=27><INPUT name="txtNombre" id="txtNombre" class="titulos2normal" size=30 maxlength="45">
                                                              </TD>
                                                            </TR>
                                                            <TR>
                                                              <TD width="40%" height=21 align=right class="titulos2">Apellido Paterno<span class="style2">*</span> </TD>
                                                              <TD width="60%" height=21><INPUT name="txtApellidoPat" id="txtApellidoPat" class="titulos2normal" size=30 maxlength="45">
                                                              </TD>
                                                            </TR>
                                                            <TR>
                                                              <TD height=21 align=right class="titulos2">Apellido Materno<span class="style2">*</span></TD>
                                                              <TD height=21><INPUT name="txtApellidoMat" id="txtApellidoMat" class="titulos2normal" size=30 maxlength="45"></TD>
                                                            </TR>
                                                            <TR>
                                                              <TD height=21 align=right class="titulos2">Estado<span class="style2">*</span></TD>
                                                              <TD height=21 class="titulos2normal"><select name="cmbEstado" id="cmbEstado"class="titulos2normal" 
            style="FONT-FAMILY: arial,verdana'; FONT-SIZE: 8pt">
                                                                  <!--<option></option>
                                                                  <option>Otro pa&iacute;s</option>
                                                                  <option>Aguascalientes</option>
                                                                  <option>Baja California</option>
                                                                  <option>Baja California Sur</option>
                                                                  <option>Campeche</option>
                                                                  <option>Chiapas</option>
                                                                  <option>Chihuahua</option>
                                                                  <option>Coahuila</option>
                                                                  <option>Colima</option>
                                                                  <option selected>D.F. o zona metro.</option>
                                                                  <option>Durango</option>
                                                                  <option>Estado de M&eacute;xico</option>
                                                                  <option>Guanajuato</option>
                                                                  <option>Guerrero</option>
                                                                  <option>Hidalgo</option>
                                                                  <option>Jalisco</option>
                                                                  <option>Michoac&aacute;n</option>
                                                                  <option>Morelos</option>
                                                                  <option>Nayarit</option>
                                                                  <option>Nuevo Le&oacute;n</option>
                                                                  <option>Oaxaca</option>
                                                                  <option>Puebla</option>
                                                                  <option>Quer&eacute;taro</option>
                                                                  <option>Quintana Roo</option>
                                                                  <option>San Luis Potos&iacute;</option>
                                                                  <option>Sinaloa</option>
                                                                  <option>Sonora</option>
                                                                  <option>Tabasco</option>
                                                                  <option>Tamaulipas</option>
                                                                  <option>Tlaxcala</option>
                                                                  <option>Veracruz</option>
                                                                  <option>Yucat&aacute;n</option>
                                                                  <option>Zacatecas</option>-->
                                                                  <%Response.Write(strXMLStateList)%>
                                                              </select></TD>
                                                            </TR>
                                                            <TR>
                                                              <TD height=21 align=right class="titulos2">Calle<span class="style2">*</span></TD>
                                                              <TD height=21 class="titulos2normal"><INPUT name="txtCalle" id="txtCalle" class="titulos2normal" size=30 maxlength="45"></TD>
                                                            </TR>
                                                            <TR>
                                                              <TD height=21 align=right class="titulos2">No. ext.<span class="style2">*</span></TD>
                                                              <TD height=21 class="titulos2normal"><input name="txtNoExt" id="txtNoExt" class="titulos2normal" size=6 maxlength="6">
                                                                  <span class="titulos2">No. int.</span>
                                                                  <input name="txtNoInt" id="txtNoInt" class="titulos2normal" size=6 maxlength="6"></TD>
                                                            </TR>
                                                            <TR>
                                                              <TD height=21 align=right class="titulos2">Colonia<span class="style2">*</span></TD>
                                                              <TD height=21 class="titulos2normal"><INPUT name="txtColonia" id="txtColonia" class="titulos2normal" size=30 maxlength="45"></TD>
                                                            </TR>
                                                            <TR>
                                                              <TD height=21 align=right class="titulos2">C.P.<span class="style2">*</span></TD>
                                                              <TD height=21><input name="txtCodigoPostal" id="txtCodigoPostal" class="titulos2normal" size=10 maxlength="5"></TD>
                                                            </TR>
                                                            <TR>
                                                              <TD height=21 align=right class="titulos2">Tel&eacute;fono<span class="style2">*</span></TD>
                                                              <TD height=21><input name="txtTelefono1" id="txtTelefono1" class="titulos2normal" size=30 maxlength="45"></TD>
                                                            </TR>
                                                            <TR>
                                                              <TD width="40%" height=21 align=right class="titulos2">&nbsp; </TD>
                                                              <TD width="60%" height=21><input name="txtTelefono2" id="txtTelefono2" class="titulos2normal" size=30 maxlength="45">
                                                              </TD>
                                                            </TR>
                                                            <TR>
                                                              <TD width="40%" height=21 align=right class="titulos2">Email&nbsp; </TD>
                                                              <TD width="60%" height=21><input name="txtEmail" id="txtEmail" class="titulos2normal" size=30 maxlength="80">
                                                              </TD>
                                                            </TR>
                                                            <TR>
                                                              <TD height=21 align=right class="titulos2">&nbsp;</TD>
                                                              <TD height=21>&nbsp;</TD>
                                                            </TR>
                                                            <TR>
                                                              <TD height=21 align=right class="titulos2"><span class="style2">* <span class="style3">Datos requeridos</span> </span> </TD>
                                                              <TD height=21 align="right"><a href="#"><img src="../images/registrar.gif" width="98" height="20" usemap="#RegistrarImg" border="0"></a></TD>
                                                            </TR>
                                                          </TBODY>
                                                        </TABLE>                                                        
                                                    </td>
                                                  </tr>
                                              </table></td>
                                              <td width="17" align="right">&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td width="17" valign="bottom" bgcolor="#A7C2E4"><img src="../images2/c.gif" width="17" height="17"></td>
                                              <td bgcolor="#A7C2E4">&nbsp;</td>
                                              <td width="17" align="right" valign="bottom" bgcolor="#A7C2E4"><img src="../images2/d.gif" width="17" height="17"></td>
                                            </tr>
                                            <Map name="RegistrarImg" id="RegistrarImg">
												<Area shape="rect" coords="0,0,98,20" onClick="Validar();"/>
                                            </Map>
                                          </table>
                                        </td>
                                      </tr>
                                  </table></td>
                                </tr>
                              </table>
                            <p>&nbsp;</p></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr valign="top"> 
                      <td> <table width="610" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td valign="top"> <p>&nbsp;</p></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="50" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../images2/backbottom.gif">
        <tr> 
          <td width="157"><img src="../images2/bottom1.gif" width="157" height="50"></td>
          <td width="622" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="center" valign="top"><span class="parrafo">&copy; Todos 
                  los derechos reservados, Frigus Bohn, S.A. de C.V.</span></td>
                <td width="15" align="right"><img src="../images2/bottom2.gif" width="15" height="50"></td>
              </tr>
            </table></td>
          <td bgcolor="#345C9E">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
