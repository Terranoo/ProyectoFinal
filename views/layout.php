<!DOCTYPE html>
<html>
<meta charset="iso-8859-1">
<head>
	<title>Informática La Torrassa</title>
	<link rel="stylesheet" type="text/css" href="../resources/ilt.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="../models/jq_general.js"></script>
        <script src="../models/jq_cursos.js"></script>
        <script src="../models/jq_alumno.js"></script>
</head>
<body>
<!--  **********  Empezamos el Proyecto Final  **************** -->

<?php
if (isset($_POST["altaUsuario"])) {                       // ******** Si alguien ha rellenado el formulario de alta de usuarios *************
	$nombre = tratar_entrada($_POST['nom']);
	$apellidos = tratar_entrada($_POST['ape']);
	$user_pass = tratar_entrada($_POST['pass']);
        $user_seg = tratar_entrada($_POST['seg']);
        $user_dir = tratar_entrada($_POST['dir']);
        $user_cp = tratar_entrada($_POST['cp']);
        $user_loc = tratar_entrada($_POST['loc']);
        $user_pro = tratar_entrada($_POST['pro']);
        $user_tel = tratar_entrada($_POST['tel']);
        $user_ema = tratar_entrada($_POST['ema']);
	$us=new Service();
	$result_alta=$us->altaUsuario($nombre, $apellidos, password_hash($user_pass, PASSWORD_DEFAULT), $user_seg, $user_dir, $user_cp, $user_loc, $user_pro, $user_tel, $user_ema);
        /* ***** La variable $result_alta la utilizare para mostrar el resultado de la creación del usuario **** */
        
}

if (isset($_POST['usuario']) && isset($_POST['pass'])){           // ************* Si se intentan loguear ********
	$usuario = tratar_entrada($_POST['usuario']);
	$user_pass = tratar_entrada($_POST['pass']);
	$us=new Service();
	$user=$us->validaUsuario($usuario, $user_pass);
        //$user_id=$user["idUsuario"];
	if ($user != '0') {
		$_SESSION['user'] = $usuario;
		$_SESSION['idUsuario'] = $user["idUsuario"];
	} else {
            alert("Password incorrecto. Intentalo de nuevo.");
        }
}
if (isset($_POST['logout'])){                                     // ************* si cerramos la session del usuario *********
    unset($_SESSION["user"]);
    unset($_SESSION["idUsuario"]);
    unset($_SESSION['seccionSel']); 

    header ("Refresh:0");//  header("Location: URL");
}  
if (!isset($_SESSION['user']) && isset($_POST["btRegistrar"])):   // ************* Si quieren registrarse en la web ****************
    include_once '../views/registro.php';
endif;
if ( isset($result_alta) ) {
    if ($result_alta) {
        alert("Se ha añadido el usuario correctamente");          // ************* Funcion escrita en PHP para mostrar un mensaje *******
    } else {
        alert("Se ha producido un error al añadir el usuario. Por favor vuelva a intentarlo.");      // ******* Funcion escrita en PHP para mostrar un mensaje *******
    }
}

/* ***************************** Aqui empezamos a colocar elementos web ************************************************************************* */
if (isset($_SESSION['user'])) {                                   /* ************** Si hemos iniciado la sesion y definimos el tipo de usuario: los permisos **** */
    $us=new Service();
    $nivelSeguridad=$us->nivelSeguridad($_SESSION['idUsuario']);
?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="cabecera">
            <h3>Bienvenido, <?php echo $_SESSION['user']; ?></h3></ br>
            <h4>Nivel de seguridad: <?php echo $nivelSeguridad; ?></h4></ br>
            <input type="submit" name="logout" value="Salir">
            <input id="tipoUsuario" value="<?php echo $nivelSeguridad; ?>" type="number" id="btEdicion" style="display:none"> </h4>
		
	</form>
<?php 
} else { 

    if (!isset($_POST["btEntrar"]) && !isset($_POST["btRegistrar"])) {
?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="cabecera">
            <h3><input type="submit" name="btEntrar" value="Entrar"></h3>		
            <h3><input type="submit" name="btRegistrar" value="Registrar"></h3>		
	</form>
<?php 
    }
    if ( isset($_POST["btEntrar"])) { 
        $_SESSION['seccionSel'] = "seccion1";
?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="login">
		Usuario: <input type="text" name="usuario" value=""><br />
		Contraseña: <input type="password" name="pass" value=""><br />
		<input type="submit" name="entrar" value="Entrar"><br />		
	</form>
<?php 
    }
}
?>


    <form id="frmSeccion" action="" method="POST" >
        <input type="hidden" name="ctl" id="ctl" />
    </form>
    <nav class="menu">
    <?php
        $q = new Service();
        $secciones = $q->getSeccionesWeb();

        $sel = substr($_SESSION["seccionSel"], -1);
        for ($i=1; $i<=count($secciones); $i++) {
    ?>
            <div id="seccion<?php echo $i ?>" class="opcion <?php echo ( ($i==$sel)? "opcionSel":"" ) ?>"><?php echo $secciones[$i-1]['Seccion']; ?></div>
    <?php
        }
    ?>
    </nav>
    <br />


    <div id="contenido">
        <?php echo $contenido ?>
    </div>

</body>
</html>