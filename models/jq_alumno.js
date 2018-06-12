// *****************************************************************************************************************
// *****************************************  Empieza el Proyecto Final ********************************************
// *****************************************************************************************************************

$(document).ready(function() {

	var bgNormal="url('../resources/Imagenes/fotoportada.jpg') no-repeat fixed";
	var bgClaro="url('../resources/Imagenes/fotoportada_claro.jpg') no-repeat fixed";
        var seguridad = 1;
        
        if ( $("#tipoUsuario").val() < 2 ) {
            $("#selectAlumno").hide();
            $(".nivelSeguridad").prop("disabled", true);
            $("#idCurso").prop("disabled", true);
            $("#comCurso").prop("disabled", true);
            $("#notCurso").prop("disabled", true);
            $("#frmCursosAlumno").find("input").prop("disabled", true);
            $("#frmCursosAlumno").find("select").prop("disabled", true);
        }
        
/* ************************** Iniciamos las acciones a realizar una vez cargada la pagina ***************  */
	$("body").css("background", bgNormal);
        $(".alumno").css("background", bgClaro);
        $(".Enviar").hide();
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
            //event.preventDefault(event);
            
            var datos = [];
//            datos.push(["idUsuario", $("#selectAlumno").val()]);
            console.log($(".frmGuardarAlumno").children("input"));
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
            var idCH = $("#frmCursosAlumno").find(".idCursoHecho");
            var idC = $("#frmCursosAlumno").find(".idCurso");
            var comC = $("#frmCursosAlumno").find(".comCurso");
            var notC = $("#frmCursosAlumno").find(".notCurso");
            array = [];
            for (i=0; i<idCH.length ; i++) {
                array.push( [idCH[i].value, idC[i].value, comC[i].value, notC[i].value] );
            };
            var myJSON = JSON.stringify(array);
            $("#btCursos").val(myJSON);
            return true;
        });
        $("#mas").click(function() {
            $("#idPoneCurso").val( $("#selectAlumno").val() );
            $("#poneCurso").submit();
        });
        
});

