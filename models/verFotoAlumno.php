<?php

require_once "../models/Service.class.php";


$id = $_GET["id"];
$q = new Service();
$fila = $q->getFotoAlumno($id);


echo $fila["fotoAlumno"];
