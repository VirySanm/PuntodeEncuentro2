$(document).ready(function () {

    //detectar un click en el sitio
    $(document).click(function() {
      // alert("click");
        $.ajax({
            url:'../includes/consultas.php',
            type: 'POST'
            ,dataType: 'html'
            ,data: {num:8}
            ,success: function(data, textStatus, xhr) {
                if (xhr.status == 200) {
                }
            }
        });
    });
    //function para entrar al perfil de usuario con boton de Entrar
    $("#entrar").click(function(){
        email=$("#inputEmail").val();
        pass=$("#inputPassword").val();
        if( $('#inputCheckbox').prop('checked') ) {
           recordar=1;
        }
        else
            recordar=0;
       // alert(recordar);
       
        if(email!="")
        {
            if(pass!="")
            {
              reco="si";
                $.ajax({
                    url:'../includes/consultas.php',
                    type: 'POST'
                    ,dataType: 'html'
                    ,data: {num:0,email:email,pass:pass,recordar:recordar,reco:reco}
                    ,success: function(data, textStatus, xhr) {
                        if (xhr.status == 200) {
                        //  alert(data);
                            if(data=="")
                                $("#result").html("Email y/o Password son Incorrectos");
                            else
                                document.location.href="profile.php";
                        }
                    }
                });
            }
            else
                $("#result").html("La Password no debe estar vacia.");
        }
        else
            $("#result").html("El Email no debe estar vacio.");
    });

    //function para entrar al perfil de usuario dando enter despues de
    $("#inputPassword").bind('keydown',function(elem){       //si da un enter y el usuario es un cliente, inserta o modifica el estado en tabla estadomsj, para que produzca el aviso al costumer q hay msj nuevo sin leer
        eve=elem.keyCode;
        if(eve==13){
          email = $("#inputEmail").val();
          pass = $("#inputPassword").val();
            if( $('#inputCheckbox').prop('checked') ) {
                recordar=1;
            }
            else
                recordar=0;
          if (email != "") {
            if (pass != "") {
                $.ajax({
                    url: '../includes/consultas.php',
                    type: 'POST'
                    , dataType: 'html'
                    , data: {num: 0, email: email, pass: pass,recordar:recordar}
                    , success: function (data, textStatus, xhr) {
                        if (xhr.status == 200) {
                        //	alert(data);
                            if (data == "")
                                $("#result").html("Email y/o Password son Incorrectos");
                            else
                                document.location.href = "profile.php";
                        }
                    }
                });
            }
            else
                $("#result").html("El Password no debe estar vacio.");
          }
          else
            $("#result").html("El Email no debe estar vacio.");
        }
    });
$("#inputCheckbox").click(function(){
    if( $('#inputCheckbox').prop('checked') ) {
        email = $("#inputEmail").val();
        pass = $("#inputPassword").val();
        if(email=="" || pass=="")
        alert("El Email y/o Password no deben estar vacios");
    }
    else
        $.ajax({
            url: '../includes/consultas.php',
            type: 'POST'
            , dataType: 'html'
            , data: {num: 11}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                    $("#inputEmail").val("");
                    $("#inputPassword").val("");
                    alert("Se ha dejado de recordar su Email y Password");
                }
            }
        });
    });
// desbloquear sesion de usuario
    $("#unlock").click(function(){
        pass = $("#inputPassword").val();
     //   alert(pass);
        if (pass != "") {
          $.ajax({
            url: '../includes/consultas.php',
            type: 'POST'
            , dataType: 'html'
            , data: {num: 10,pass:pass}
            , success: function (data, textStatus, xhr) {
              if (xhr.status == 200) {
                //  alert(data);
                if (data ==0)
                   $("#result").html("Password Incorrecto");
                else
                   document.location.href = "profile.php";
              }
            }
          });
        }
        else
            $("#result").html("El Password no debe estar vacio.");
    });

    //function para registrar usuario
    $("#registro").click(function(){
      nom=$("#inputName").val();
      email=$("#inputEmail").val();
      cel=$("#inputCelular").val();
      pass=$("#inputPassword").val();
      passcon=$("#inputPasswordCheck").val();

      if(nom!="" && email!="" && cel!="" && pass!="" && passcon!="") {
          if (pass != passcon)
              $("#result").html("El Password y la Confirmacion No Coinciden.");
          else {
              $.ajax({
                  url: '../includes/consultas.php',
                  type: 'POST'
                  , dataType: 'html'
                  , data: {num: 1, nom: nom, email: email, cel: cel, pass: pass}
                  , success: function (data, textStatus, xhr) {
                      if (xhr.status == 200) {
                    	  //alert(data);
                          if (data == 1)
                              $("#result").html("Su Registro se Guardo Exitosamente.");
                          else
                              $("#result").html("Hubo un Error y No se Registro Correctamente, Intentelo m�s tarde.");
                      }
                  }
              });
          }
      }
      else
        $("#result").html("Todos los campos son obligatorios.");
    });

