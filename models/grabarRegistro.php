<?php


require_once "../models/Service.class.php";


switch ($_POST["ctl"]) {
    case "noticias":
        $cont=new Service();
        $result=$cont->updateContenidoWeb($_POST["idCont"], $_POST["titulo"], $_POST["contenido"]);
        break;
    case "cursos":
        $cont=new Service();
        $result=$cont->updateCurso($_POST["id"], $_POST["nombre"], $_POST["descripcion"], $_POST["inicio"], $_POST["duracion"], $_POST["logo"]);
        break;
    default:
        break;
}
 


echo $result;