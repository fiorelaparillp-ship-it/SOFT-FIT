<?php
/** @var mysqli $conexion */



$usuarios = mysqli_query(
$conexion,
"SELECT * FROM usuario
ORDER BY id DESC"
);

?>
