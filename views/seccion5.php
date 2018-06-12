<?php 
    ob_start();
    
    if ( isset($_SESSION['idUsuario']) ) {
?>

<div class="principal">

    <?php


            $idAlumno = $_SESSION['idUsuario'];
            if (isset($_POST["cambios"])) { 
                $us=new Service();
                $datos=json_decode($_POST["cambios"]);
                $us->updateUsuario($datos);
                $idAlumno = $datos[0][1];
            }
            if (isset($_POST["idAlumno"])) {  
                $idAlumno = $_POST["idAlumno"];
            }
            if (isset($_POST["subirFoto"])) {  
                $archivo = $_FILES["archivito"]["tmp_name"]; 
                $tamanio = $_FILES["archivito"]["size"];
                $tipo    = $_FILES["archivito"]["type"];
                $nombre  = $_FILES["archivito"]["name"];
                $idAlumno  = $_POST["idAlumno"];

                if ( $archivo != "none" )
                {
                   $fp = fopen($archivo, "rb");
                   $contenido = fread($fp, $tamanio);
                   $contenido = addslashes($contenido);
                   fclose($fp); 
                   $q = new Service();
                   $q->putFotoAlumno($idAlumno, $contenido);

                }
            }
            if (isset($_POST["cursosAlumno"])) {
                $datosCursos=json_decode($_POST["cursosAlumno"]);
                $q = new Service();
                $q->updateCursosAlumno($datosCursos);
            }
            if (isset($_POST["idPoneCurso"])) {
                $q = new Service();
                $q->putCursoAlumno($_POST["idPoneCurso"]);
            }
    
    
    
            $q = new Service();
            $datosAlumnos = $q->getAlumnos();
            $q = new Service();
            $alumno = $q->getAlumno($idAlumno);
            $q = new Service();
            $cursosAlumno = $q->getCursosAlumno($idAlumno);
            $q = new Service();
            $cursos = $q->getCursos();
            
    ?>
    
            <section id="seccion" class="seccion">
                <form id="frmSelectAlumno" class="frmSelectAlumno" action="" method="post">
                    <select id="selectAlumno" class="valorCampo idAlumno>" name="idAlumno">
    <?php
        foreach ($datosAlumnos as $key => $value) {
    ?>
                        <option value="<?php echo $value["idUsuario"] ?>" <?php echo (($value["idUsuario"] === $idAlumno)? "selected":"") ?> >
                            <?php echo $value["idUsuario"]." >>> ".$value["Nombre"].' '.$value["Apellidos"] ?>
                        </option>
    <?php
        }
    ?>
                    </select>
                </form>
                
                

                <div class="imgAlumno">
                    <img src="../models/verFotoAlumno.php?id=<?php echo $idAlumno ?>" class="fotoAlumno">
                     <div class="frmFotoAlumno">
                        <form enctype="multipart/form-data" action="" method="post" >
                            <input type="hidden" name="idAlumno" value="<?php echo $idAlumno ?>">
                            <input type="file" name="archivito" accept="image/*" ><br />
                            <input type="submit" name="subirFoto" value="Enviar archivo">
                        </form>
                    </div>
                </div>
                <form id="frmGuardarAlumno" class="frmGuardarAlumno" action="" method="post">
                    <div class="alumno" >
                        <input type="hidden" name="idAlumno" value="<?php echo $idAlumno ?>">
                        <div class="encabezadoAlumno">
                            <h3 class="nombreCampo2">Codigo Alumno: 
                                <input type="text" class="valorCampo2 idUsuario" name="idUsuario" placeholder="Nuevo idUsuario" value="<?php echo $alumno["idUsuario"] ?>" disabled >    
                            </h3>
                            <h3 class="nombreCampo2">Nivel de Seguridad:
                                <input type="text" class="valorCampo2 nivelSeguridad" name="nivelSeguridad" placeholder="Nuevo nivelSeguridad" value="<?php echo $alumno["nivelSeguridad"] ?>" >    
                            </h3>
                        </div>

                        
                        
                        <h3 class="nombreCampo">Nombre: </h3>
                        <input type="text" class="valorCampo Nombre" name="Nombre" placeholder="Nuevo Nombre" value="<?php echo $alumno["Nombre"] ?>" >
                        <h3 class="nombreCampo">Apellidos: </h3>
                        <input type="text" class="valorCampo Apellidos" name="Apellidos" placeholder="Nuevos Apellidos" value="<?php echo $alumno["Apellidos"] ?>" >
                        <h3 class="nombreCampo">Direccion: </h3>
                        <input type="text" class="valorCampo Direccion" name="Direccion" placeholder="Nueva Direccion" value="<?php echo $alumno["Direccion"] ?>" >
                        <h3 class="nombreCampo">Codigo Postal: </h3>
                        <input type="text" class="valorCampo CP" name="CP" placeholder="Nuevo CP" value="<?php echo $alumno["CP"] ?>" >
                        <h3 class="nombreCampo">Localidad: </h3>
                        <input type="text" class="valorCampo Localidad" name="Localidad" placeholder="Nueva Localidad" value="<?php echo $alumno["Localidad"] ?>" >
                        <h3 class="nombreCampo">Provincia: </h3>
                        <input type="text" class="valorCampo Provincia" name="Provincia" placeholder="Nueva Provincia" value="<?php echo $alumno["Provincia"] ?>" >
                        <h3 class="nombreCampo">Telefono: </h3>
                        <input type="text" class="valorCampo Telefono" name="Telefono" placeholder="Nuevo Telefono" value="<?php echo $alumno["Telefono"] ?>" >
                        <h3 class="nombreCampo">E-mail: </h3>
                        <input type="text" class="valorCampo email" name="email" placeholder="Nuevo email" value="<?php echo $alumno["email"] ?>" >
                        <h3 class="nombreCampo">Password: </h3>
                        <input type="text" class="valorCampo contrasenya" name="contrasenya" placeholder="Nueva contrasenya" value="" maxlength="10">
                    </div>
                               
                    <input type="hidden" name="tipo" value="alumnos">
                    <button form="frmGuardarAlumno" class="btEnviar" type="submit" name="cambios">Guardar cambios</button>
                    </form>
                
                
                
                    <div class="cursos">
                        <form action="" method="post" id="frmCursosAlumno">
                            <input type="hidden" name="idAlumno" value="<?php echo $idAlumno ?>">
                            <table>
                                <tr>
                                    <th>Curso</th>
                                    <th>Fecha de Inicio</th>
                                    <th>Duración del curso</th>
                                    <th>Comentario sobre el curso</th>
                                    <th>Calificación</th>
                                </tr>
                                <?php foreach ($cursosAlumno as $value) { ?>
                                <tr>
                                    <td style="width: 10%">
                                        <input class="idCursoHecho" name="idCursoHecho" type="hidden" value="<?php echo $value['idCursoHecho'] ?>" >
                                        <select class="idCurso" name="idCurso">
                                            <?php foreach ($cursos as $value2) { ?>
                                            <option value="<?php echo $value2["idCurso"] ?>" <?php echo ( ($value["nomCurso"]===$value2["nombreCurso"])? "selected":"") ?> ><?php echo $value2["nombreCurso"] ?></option>
                                            <?php        } ?>
                                        </select>
                                    </td>
                                    <td style="width: 15%"><?php echo $value["iniCurso"] ?></td>
                                    <td style="width: 15%"><?php echo $value["durCurso"] ?></td>
                                    <td style="width: 55%"><input class="comCurso" name="comCurso" type="text" value="<?php echo $value['comCurso'] ?>" size="65" maxlength="250"></td>
                                    <td style="width: 10%"><input class="notCurso" name="notCurso" type="number" value="<?php echo $value['notCurso'] ?>" min="0" max="10"></td>
                                </tr>
                                <?php    } ?>
                            </table>
                            <img id="mas" src="../resources/Imagenes/mas.png">
                            <!-- <img id="menos" src="../resources/Imagenes/menos.png">  -->
                            <input id="btCursos" type="hidden" name="cursosAlumno">
                        </form>
                        <form id="poneCurso" method="post">
                            <input type="hidden" name="idAlumno" value="<?php echo $idAlumno ?>">
                            <input id="idPoneCurso" type="hidden" name="idPoneCurso">
                        </form>
                    </div>

            </section>
    
</div>

<?php 
    } else {
        alert("Esta opción sólo está disponible para usuarios registrados.");
    }
$contenido = ob_get_clean();

include '../views/layout.php' 

?>