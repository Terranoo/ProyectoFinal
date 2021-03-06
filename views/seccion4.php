<?php ob_start() ?>

<div class="principal">

    <?php


            if (isset($_POST["cambios"])) {                       // ************* Si ham modificado la pagina web guardamos de nuevo la pagina web en la base de datos ************
                $us=new Service();
                $datos=json_decode($_POST["cambios"]);
                $us->putCursos($datos);
            }
    
            $q = new Service();
            $datosSeccion = $q->getCursos();
    ?>
            <div class="Enviar">
                <!--  Primera parte de la seccion: boton para guardar todos los cambios si ha habido cambios en el orden o cantidad.   -->
                <form id="frmGuardarCursos" class="frmGuardarCursos" action="" method="post">
                    <input type="hidden" name="tipo" value="cursos">
                </form>
                <button form="frmGuardarCursos" class="btEnviar" type="submit" name="cambios">Guardar cambios</button>
            </div>
            
            <section id="seccion" class="seccion">
                <?php foreach ($datosSeccion as $key => $value) { // **** Un bucle para mostrar cada uno de los  cursos ***   ?>
                <table class="curso">
                    <tr>
                        <td style = "text-align: center;">
                            <img src="../resources/Imagenes/<?php echo $datosSeccion[$key]["logoCurso"] ?>" class="imgLogoCurso" >
                        </td>
                        <td>
                            <form method="post" action="" class="datosCurso">
                                <?php foreach ($datosSeccion[$key] as $key2 => $value2) {
                                if ($key2!="logo_Curso") {  /* *** en todos los campos menos en el logo, calculamos las lineas que se necesitan  *** */
                                    $ancho=110;  
                                    $cadena=$value2; 
                                    if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {  
                                      $eol="\r\n";  
                                    } elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {  
                                      $eol="\r";  
                                    } else {  
                                      $eol="\n";  
                                    }  
                                    $cad=wordwrap($cadena, $ancho, $eol, 1);  
                                    /* *** Calculamos que nos ocupa la cadena según el anocho que tenemos definido
                                     * *** y en la descripcion del curso ponermos un minimo de 4 lineas ***  */
                                    $lineas=substr_count($cad,$eol)+1;          
                                    if ($key2 === "descripcionCurso" && $lineas < 2 )
                                        $lineas = 4;
                                ?>
                                <div class="<?php echo "div".$key2 ?>">
                                    <h2 style="width:100%"><?php echo $key2 ?></h2>
                                    <textarea style="width:98%" 
                                              name="<?php echo $key2 ?>" 
                                              class="<?php echo $key2 ?>" 
                                              cols="<?php echo $ancho ?>" 
                                              rows="<?php echo $lineas ?>"><?php echo $value2 ?></textarea>
                                </div>
    <?php
                }
            }
    ?>
                                <input type="hidden" id="edicion" value="">
                            </form>
                        </td>
                        <td class="botones"></td>
                    </tr>
                </table>
    <?php
        }
    ?>
            </section>
            <button form="frmGuardarCursos" class="btEnviar" type="submit" name="cambios">Guardar cambios</button>
        </div>
</div>

<?php 

$contenido = ob_get_clean();

include '../views/layout.php' 

?>