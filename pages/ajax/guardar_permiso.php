<?php
session_start();
/** @var mysqli $conexion */
include("../../includes/conexion.php");

if($_SESSION['rol'] != "Administrador"){
    exit("Sin permisos");
}

$id = intval($_POST['id']);
$permitido = intval($_POST['permitido']);

mysqli_query(

    $conexion,

    "UPDATE permisos
     SET permitido='$permitido'
     WHERE id='$id'"

);

echo "ok";