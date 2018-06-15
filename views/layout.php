<!DOCTYPE html>
<html>
<meta charset="utf-8">
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

if (filter_input(INPUT_POST, 'altaUsuario') !== NULL) {                       // ******** Si alguien ha rellenado el formulario de alta de usuarios *************
    $args = array(
        'nom'   => FILTER_SANITIZE_STRING,
        'ape'   => FILTER_SANITIZE_STRING,
        'pass'  => FILTER_SANITIZE_STRING,
        'seg'   => FILTER_VALIDATE_INT,
        'dir'   => FILTER_SANITIZE_STRING,
        'cp'    => FILTER_SANITIZE_STRING,
        'loc'   => FILTER_SANITIZE_STRING,
        'pro'   => FILTER_SANITIZE_STRING,
        'tel'   => FILTER_SANITIZE_STRING,
        'ema'   => FILTER_SANITIZE_EMAIL
    );

    $mi_post = filter_input_array(INPUT_POST, $args);

    $nombre = $mi_post['nom'];
    $apellidos = $mi_post['ape'];
    $user_pass = $mi_post['pass'];
    $user_seg  = $mi_post['seg'];
    $user_dir  = $mi_post['dir'];
    $user_cp   = $mi_post['cp'];
    $user_loc  = $mi_post['loc'];
    $user_pro  = $mi_post['pro'];
    $user_tel  = $mi_post['tel'];
    $user_ema  = $mi_post['ema'];
    $us=new Service();
    $result_alta=$us->altaUsuario($nombre, $apellidos, password_hash($user_pass, PASSWORD_DEFAULT), $user_seg, $user_dir, $user_cp, $user_loc, $user_pro, $user_tel, $user_ema);
        /* ***** La variable $result_alta la utilizare para mostrar el resultado de la creación del usuario **** */
        
}

if (filter_input(INPUT_POST, 'usuario') !== NULL && filter_input(INPUT_POST, 'pass') !== NULL){           // ************* Si se intentan loguear ********
    $args = array(
        'usuario'   => FILTER_SANITIZE_STRING,
        'pass'      => FILTER_SANITIZE_STRING
    );

    $mi_post = filter_input_array(INPUT_POST, $args);
    $usuario = $mi_post['usuario'];
    $user_pass = $mi_post['pass'];
    $us=new Service();
    $user=$us->validaUsuario($usuario, $user_pass);
    if ($user != '0') {
            $_SESSION['user'] = $usuario;
            $_SESSION['idUsuario'] = $user["idUsuario"];
    } else {
        alert("Password incorrecto. Intentalo de nuevo.");
    }
}
if (filter_input(INPUT_POST, 'logout') !== NULL){                                     // ************* si cerramos la session del usuario *********
    unset($_SESSION["user"]);
    unset($_SESSION["idUsuario"]);
    unset($_SESSION['seccionSel']); 
    unset($result_alta);

    header ("Refresh:0");//  header("Location: URL");
}  
if (filter_input(INPUT_POST, 'user') === NULL && filter_input(INPUT_POST, 'btRegistrar') !== NULL ):   // ************* Si quieren registrarse en la web ****************
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
    if (filter_input(INPUT_POST, 'btEntrar') === NULL && filter_input(INPUT_POST, 'btRegistrar') === NULL ) {
?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="cabecera">
            <h3><input type="submit" name="btEntrar" value="Entrar"></h3>		
            <h3><input type="submit" name="btRegistrar" value="Registrar"></h3>		
	</form>
<?php 
    }
    if ( filter_input(INPUT_POST, 'btEntrar') !== NULL ) { 
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