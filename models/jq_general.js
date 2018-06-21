// *****************************************************************************************************************
// *****************************************  Empieza el Proyecto Final ********************************************
// *****************************************************************************************************************

$(document).ready(function() {

	var bgNormal="url('../resources/Imagenes/fotoportada.jpg') no-repeat fixed";
	var bgClaro="url('../resources/Imagenes/fotoportada_claro.jpg') no-repeat fixed";
        var seguridad = 3;          // *** solo los administradores pueden modificar estas secciones (1, 2, 3)
        
    
    function anadirNoticia() {
            var noticia = $(this).parent();
            var noticiaNueva = noticia.clone();
            noticiaNueva.find("a:first").html("").attr("idContenido", "0");
            noticiaNueva.find("a:last").html("").attr("idContenido", "0");
            noticiaNueva.insertAfter($(this).parent()).css({"border" : "2px solid red"});
            $(".anadir").remove();
            $(".quitar").remove();
            $(".Enviar").fadeIn();
            
            $(".noticia").find("div").dblclick(function() {
                if ($("#tipoUsuario").val() >= seguridad) {
                    console.log($(".edicion").length );
                    if ( $(".edicion").length === 0 ) {
                        $(this).html(modificarContenido($(this)));
                    }
                }
            });

            $(".noticia").find("div").click(function() {
                if ($("#tipoUsuario").val() >= seguridad) {
                    //console.log($(this));
                    if ( $(".edicion").length === 0 ) {
                        $(".noticia").children("div").css("border", "");
                        $(this).css("border", "3px solid blue");
                        var anadir = $("<img>");
                        anadir.prop("src", "../resources/Imagenes/mas.png");
                        anadir.prop("height", "40");
                        anadir.prop("width", "40");
                        anadir.addClass("anadir");
                        anadir.on("click", anadirNoticia);
                        $(this).parent().append(anadir);
                    
                        var quitar = $("<img>");
                        quitar.prop("src", "../resources/Imagenes/menos.png");
                        quitar.prop("height", "40");
                        quitar.prop("width", "40");
                        quitar.addClass("quitar");
                        quitar.on("click", quitarNoticia);
                        $(this).parent().append(quitar);
                    }
                }
            });

            
            console.log(noticiaNueva);
        }
        
        function quitarNoticia() {
            if (confirm("Vamos a eliminar este apartado. Confirma la eliminacion.")) {
                $(this).parent().remove();
                $(".Enviar").fadeIn();
            }
        }

        function modificarContenido(id) {
            
            var contenedor = $("<div>");
            contenedor.addClass("edicion");
            contenedor.css({"background-color":"lightgrey","display":"flex", "flex-direction":"row"});
            
            $(".anadir").remove();
            $(".quitar").remove();

            
            var text = $("<textarea>");
            text.prop("id", "texto"+id);
            text.addClass("actualizado");
            text.prop("name", "texto"+id);
            text.prop("rows", "4");
            text.css({"width":"95%", "background-color":"lightgrey"});
            text.text(id.children("a").html()) ;
            //console.log(id.children("a").html());
            
            var contenedorBt = $("<div>");
            contenedorBt.css({"width":"50px", "display":"flex", "flex-direction":"column", "padding":"5px"});
            
            var guardar = $("<img>");
            guardar.prop("src", "../resources/Imagenes/ok.png");
            guardar.prop("height", "42");
            guardar.prop("width", "42");
            guardar.on("click", function() {
                if (confirm("Vamos a actualizar la base de datos. Confirma la accion.")) {
                    var valor=$(".actualizado");
                    var noticias = valor.parent().prev();
                    noticias.html(valor.prop("value"));
                    //console.log(noticias);
                    //console.log(valor);
                    idSec = noticias[0].attributes.idSeccion.value;
                    idCont = noticias[0].attributes.idContenido.value;
                    tit = noticias[0].attributes.tipo.value;
                    cont = valor.prop("value");
                    $(id).children(".edicion").remove();

                    if (idCont > 0) {
                        $.post("../models/grabarRegistro.php",
                        {
                          idCont: idCont,
                          idSec: idSec,
                          titulo: tit,
                          contenido: cont,
                          ctl: "noticias"
                        },
                        function(data,status){
                            alert("Data: " + data + "\nStatus: " + status);
                        });
                    } else {
                        alert("Para modificar un registro vacio primero debe pulsar el botón <Guardar Cambios>")
                    };
                }
            });

            var cancelar = $("<img>");
            cancelar.prop("src", "../resources/Imagenes/cancelar.png");
            cancelar.prop("id", "cancelar");
            cancelar.prop("height", "42");
            cancelar.prop("width", "42");
            cancelar.on("click", function() {
                $(id).children(".edicion").remove();
            });
            
            contenedorBt.append(guardar);
            contenedorBt.append(cancelar);
            contenedor.append(text);
            contenedor.append(contenedorBt);
            
            $(id).append(contenedor);
        }

/* ************************** Iniciamos las acciones a realizar una vez cargada la pagina ***************  */
	$("body").css("background", bgNormal);
        $(".titNoticia").css("background", bgClaro);
        $(".contNoticia").css("background", bgClaro);
        $(".titNoticia").prop( "disabled", true );
        $(".contNoticia").prop( "disabled", true );
        $(".noticia").find("textarea").hide();
        $(".Enviar").hide();
        $("#btAlert").click(function() {
            $(".alerta").remove();
        });
    
	$("#btRegistrar").click(function(){
		$("#registroUsuario").show();
	});
	$(".opcion").click(function() {
            if (  ($(".Enviar").length === 0 ) || 
                  ($(".Enviar").css("display") === "none" || 
                  ($(".Enviar").css("display") !== "none" && confirm("Si continuas perderás los cambios realizados. Confirma la operación.")))  ) {
                var seccion="#seccion"+$(this).attr("id").slice(-1);
                $(this).css("background-color","#3e8e41");
		$(".seccionSel").toggleClass("seccionSel");
		$(seccion).toggleClass("seccionSel");
                $("#ctl").val($(this).prop("id"));
                $("#frmSeccion").submit();
            }
	});

        $(".noticia").find("div").dblclick(function() {
            if ($("#tipoUsuario").val() >= seguridad) {
                console.log($(".edicion").length );
                if ( $(".edicion").length === 0 ) {
                    $(this).html(modificarContenido($(this)));
                }
            }
        });
        
        $(".noticia").find("div").click(function() {
            if ($("#tipoUsuario").val() >= seguridad) {
                //console.log($(this));
                if ( $(".edicion").length === 0 ) {
                    // $(".noticia").children("div").css("border", "");
                    //$(this).css("border", "3px solid blue");
                    $(".noticia").css("border", "2px solid yellow");
                    $(this).parents(".noticia").css("border", "3px solid blue");
                    $(".anadir").remove();
                    $(".quitar").remove();
                    var anadir = $("<img>");
                    anadir.prop("src", "../resources/Imagenes/mas.png");
                    anadir.prop("height", "40");
                    anadir.prop("width", "40");
                    anadir.addClass("anadir");
                    anadir.on("click", anadirNoticia);
                    $(this).parent().append(anadir);
                    
                    var quitar = $("<img>");
                    quitar.prop("src", "../resources/Imagenes/menos.png");
                    quitar.prop("height", "40");
                    quitar.prop("width", "40");
                    quitar.addClass("quitar");
                    quitar.on("click", quitarNoticia);
                    $(this).parent().append(quitar);
                    
                }
            }
        });

        $(".noticia").click(function() {
            if ($("#tipoUsuario").val() >= seguridad) {
                //console.log($(this));
                if ( $(".edicion").length === 0 ) {
                    $(".noticia").css("border", "2px solid yellow");
                    $(this).css("border", "3px solid blue");
                    $(".anadir").remove();
                    $(".quitar").remove();
                    var anadir = $("<img>");
                    anadir.prop("src", "../resources/Imagenes/mas.png");
                    anadir.prop("height", "40");
                    anadir.prop("width", "40");
                    anadir.addClass("anadir");
                    anadir.on("click", anadirNoticia);
                    $(this).append(anadir);
                    
                    var quitar = $("<img>");
                    quitar.prop("src", "../resources/Imagenes/menos.png");
                    quitar.prop("height", "40");
                    quitar.prop("width", "40");
                    quitar.addClass("quitar");
                    quitar.on("click", quitarNoticia);
                    $(this).append(quitar);
                    
                }
            }
        });

        $(".frmGuardar").submit(function(event){
            //event.preventDefault(event);
            
            var datos = [];
            var idCont;
            var idSec;
            var tit;
            var cont;
            var a = 1;
            $(".noticia").find("a").each(function() {
                if (a === 1) {
                    idCont = $(this).attr("idcontenido");
                    idSec = $(this).attr("idseccion");
                    tit = $(this).text();
                    a = 2;
                } else {
                    cont = $(this).text();
                    //datos.push({"idContenido":idCont,"idSeccion":idSec, "titulo": tit, "contenido":cont});
                    datos.push([["idContenido", idCont], ["idSeccion", idSec], ["titulo",  tit], ["contenido", cont]]);
                    a = 1;
                }
            });
            console.log(datos);
            var myJSON = JSON.stringify(datos);
            $(".btEnviar").val(myJSON);
            console.log($(".btEnviar").val());

            return true;
        });
        $("#frmRegistro").submit(function(event) {
            //event.preventDefault(event);
            var regExp, errores = "";
            regExp    = new RegExp( /[a-z]{3,200}/i );
            if ( !regExp.test( $("#regNom").val() ) ) {
                errores += "Error en el nombre"+"\r";
            };
            regExp    = new RegExp( /[a-z]{3,200}/i );
            if ( !regExp.test( $("#regApe").val() ) ) {
                errores += "Error en el apellido"+"\r";
            };
            regExp    = new RegExp( /[a-z]{3,200}/i );
            if ( !regExp.test( $("#regPas").val() ) ) {
                errores += "Error en el password"+"\r";
            };
            regExp    = new RegExp( /[0-9]{1,1}/i );
            if ( !regExp.test( $("#regSeg").val() ) ) {
                errores += "Error en el nivel de seguridad"+"\r";
            };
            regExp    = new RegExp( /[a-z]{3,200}/i );
            if ( !regExp.test( $("#regDir").val() ) ) {
                errores += "Error en la direccion"+"\r";
            };
            regExp    = new RegExp( /[0-9]{5,5}/i );
            if ( !regExp.test( $("#regCp").val() ) ) {
                errores += "Error en el cp"+"\r";
            };
            regExp    = new RegExp( /[a-z]{3,200}/i );
            if ( !regExp.test( $("#regLoc").val() ) ) {
                errores += "Error en la localidad"+"\r";
            };
            regExp    = new RegExp( /[a-z]{3,200}/i );
            if ( !regExp.test( $("#regPro").val() ) ) {
                errores += "Error en la provincia"+"\r";
            };
            regExp    = new RegExp( /[0-9]{3,3}.[0-9]{2,2}.[0-9]{2,2}.[0-9]{2,2}/i );
            if ( !regExp.test( $("#regTel").val() ) ) {
                errores += "Error en el telefono: xxx.xx.xx.xx"+"\r";
            };
            regExp    = new RegExp( /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/ );
            if ( !regExp.test( $("#regEma").val() ) ) {
                errores += "Error en el email"+"\r";
            };
            if (errores === "") {
                return true
            } else {
                alert(errores);
                return false;
            }
        });
        
        
        /* ********************** Definir el orden de las noticias *************  */
        $(".noticia").each(function() {
            $(this).css("order", $(this).attr("orden"));
        });
});

