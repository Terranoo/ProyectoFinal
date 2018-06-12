<?php ob_start() ?>

<div class="principal">

    <?php
    
            if (isset($_POST["cambios"])) {                       // ************* Si ham modificado la pagina web guardamos de nuevo la pagina web en la base de datos ************
                $us=new Service();
                $datos=json_decode($_POST["cambios"]);
                $us->putContenidoWeb($datos);
            }
    
            $q = new Service();
            $i=3;                /* Creamos toda la seccion 1  */
            $datosSeccion = $q->getContenidoWeb($i);
    ?>
            <div class="Enviar">                        <!--  Primera parte de la seccion: boton para guardar todos los cambios si ha habido cambios en el orden o cantidad.   -->
                <form class="frmGuardar" action="" method="post">
                    <input type="hidden" name="tipo" value="noticias">
                    <button class="btEnviar" type="submit" name="cambios">Guardar cambios</button>
                </form>
            </div>

            <section id="seccion<?php echo $i ?>" class="seccion">

    <?php
        $a = 1;             // ********************* Creamos una variable para contar las noticias y utilizar para ordenar *************
        foreach ($datosSeccion as $key => $value) { 
    ?>
                <div class="noticia" orden="<?php echo $a; ?>" seccion="<?php echo $i ?>">  <!-- Creamos un DIV para cada noticia que contiene un titulo y un contenido   -->
                    <div class="titNoticia" id="tit<?php echo $datosSeccion[$key]['idContenido'] ?>" ><a class="original" tipo="titulo" idSeccion="<?php echo $i ?>" idContenido="<?php echo $datosSeccion[$key]['idContenido'] ?>"><?php echo $datosSeccion[$key]['titulo'] ?></a></div>>
                    <div class="contNoticia" id="cont<?php echo $datosSeccion[$key]['idContenido'] ?>" ><a class="original" tipo="contenido" idSeccion="<?php echo $i ?>" idContenido="<?php echo $datosSeccion[$key]['idContenido'] ?>"><?php echo $datosSeccion[$key]["contenido"] ?></a></div>                                            
                </div>
    <?php
            $a++;
        }
    ?>
            </section>
            <div class="Enviar">                        <!--  Final de la seccion: otro boton para guardar todos los cambios si ha habido cambios en el orden.   -->
                <form class="frmGuardar" action="" method="post">
                    <input type="hidden" name="tipo" value="noticias">
                    <button class="btEnviar" type="submit" name="cambios">Guardar cambios</button>
                </form>
            </div>
</div>

<?php $contenido = ob_get_clean() ?>

<?php include '../views/layout.php' ?>