// limpiar div result
    $("#inputEmail").click(function(){
        $("#result").html("");
    });

// limpiar div result
    $("#inputPassword").click(function(){
        $("#result").html("");
    });

// cerrar sesion de usuario
    $(".logout").click(function(){
        $.ajax({
            url: '../includes/consultas.php',
            type: 'POST'
            , dataType: 'html'
            , data: {num: 2}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                    document.location.href = "login.php";
                }
            }
        });
    });
// restaurar contrase�a
    $("#restaurar").click(function(){
        email=$("#inputEmail").val();
        $.ajax({
            url: '../includes/consultas.php',
            type: 'POST'
            , dataType: 'html'
            , data: {num: 3, email:email}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                	//alert(data);
                  if(data=="Ok")
                    $("#recuperar").html('<img class="brand-img" src="../../assets/images/logo.png" alt="..."><br><br>  <h2 class="brand-text">Punto de Encuentro</h2> <br><p>Su Password Temporal se ha enviado a su correo</p>');
                  else
                  if(data==2)
                      $("#result").html("Este correo no esta registrado, verifique el Correo");
                  else
                      $("#result").html("Ocurrio un Error, intente m&aacute;s tarde");
                }
            }
        });
    });

    //function para cambiar contraseña
    $("#change").click(function(){
        email=$("#inputEmail").val();
        passant=$("#inputPasswordant").val();
        passnew=$("#inputPassword").val();
        passconf=$("#inputPasswordconf").val();
        
        if(passnew!=passconf)
        	$("#result").html("La Password Nuevo y Password de confirmacion no coninciden, verificar por favor.");
        
        if( $('#inputCheckbox').prop('checked') ) {
           recordar=1;
        }
        else
            recordar=0;
       // alert(recordar);
        if(email!="")
        {
            if(passant!="" && passnew!="" && passconf!="")
            {
              reco="si";
                $.ajax({
                    url:'../includes/consultas.php',
                    type: 'POST'
                    ,dataType: 'html'
                    ,data: {num:25,email:email,passant:passant,passnew:passnew,recordar:recordar,reco:reco}
                    ,success: function(data, textStatus, xhr) {
                        if (xhr.status == 200) {
                            if(data=="")
                                $("#result").html("Ocurrio un error, por favor vuelva a solicitar<br> la renovacion de su contraseña");
                            else
                                document.location.href="profile.php";
                        }
                    }
                });
            }
            else
                $("#result").html("La Password Anterior,Password Nuevo y/o Password de confirmacion no debe estar vacios.");
        }
        else
            $("#result").html("El Email no debe estar vacio.");
    });

    // boton para subir fotos
    $("#agregarfotos").click(function(){
        album=$("#agregarfotos").attr("title");

        $.ajax({
            url: '../orden/cargar.php',
            type: 'POST'
            , dataType: 'html'
            , data: {album:album}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                    $(".page-content").html(data);
                }
            }
        });
    });
    
