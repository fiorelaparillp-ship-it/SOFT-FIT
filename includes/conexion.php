<?php

$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$pass = getenv("DB_PASSWORD");
$db   = getenv("DB_NAME");
$port = getenv("DB_PORT");

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

date_defsault_timezone_set('America/Lima');

mysqli_set_charset($conexion, "utf8");

?>