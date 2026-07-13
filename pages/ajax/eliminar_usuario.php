<?php
/** @var mysqli $conexion */
session_start();

include("../../includes/conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

$id = intval($_POST['id']);



mysqli_query(
    $conexion,
    "DELETE FROM usuario
     WHERE id='$id'"
);

echo "ok";