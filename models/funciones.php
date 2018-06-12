<?php  
//session_start();
function tratar_entrada($dato){
    return trim(stripslashes(htmlspecialchars($dato)));
}
function alert($mensaje) {
    echo "<div class='alerta'>";
    echo "<p>" . $mensaje . "</p>";
    echo "<button id='btAlert' style='width:30%'>Aceptar</button>";
    echo "</div>";
}