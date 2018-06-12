<?php 
require_once "../models/Service.class.php"; 
class Controller {
	function inicio() {
		include "../views/inicio.php";
		//echo file_get_contents("../views/vista.php");
	}
	function seccion1() {
		include "../views/seccion1.php";
		//echo file_get_contents("../views/vista.php");
	}
	function seccion2() {
		include "../views/seccion2.php";
		//echo file_get_contents("../views/vista.php");
	}
	function seccion3() {
		include "../views/seccion3.php";
		//echo file_get_contents("../views/vista.php");
	}
	function seccion4() {
		include "../views/seccion4.php";
		//echo file_get_contents("../views/vista.php");
	}
	function seccion5() {
		include "../views/seccion5.php";
		//echo file_get_contents("../views/vista.php");
	}
}
?>