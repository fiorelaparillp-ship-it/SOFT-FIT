<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("checkin")){
    header("Location: dashboard.php");
    exit();
}

$modulo = $_GET['modulo'] ?? 'usuarios';

$permitidos = [
    "usuarios",
    "permisos",
    "gimnasio",
    "apariencia",
    "ventas",
    "membresias",
    "reportes",
    "backup"
];

if(!in_array($modulo,$permitidos)){
    $modulo = "usuarios";
}

include("modulos/".$modulo.".php");