// boton para crear album
    $("#nuevoalbum").click(function(){
        $.ajax({
            url: '../orden/crearAlbum.php',
            type: 'POST'
            , dataType: 'html'
            , data: {}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                    $(".page-content").html(data);
                }
            }
        });
    });
    // boton para guardar album nuevo
    $("#crear").click(function(){
        album=$(".album").val();
        coment=$(".coment").val();
        $.ajax({
            url: '../includes/consultas.php',
            type: 'POST'
            , dataType: 'html'
            , data: {num:4,album:album,coment:coment}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                    dato=data.split("&");
                   $("#albuns").html(dato[1]); 
                  if (dato[0] > 0){
                      $.ajax({
                          url: '../orden/cargar.php',
                          type: 'POST'
                          , dataType: 'html'
                          , data: {album:dato[0]}
                          , success: function (data, textStatus, xhr) {
                              if (xhr.status == 200) {
                                  $(".page-content").html(data);
                              }
                          }
                      });
                  }
                  else{
                      $(".page-content").html("Ocurrio un Problema, No se puedo Guardar el Album, intente de nuevo");
                }
                }
            }
        });
    });

    $(".albumnes").click(function(){
        $("#agregarfotos").attr("title",this.id);
        idalbum=this.id;
        document.location.href="gallery.php?idalbum="+idalbum;
   /*     $.ajax({
            url: '../orden/verAlbum.php',
            type: 'POST'
            , dataType: 'html'
            , data: {idalbum:idalbum}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                    $(".page-content").html(data);
                }
            }
        });*/
    });
    $(".albumnesExt").click(function(){
       // $("#agregarfotos").attr("title",this.id);
        idalbum=this.id;
        ids=idalbum.split(",");
        document.location.href="galleryExt.php?idalbum="+ids[0]+"&iduser="+ids[1];
   /*     $.ajax({
            url: '../orden/verAlbum.php',
            type: 'POST'
            , dataType: 'html'
            , data: {idalbum:idalbum}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                    $(".page-content").html(data);
                }
            }
        });*/
    });
// boton para editar perfil de usuario
    $("#editarperfil").click(function() {
        $(".editar").html('<img src="../orden/img/loading.gif" width="20px" height="20px">');
        $.ajax({
            url: '../orden/editarperfil.php',
            type: 'POST'
            , dataType: 'html'
            , data: {}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {

                    $(".page-content").css("background","#FFFFFF");
                    $(".page-content").html(data);
                }
            }
        });
    });
// guardar preferencias, pag
    $("#save").click(function() {
      $("#result").html("Guardado, espere un momento, por favor...");
      km=$("#ex1").val();
      edad=$("#ex2").val();
      sex=$('input:radio[name=sex]:checked').val()
      $.ajax({
          url: '../includes/consultas.php',
          type: 'POST'
          , dataType: 'html'
          , data: {num: 14,km:km,edad:edad,sex:sex}
          , success: function (data, textStatus, xhr) {
              if (xhr.status == 200) {
            	if (data == 1)
                   $("#result").html("Sus Preferencias se Guardaron Exitosamente.");
                else
                   $("#result").html("Hubo un Error y No se Guardaron sus Preferencias Correctamente, Intentelo m�s tarde.");
              }
          }
       });
    });
    
// boton para editar perfil de usuario
    $("#editarperfil2").click(function() {
        $(".editar").html('<img src="../orden/img/loading.gif" width="20px" height="20px">');
        $.ajax({
            url: '../orden/editarperfil.php',
            type: 'POST'
            , dataType: 'html'
            , data: {}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {

                    $(".page-content").css("background","#FFFFFF");
                    $(".page-content").html(data);
                }
            }
        });
    });

// boton para agregar red
    $("#addred").click(function() {
        red=$("#red").val();
        //$("#redesEP").html(''); //para borrar error al intenter agregar red social
        //cambiar boton (+) a un gif de recargando
        $("#addr").html('<a id="addred" title="Agregar Red Social"><img src="../orden/img/loading.gif" width="30px" height="30px"></a>');
        tipo="red";
        $.ajax({
            url: '../includes/consultas.php',
            type: 'POST'
            , dataType: 'html'
            , data: {num:5,red:red,tipo:tipo}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                  dato=data.split("&");
                  if(dato[0]=="No") {
                      $("#redesEP").html('Ocurrio un Error, no se guardo su Red Social');
                      $("#addr").html('<a id="addred" title="Agregar Red Social"><img src="../icons/plus.png" width="30px" height="30px"></a>');
                  }
                  if(dato[0]=="") {
                      $("#redesEP").html('No existe esta red social');
                      $("#addr").html('<a id="addred" title="Agregar Red Social"><img src="../icons/plus.png" width="30px" height="30px"></a>');
                  }
                  if(dato[0]=="Ya") {
                        $("#redesEP").html('Esta red social Ya Existe');
                        $("#red").val("");
                        $("#addr").html('<a id="addred" title="Agregar Red Social"><img src="../icons/plus.png" width="30px" height="30px"></a>');
                  }
                  if(dato[0]!="" && dato[0]!="No" && dato[0]!="Ya") {
                      $("#redesEP").append('<a class="icon bd-'+ dato[0] +'" id="pp'+dato[1]+'" href="'+red+'" target="_blank"></a>&nbsp;&nbsp;<a class="borrarM" id="'+dato[1]+'"><img src="../icons/cancel.png" width="15px" height="15px"></a>');
                      $("#red").val("");
                      $("#addr").html('<a id="addred" title="Agregar Red Social"><img src="../icons/plus.png" width="30px" height="30px"></a>');
                  }
                }
            }
        });
    });

