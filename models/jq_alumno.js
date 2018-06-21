// *****************************************************************************************************************
// *****************************************  Empieza el Proyecto Final ********************************************
// *****************************************************************************************************************

$(document).ready(function() {

	var bgNormal="url('../resources/Imagenes/fotoportada.jpg') no-repeat fixed";
	var bgClaro="url('../resources/Imagenes/fotoportada_claro.jpg') no-repeat fixed";
        var seguridad = 1;  /* *** Se requiere un nivel de seguridad 1 para entrar y modificar datos *** */
        
        /* *** Si no somos profesor o adeministrador (2/3) se ocultan los controles *** */
        if ( $("#tipoUsuario").val() < 2 ) {
            $("#selectAlumno").hide();
            $(".nivelSeguridad").prop("disabled", true);
            $("#idCurso").prop("disabled", true);
            $("#comCurso").prop("disabled", true);
            $("#notCurso").prop("disabled", true);
            $("#frmCursosAlumno").find("input").prop("disabled", true);
            $("#frmCursosAlumno").find("select").prop("disabled", true);
        }
        
	$("body").css("background", bgNormal);
        $(".alumno").css("background", bgClaro);
        $("#btAlert").click(function() {
            $(".alerta").remove();
        });
        $(".idCurso").change(function() {
            $("#frmCursosAlumno").submit();
        });
        $(".comCurso").change(function() {
            $("#frmCursosAlumno").submit();
        });
        $(".notCurso").change(function() {
            $("#frmCursosAlumno").submit();
        });
        $("#selectAlumno").change(function() {
            $("#frmSelectAlumno").submit();
        });
        $(".frmSelectAlumno").submit(function(event){
            return true;
        });
        $(".frmGuardarAlumno").submit(function(event){
            var datos = [];
            /* *** Repasamos todos los inputs del alumno para crear un array que convertimos en json y pasamos como post al formulario *** */
            $(".alumno").find("input").each(function() {
                datos.push([$(this)[0].classList[1], $(this).val()]);
            });
            var myJSON = JSON.stringify(datos);
            $(".btEnviar").val(myJSON);
            console.log(datos);
            return true;
        });

        $("#frmCursosAlumno").submit(function() {
            var array = [];
            var idCH = $("#frmCursosAlumno").find(".idCursoHecho");  // *** Seleccionamos todos los idCursoRealizado
            var idC = $("#frmCursosAlumno").find(".idCurso");        // *** Seleccionamos todos los idCurso
            var comC = $("#frmCursosAlumno").find(".comCurso");      // *** Seleccionamos todos los comentarioCurso
            var notC = $("#frmCursosAlumno").find(".notCurso");      // *** Seleccionamos todos los notaCurso
            /* *** Repasamos todos los datos seleccionados para crear un array que convertimos en json y pasamos como post al formulario *** */
            array = [];
            for (i=0; i<idCH.length ; i++) {
                array.push( [idCH[i].value, idC[i].value, comC[i].value, notC[i].value] );
            };
            var myJSON = JSON.stringify(array);
            $("#btCursos").val(myJSON);
            return true;
        });
        $("#mas").click(function() {                                // *** Añade un curso vacio
            $("#idPoneCurso").val( $("#selectAlumno").val() );
            $("#poneCurso").submit();
        });
        
});

