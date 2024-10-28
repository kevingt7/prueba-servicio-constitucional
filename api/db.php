
<?php
// Conexión sencilla a la base de datos
$mysqli = new mysqli("localhost", "root", "", "todo_app");

// Verificar si hubo un error de conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}
?>
