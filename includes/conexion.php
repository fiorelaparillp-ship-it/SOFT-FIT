<?php

$host = "mysql-28faa553-fiorelaparillp-efed.g.aivencloud.com";
$user = "avnadmin";
$pass = "CAMBIADO";
$db   = "defaultdb";
$port = 19526;

$conexion = mysqli_init();

mysqli_ssl_set($conexion, NULL, NULL, NULL, NULL, NULL);

if (!mysqli_real_connect(
    $conexion,
    $host,
    $user,
    $pass,
    $db,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
)) {
    die("Error de conexión: " . mysqli_connect_error());
}

date_default_timezone_set('America/Lima');

mysqli_set_charset($conexion, "utf8");

?>