// boton para guardar perfil
    $("#guardarperfil").click(function() {
        $("#result").html("Guardado...");
        sobremi=$("#sobremi").val();
        dia=$("#dia").val();
        mes=$("#mes").val();
        annio=$("#annio").val();
        sexo=$("#sexo").val();
        profe=$("#profe").val();
        $.ajax({
            url: '../includes/consultas.php',
            type: 'POST'
            , dataType: 'html'
            , data: {num: 6,sobremi:sobremi,dia:dia,mes:mes,annio:annio,sexo:sexo,profe:profe}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {

                    if(data==1) {
                        $("#sobremi").val("");
                        $("#dia option[value=1]").attr("selected",true);
                        $("#mes option[value=1]").attr("selected",true);
                        f = new Date();
                        $("#annio option[value="+ f.getFullYear()+"]").attr("selected",true);
                        $("#sexo option[value=Hombre]").attr("selected",true);
                        $("#profe").val("");
                        $("#result").html("Su perfil se ha Guardado con Exito!!");
                    }
                    else
                        $("#result").html("Ocurrio un error y no se pudo guardar su perfil");
                }
            }
        });
    });
    $(".lista").click(function(){
       $(".dropdown").attr("class","dropdown");
    });


// boton para agregar celular
    $("#addcel").click(function() {
        cel=$("#cel").val();
     //   $("#celAG").html(''); //para borrar error al intenter agregar red social
        //cambiar boton (+) a un gif de recargando
        $("#addc").html('<a id="addcel" title="Agregar No. Celular"><img src="../orden/img/loading.gif" width="30px" height="30px"></a>');
        tipo="mobile";
        $.ajax({
            url: '../includes/consultas.php',
            type: 'POST'
            , dataType: 'html'
            , data: {num:5,red:cel,tipo:tipo}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                    dato=data.split("&");
                    if(dato[0]=="No") {
                        $("#celAG").html('Ocurrio un Error, no se guardo su No. Celular');
                        $("#addc").html('<a id="addcel" title="Agregar No. Celular"><img src="../icons/plus.png" width="30px" height="30px"></a>');
                    }
                    else{
                        $("#celAG").append('<b class="icon wb-mobile" style="padding-top: 0px" id="pp'+dato[1]+'">&nbsp;&nbsp;'+cel+'</b>&nbsp;&nbsp;<a class="borrarM" id="'+dato[1]+'"><img src="../icons/cancel.png" width="15px" height="15px"></a>');
                        $("#cel").val("");
                        $("#addc").html('<a id="addcel" title="Agregar No. Celular"><img src="../icons/plus.png" width="30px" height="30px"></a>');
                    }
                }
            }
        });
    });

// boton para agregar mail
    $("#addmail").click(function() {
        mail=$("#mail").val();
      //  $("#mailAG").html(''); //para borrar error al intenter agregar E-Mail
        //cambiar boton (+) a un gif de recargando
        $("#addm").html('<a id="addmail" title="Agregar E-Mail"><img src="../orden/img/loading.gif" width="30px" height="30px"></a>');
        tipo="envelope";
        $.ajax({
            url: '../includes/consultas.php',
            type: 'POST'
            , dataType: 'html'
            , data: {num:5,red:mail,tipo:tipo}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                    dato=data.split("&");
                    if(dato[0]=="No") {
                        $("#mailAG").html('Ocurrio un Error, no se guardo su E-Mail');
                        $("#addm").html('<a id="addmail" title="Agregar E-Mail"><img src="../icons/plus.png" width="30px" height="30px"></a>');
                    }
                    else{
                        $("#mailAG").append('<b class="icon wb-envelope" style="padding-top: 0px" id="pp'+dato[1]+'">&nbsp;&nbsp;'+mail+'</b>&nbsp;&nbsp;<a class="borrarM" id="'+dato[1]+'"><img src="../icons/cancel.png" width="15px" height="15px"></a>');
                        $("#mail").val("");
                        $("#addm").html('<a id="addmail" title="Agregar E-Mail"><img src="../icons/plus.png" width="30px" height="30px"></a>');
                    }
                }
            }
        });
    });

    $(".borrarM").click(function(){
        id=this.id;
     //   alert(id);
        $.ajax({
            url: '../includes/consultas.php',
            type: 'POST'
            , dataType: 'html'
            , data: {num:7,id:id}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                    if(data==1) {
                        $("#"+id).remove();
                        $("#pp"+id).remove();
                    }
                }
            }
        });
    });
