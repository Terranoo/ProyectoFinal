// *****************************************************************************************************************
// *****************************************  Empieza el Proyecto Final ********************************************
// *****************************************************************************************************************


//queremos que esta variable sea global
var fileName = "";
var fileExtension = "";

$(document).ready(function() {

    var bgNormal="url('../resources/Imagenes/fotoportada.jpg') no-repeat fixed";
    var bgClaro="url('../resources/Imagenes/fotoportada_claro.jpg') no-repeat fixed";
    var seguridad = 2;

    function guardarCurso(puntoPartida) {
                    console.log(puntoPartida.length);
                    if ( puntoPartida.length !== 1 ) {
                        puntoPartida = $(this);
                    }
                    //var puntoPartida = $(this);
                    if (confirm("Vamos a actualizar la base de datos. Confirma la accion.")) {
                        //console.log( typeof puntoPartida !== 'undefined' );
                        if (puntoPartida.parents(".curso").find(".idCurso").val() > 0) {
                            $.post("../models/grabarRegistro.php",
                            {
                              id: puntoPartida.parents(".curso").find(".idCurso").val(),
                              nombre: puntoPartida.parents(".curso").find(".nombreCurso").val(),
                              descripcion: puntoPartida.parents(".curso").find(".descripcionCurso").val(),
                              inicio: puntoPartida.parents(".curso").find(".inicioCurso").val(),
                              duracion: puntoPartida.parents(".curso").find(".duracionCurso").val(),
                              logo: puntoPartida.parents(".curso").find(".logoCurso").val(),
                              ctl: "cursos"
                            },
                            function(data,status){
                                alert("Data: " + data + "\nStatus: " + status);
                            });
                        } else {
                            alert("Para modificar un registro vacio primero debe pulsar el botón <Guardar Cambios>")
                        };
                        $(".curso").find("textarea").prop("disabled", true);
                        $(".botones").children("img").remove();
                        $("#edicion").val("");
                    };
                };
    
    function clickCurso() {
        if ($("#tipoUsuario").val() >= seguridad) {
            if ( $("#edicion").val() === "" ) {
                $(".curso").css("border", "3px solid yellow");
                $(this).css("border", "3px solid blue");
                $(".anadir").remove();
                $(".quitar").remove();
                $(".frmImagen").remove();
                $(this).find(".frmImagen").fadeIn();
                var anadir = $("<img>");
                anadir.prop("src", "../resources/Imagenes/mas.png");
                anadir.css("height", "70");
                anadir.css("width", "70");
                anadir.addClass("anadir");
                anadir.on("click", anadirCurso);
                $(this).append(anadir);

                var quitar = $("<img>");
                quitar.prop("src", "../resources/Imagenes/menos.png");
                quitar.css("height", "60");
                quitar.css("width", "60");
                quitar.addClass("quitar");
                quitar.on("click", quitarCurso);
                $(this).append(quitar);

            } else {
                if ($(this).find("textarea").prop("disabled") === false) {
                    $(".curso").find("textarea").prop("disabled", true);
                    $(".curso").find(".frmImagen").hide();
//                    $(".cursoSel").attr("class", "curso");
                    $("#edicion").val("");
                }
            }
        }
    }
    
    function dblClickCurso() {
        if ($("#tipoUsuario").val() >= seguridad) {                /* ***** Si nuestro nivle de seguridad nos lo permite entramos a la modificacion de los datos ****** */
            var valorOriginal = [];
            if ( $("#edicion").val() === "" ) {                    /* ***** Si no estamos ya editando creamos lo elementos y empezamos la edicion ***** */
                $(".anadir").remove();
                $(".quitar").remove();
                $("#edicion").val("activo");
                $("curso").find("textarea").prop("disabled", true);
                $(this).find("textarea").prop("disabled", false);
                $(this).find(".idCurso").prop("disabled", true);
                $(this).find("textarea").each(function() {
                    valorOriginal.push($(this).val());
                });

/* *********************************************************************************************************** */

                var cambiarLogo = $("<form>");
                cambiarLogo.prop("enctype","multipart/form-data");
                cambiarLogo.prop("class", "frmImagen")
                var inputFile = $("<input>");
                inputFile.prop({"name":"archivo", "type":"file", "id":"imagen", "accept":"image/*"}).css("margin", "10px");
                var inputEnviar = $("<input>");
                inputEnviar.prop("type","button").css("margin", "10px").val("Subir imagen");
                var msg = $("<div>");
                msg.prop("class", "messages");
                cambiarLogo.append(inputFile);
                cambiarLogo.append($("<br>"));
                cambiarLogo.append(inputEnviar);
                cambiarLogo.append($("<br>"));
                cambiarLogo.append(msg);
                $(this).find("td:first-child").append(cambiarLogo);
                
                
                //  **************************************************************************************************
                //función que observa los cambios del campo file y obtiene información
                $(':file').change(function() {
                    //obtenemos un array con los datos del archivo
                    var file = $("#imagen")[0].files[0];
                    //obtenemos el nombre del archivo
                    fileName = file.name;
                    //obtenemos la extensión del archivo
                    fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
                    //obtenemos el tamaño del archivo
                    var fileSize = file.size;
                    //obtenemos el tipo de archivo image/png ejemplo
                    var fileType = file.type;
                    //mensaje con la información del archivo
                    showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
                    $(this).parents(".curso").find(".logoCurso").text(fileName);
                });

                //al enviar el formulario
                $(':button').click(function(){
                    //información del formulario
                    var formData = new FormData($(".frmImagen")[0]);
                    var message = ""; 
                    //hacemos la petición ajax  
                    $.ajax({
                        url: '../models/upload.php',  
                        type: 'POST',
                        // Form data
                        //datos del formulario
                        data: formData,
                        //necesario para subir archivos via ajax
                        cache: false,
                        contentType: false,
                        processData: false,
                        //mientras enviamos el archivo
                        beforeSend: function(){
                            message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
                            showMessage(message)        
                        },
                        //una vez finalizado correctamente
                        success: function(data){
                            message = $("<span class='success'>La imagen ha subido correctamente.</span>");
                            showMessage(message);
                        },
                        //si ha ocurrido un error
                        error: function(){
                            message = $("<span class='error'>Ha ocurrido un error.</span>");
                            showMessage(message);
                        }
                    });
                    //guardarCurso($(this).parents(".curso").find(".logoCurso"));
                    $(this).parents("td").find("img").prop("src","../resources/Imagenes/" + fileName)
                    console.log($(this).parents("td").find("img"));
                });
                        // ***********************************************************************************************
                
/* ************************************************************************************************ */
              
                var guardar = $("<img>");
                guardar.prop("src", "../resources/Imagenes/ok.png");
                guardar.prop("height", "42");
                guardar.prop("width", "42");
                guardar.css({"display":"block", "margin":"50px 0px 50px 0px"});
                guardar.on("click", guardarCurso);

                var cancelar = $("<img>");
                cancelar.prop("src", "../resources/Imagenes/cancelar.png");
                cancelar.prop("height", "42");
                cancelar.prop("width", "42");
                cancelar.css({"display":"block", "margin":"50px 0px 50px 0px"});
                cancelar.on("click", function() {
                    $(this).parents(".curso").find(".idCurso").val(valorOriginal[0]);
                    $(this).parents(".curso").find(".nombreCurso").val(valorOriginal[1]);
                    $(this).parents(".curso").find(".descripcionCurso").val(valorOriginal[2]);
                    $(this).parents(".curso").find(".inicioCurso").val(valorOriginal[3]);
                    $(this).parents(".curso").find(".duracionCurso").val(valorOriginal[4]);
                    $(this).parents(".curso").find(".logoCurso").val(valorOriginal[5]);
                    $(".curso").find("textarea").prop("disabled", true);
                    $(".botones").children("img").remove();
                    $(".frmImagen").remove();
                    $("#edicion").val("");
                });

                $(this).find(".botones").append(guardar);
                $(this).find(".botones").append(cancelar);

                
            } else {
                if ($(this).find("textarea").prop("disabled") === false) {
                    $(".curso").find("textarea").prop("disabled", true);
                    $("#edicion").val("");
                }
            }
            
        }            
    }
    
    function anadirCurso() {
        var curso = $(this).parent();
        var cursoNuevo = curso.clone();
        cursoNuevo.find("textarea").html("").val("");
        cursoNuevo.insertAfter($(this).parent()).css({"border" : "2px solid red"});
        $(".anadir").remove();
        $(".quitar").remove();
        $(".Enviar").fadeIn();

        $(".curso").dblclick(function() {
            if ($("#tipoUsuario").val() >= seguridad) {
                $(this).children("textarea").prop("disabled", true);
            }
        });

        $(".curso").click(function() {
            if ($("#tipoUsuario").val() >= seguridad) {
                    $(".curso").children("").css("border", "");
                    $(this).css("border", "3px solid blue");
                    $(".anadir").remove();
                    $(".quitar").remove();
                    var anadir = $("<img>");
                    anadir.prop("src", "../resources/Imagenes/mas.png");
                    anadir.css("height", "70");
                    anadir.css("width", "70");
                    anadir.addClass("anadir");
                    anadir.on("click", anadirCurso);
                    $(this).append(anadir);

                    var quitar = $("<img>");
                    quitar.prop("src", "../resources/Imagenes/menos.png");
                    quitar.css("height", "60");
                    quitar.css("width", "60");
                    quitar.addClass("quitar");
                    quitar.on("click", quitarCurso);
                    $(this).append(quitar);
            }
        });
    }

    function quitarCurso() {
        if (confirm("Vamos a eliminar este curso. Confirma la eliminacion.")) {
            if ($(this).parent().find(".idCurso").val() === "") {
                $(this).parent().remove();
                $(".Enviar").fadeIn();
            } else {
                alert("Este curso ya tiene asignado un id y no puede eliminarse");
            }
        }
    }

    $(".curso").css("background", bgClaro);
    $(".Enviar").hide();
    $(".divlogoCurso").hide();
    $(".frmImagen").hide();
    $(".curso").find("textarea").prop("disabled", true);
    $(".curso").dblclick(dblClickCurso);
    $(".curso").click(clickCurso);
    $(".frmGuardarCursos").submit(function(event) {
        //event.preventDefault(event);
        var datos = [];
        var array = [];
        var tit;
        var cont;
        console.log($(".frmGuardarCursos"));
        datos = [];
        $(".datosCurso").each(function() {
            array = [];
            $(this).find("textarea").each(function() {
                tit = $(this).prop("class");
                cont = $(this).val();
                array.push( [ tit, cont ] );
            }); 
            datos.push(array);
        });
        console.log(datos);
        var myJSON = JSON.stringify(datos);
        $(".btEnviar").val(myJSON);
        console.log($(".btEnviar").val());
        return true;
    });
    $(".inicioCurso").focus(function(event) {
        event.preventDefault();
        var fecha = $("<input>");
        fecha.prop("type", "date");
        fecha.prop("name", "inFecha");
        fecha.prop("id", "inFecha");
        fecha.val($(this).val());
        fecha.on({change: function() {
            $(this).prev().val($(this).val());
            $(this).prev().fadeIn();
            $(this).remove();
        }, focusout: function() {
            console.log($(this).prev());
            $(this).prev().fadeIn();
            $("#inFecha").remove();
        }
        });
        $(this).hide();
        $(this).parent().append(fecha);
        //$("#inFecha").focus();
        $("#inFecha").select();
    });

});

//como la utilizamos demasiadas veces, creamos una función para 
//evitar repetición de código
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}

