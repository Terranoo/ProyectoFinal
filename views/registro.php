<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="registro">
    <table class="tblRegistro">
        <tr>
            <th>Nombre:</th>
            <td><input type="text" name="nom" value="" size="50"></td>
        </tr>
        <tr>
            <th>Apellidos:</th>
            <td><input type="text" name="ape" value="" size="50"></td>
        </tr>
        <tr>
            <th>Contraseña:</th>
            <td><input type="text" name="pass" value="" size="50"></td>
        </tr>
        <tr>
            <th>Nivel de seguridad:</th>
            <td><input type="number" name="seg" value="1" size="50"></td>
        </tr>
        <tr>
            <th>Dirección:</th>
            <td><input type="text" name="dir" value="" size="50"></td>
        </tr>
        <tr>
            <th>Codigo Postal:</th>
            <td><input type="text" name="cp" value="" size="50"></td>
        </tr>
        <tr>
            <th>Localidad:</th>
            <td><input type="text" name="loc" value="" size="50"></td>
        </tr>
        <tr>
            <th>Provincia:</th>
            <td><input type="text" name="pro" value="" size="50"></td>
        </tr>
        <tr>
            <th>Telefono:</th>
            <td><input type="text" name="tel" value="" size="50"></td>
        </tr>
        <tr>
            <th>e-mail:</th>
            <td><input type="text" name="ema" value="" size="50"></td>
        </tr>
    </table>
    <input type="submit" name="altaUsuario" value="altaUsuario">
</form>
