<?php

echo "INICIO<br>";

$conexion = mysqli_connect(
    "127.0.0.1",
    "root",
    "",
    null,
    3306
);

if(!$conexion){
    die("ERROR: ".mysqli_connect_error());
}

echo "CONECTADO";