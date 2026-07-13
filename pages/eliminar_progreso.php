<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){

    header("Location: ../login.php");

    exit();

}

include("../includes/conexion.php");

$id = $_GET['id'];

mysqli_query($conexion,

"DELETE FROM progreso_cliente
WHERE id='$id'");

header("Location: progreso.php?eliminado=1");

exit();