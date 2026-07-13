<?php

$conexion = mysqli_connect(
    "localhost",
    "root",
    "",
    "softfit"
);
date_default_timezone_set('America/Lima');
mysqli_query($conexion,"SET time_zone='-05:00'");
if(!$conexion){

    die("Error de conexión");

}

?>