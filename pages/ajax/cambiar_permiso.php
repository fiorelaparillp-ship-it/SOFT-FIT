<?php
session_start();
/** @var mysqli $conexion */
include("../../includes/conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
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