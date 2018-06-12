<?php  
require_once "../models/funciones.php";
require_once "../models/Service.class.php";
require_once "../controllers/Controller.class.php";

session_start();


/* ******************** Controller ************************  */

 // enrutamiento
 $map = array(
     'seccion1' => array('controller' =>'Controller', 'action' =>'seccion1'),
     'seccion2' => array('controller' =>'Controller', 'action' =>'seccion2'),
     'seccion3' => array('controller' =>'Controller', 'action' =>'seccion3'),
     'seccion4' => array('controller' =>'Controller', 'action' =>'seccion4'),
     'seccion5' => array('controller' =>'Controller', 'action' =>'seccion5')
 );

 // Parseo de la ruta
 $ruta=(isset($_SESSION['seccionSel']))?$_SESSION['seccionSel']:"seccion1";
 if (isset($_POST['ctl'])) {
     if (isset($map[$_POST['ctl']])) {
         $ruta = $_POST['ctl'];
     } else {
         header('Status: 404 Not Found');
         echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                 $_POST['ctl'] .
                 '</p></body></html>';
         exit;
     }
 }
 $_SESSION['seccionSel'] = $ruta;
 $controlador = $map[$ruta];                                            // Ejecución del controlador asociado a la ruta


 

 if (method_exists($controlador['controller'],$controlador['action'])) {
     call_user_func(array(new $controlador['controller'], $controlador['action']));
 } else {

     header('Status: 404 Not Found');
     echo '<html><body><h1>Error 404: El controlador <i>' .
             $controlador['controller'] .
             '->' .
             $controlador['action'] .
             '</i> no existe</h1></body></html>';
 }


/* ********************************************************  */


?>