//agregar usuario
    $(".agregar").click(function(){
        id=this.id;
        //alert(id);
        $("#btn"+id).html('<img src="../orden/img/loading.gif" width="20px" height="20px">');
        $.ajax({
            url: '../includes/consultas.php',
            type: 'POST'
            , dataType: 'html'
            , data: {num:16,usu:id}
            , success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                	alert(data);
                  if(data==2) {
                	  alert("No se pudo agregar este Contacto, porque su Suscripcion ha Vencido"); 
                  }
                  if(data==3) {
                	  alert("No se pudo agregar este contacto, Ha llegado al Limite de Contactos Permitidos"); 
                  }

                  if(data==4) {
                	  alert("No se pudo agregar este contacto, porque no esta Suscrito"); 
                  }
                  if(data==1) { // se agrego contacto
                     document.location.reload();
                  }
                  if(data==0) 
                  {
                   	alert("Ocurrio un Error, no se pudo Agregar al Usuario");
                   	document.location.reload();
                  }
                }
            }
        });
    });

  //ver perfil de usuario
      $(".verperfil").click(function(){
          id=this.id;
          document.location.href="profileExt.php?iduser="+id;
      });
      
  $(".list-group-item").click(function(){
 	dato=this.id;
 	
  	datos=dato.split(",");
  	
  	  $.ajax({
          url: '../includes/consultas.php',
          type: 'POST'
         ,dataType: 'html'
         ,data: {num:19,noti:datos[3]}
         ,success: function (data, textStatus, xhr) {
          if (xhr.status == 200) {
        	  
   	  if(datos[2]==2) 
      { 
   		if(datos[1]==1){ // me agrego o agregre como contacto
      	  document.location.href="profileExt.php?iduser="+datos[0];
      	}
      	if(datos[1]==2){ // agrego fotos(mi actividad)
      	  $.ajax({
              url: '../includes/consultas.php',
              type: 'POST'
             ,dataType: 'html'
             ,data: {num:18,usu:datos[0]}
             ,success: function (data, textStatus, xhr) {
              if (xhr.status == 200) {	
        	      document.location.href="gallery.php?idalbum="+data;
              }
             }
           });
         }
         if(datos[1]==3){ // cambio foto perfil(mi actividad)
      	   document.location.href="gallery.php?idalbum=1";
         }
         if(datos[1]==4){ // cambio foto portada(mi actividad)
        	   document.location.href="gallery.php?idalbum=2";
           }
         if(datos[1]==6){ // comentaron o comente en mi foto
        	   document.location.href="gallery.php?idalbum="+datos[4];
           }
   	   }
   	  if(datos[2]==1) 
      { 
   		if(datos[1]==1 || datos[1]==3){ // agregue como contacto(mi actividad) o cambio foto de perfil(noticias)
        	  document.location.href="profileExt.php?iduser="+datos[0];
        	}
      	if(datos[1]==2){ // agrego fotos(noticias)
      	  $.ajax({
              url: '../includes/consultas.php',
              type: 'POST'
             ,dataType: 'html'
             ,data: {num:18,usu:datos[0]}
             ,success: function (data, textStatus, xhr) {
              if (xhr.status == 200) {	
        	      document.location.href="galleryExt.php?iduser="+datos[0]+"&idalbum="+data;
              }
             }
           });
         }
        
         if(datos[1]==4){ //cambio foto portada(noticias)
      	   document.location.href="galleryExt.php?iduser="+datos[0]+"&idalbum=2";
         }

         if(datos[1]==6){ //comentario en foto del usuario de la foto(noticias)
      	   document.location.href="galleryExt.php?idalbum="+datos[4]+"&iduser="+datos[0];
         }
      }
   	 

          }
         }
       });
    	
    });
      $("#allnotis").click(function() {
    	  $.ajax({
              url:'allnotificaciones.php',
              type: 'POST'
              ,dataType: 'html'
              ,data:{}
              ,success: function(data, textStatus, xhr){
                 if (xhr.status == 200) {
                	// alert(data);
                	 $(".panel").html(data);
                 }
              }
		  });
      });
      //borrar imagen
      $(".deleteimg").click(function() {
    	  dato=this.id;
    	  datos=dato.split(",");
    	  
    	if(confirm("Esta seguro de Eliminar esta imagen?"))
        {
    	  $.ajax({
              url:'../includes/consultas.php',
              type: 'POST'
              ,dataType: 'html'
              ,data:{num:20,id:datos[0]}
              ,success: function(data, textStatus, xhr){
                 if (xhr.status == 200) {
                	 if(data==1)
                	    document.location.href="gallery.php?idalbum="+datos[1];
                	 else
                		 alert("Ocurrio un Error, no se pudo eliminar su imagen, favor de interntarlo más tarde");
                 }
              }
		  });
        }
      });
      //borrar album
      $(".deletealb").click(function() {
    	  id=this.id;
    	if(confirm("Esta seguro de Eliminar este Album?"))
        {
    	  $.ajax({
              url:'../includes/consultas.php',
              type: 'POST'
              ,dataType: 'html'
              ,data:{num:26,id:id}
              ,success: function(data, textStatus, xhr){
                 if (xhr.status == 200) {
                	 id=parseInt(id)-1;
                	 if(data==1)
                	    document.location.href="gallery.php?idalbum="+id;
                	 else
                		 alert("Ocurrio un Error, no se pudo eliminar su Album, favor de interntarlo más tarde");
                 }
              }
		  });
        }
      });
      //convertir imagen de album a portada
      $(".imgportada").click(function() {
    	 
    	  dato=this.id;
    	  datos=dato.split(",");
    	  $.ajax({
              url:'../includes/consultas.php',
              type: 'POST'
              ,dataType: 'html'
              ,data:{num:21,id:datos[0],img:datos[1]}
              ,success: function(data, textStatus, xhr){
                 if (xhr.status == 200) {
                	 //alert(data);
                	 if(data==1)
                	    document.location.href="index.php";
                	 else
                		 alert("Ocurrio un Error, favor de interntarlo más tarde");
                 }
              }
		  });
      });
      
    //convertir imagen de album a portada
      $(".imgperfil").click(function() {
    	
    	  dato=this.id;
    	  datos=dato.split(",");
    	  $.ajax({
              url:'../includes/consultas.php',
              type: 'POST'
              ,dataType: 'html'
              ,data:{num:22,id:datos[0],img:datos[1]}
              ,success: function(data, textStatus, xhr){
                 if (xhr.status == 200) {
                	// alert(data);
                	 if(data==1)
                	    document.location.href="profile.php";
                	 else
                		 alert("Ocurrio un error, intente mas tarde por favor");
                		// alert("Verifique las dimensiones de la Imagen (Max. 130x130)");
                 }
              }
		  });
      });
      
      $(".coment").bind('keydown',function(elem){
       eve=elem.keyCode;
       if(eve==13){
    	   $("#comentarios").html('Enviando comentario <img src="../orden/img/loading.gif" width="20px" height="20px">');
    	  datos=this.title;
    	  id=this.id;
    	  dato=datos.split(",");
    	  idalbum=dato[0];
    	  idimg=dato[1];
    	  iduser=dato[2];
    	  coment=$("#"+id).val();
    	  $.ajax({
              url:'../includes/consultas.php',
              type: 'POST'
              ,dataType: 'html'
              ,data:{num:23,idalbum:idalbum,idimg:idimg,iduser:iduser,coment:coment}
              ,success: function(data, textStatus, xhr){
                 if (xhr.status == 200) {
                	// alert(data);
                  
                	 if(data==1)
                	 {
                		 $(".coment").val("");
                		 $("#comentarios").html("");
                	 }
                	 else
                		 alert("Ocurrio un error, intentar mas tarde");
                   
                 }
              }
		  });
          }
      });

      $("#inputSearch").bind('keydown',function(elem){
       eve=elem.keyCode;
       nom=$("#inputSearch").val();
       if(eve==13){
    	   document.location.href="user.php?order=1&nom="+nom+"&pag=0";
          }
      });

      $("#vi").click(function(){
         $("#agr").attr('class','');
         $("#act").attr('class','');
         $("#pro").attr('class','');
         $("#vis").attr('class','active');
      });
       $("#ag").click(function(){
         $("#vis").attr('class','');
         $("#act").attr('class','');
         $("#pro").attr('class','');
         $("#agr").attr('class','active');
      });
      
});// ready

