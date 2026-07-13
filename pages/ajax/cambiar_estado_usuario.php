<?php
/** @var mysqli $conexion */
session_start();

include("../../includes/conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

$id = intval($_POST['id']);
$estado = $_POST['estado'];

$nuevoEstado = ($estado=="Activo") ? "Inactivo" : "Activo";

mysqli_query(
    $conexion,
    "UPDATE usuario
     SET estado='$nuevoEstado'
     WHERE id='$id'"
);

echo $nuevoEstado;