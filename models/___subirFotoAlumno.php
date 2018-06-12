<?php
require_once "../models/Service.class.php";

 $archivo = $_FILES["archivito"]["tmp_name"]; 
 $tamanio = $_FILES["archivito"]["size"];
 $tipo    = $_FILES["archivito"]["type"];
 $nombre  = $_FILES["archivito"]["name"];
 $id  = $_POST["id"];

 if ( $archivo != "none" )
 {
    $fp = fopen($archivo, "rb");
    $contenido = fread($fp, $tamanio);
    $contenido = addslashes($contenido);
    fclose($fp); 
    $q = new Service();
    $q->putFotoAlumno($id, $contenido);
    
 }
