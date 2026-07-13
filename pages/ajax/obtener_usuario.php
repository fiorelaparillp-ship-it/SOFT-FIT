<?php
/** @var mysqli $conexion */
session_start();

include("../../includes/conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}


$id = intval($_GET['id']);

$consulta = mysqli_query(
    $conexion,
    "SELECT * FROM usuario WHERE id='$id'"
);

$fila = mysqli_fetch_assoc($consulta);

echo json_encode($fila);