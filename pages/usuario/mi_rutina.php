<?php
/** @var mysqli $conexion */
session_start();

if($_SESSION['rol']!="Cliente"){

    header("Location: ../dashboard.php");

}

include("../../includes/conexion.php");

$usuario = $_SESSION['usuario'];
$cliente = mysqli_query($conexion,

"SELECT * FROM clientes
WHERE LOWER(nombre)=LOWER('$usuario')");

$datosCliente = mysqli_fetch_assoc($cliente);

$idCliente = $datosCliente['id'];
$rutina = mysqli_query($conexion,

"SELECT *

FROM rutinas

WHERE cliente_id='$idCliente'

ORDER BY id DESC

LIMIT 1");

$datosRutina = mysqli_fetch_assoc($rutina);
$lineas = explode("\n", str_replace("\r","",$datosRutina['descripcion']));

$diasSemana = [
"Lunes",
"Martes",
"Miércoles",
"Miercoles",
"Jueves",
"Viernes",
"Sábado",
"Sabado",
"Domingo"
];
$totalDias = 0;
$dias = [];

$diaActual = "";

foreach($lineas as $linea){

$linea = trim($linea);

if(in_array($linea,$diasSemana)){

$diaActual = $linea;

$dias[$diaActual] = [];

}else{

if($diaActual!=""){

$dias[$diaActual][] = $linea;

}

}

}
$totalDias = count($dias);
$totalEjercicios = 0;

foreach($dias as $listaEjercicios){

$totalEjercicios += count($listaEjercicios);

}
if($totalDias <= 3){

    $nivel = "STARTER";
    $claseNivel = "starter";

}
elseif($totalDias <= 5){

    $nivel = "PRO";
    $claseNivel = "pro";

}
else{

    $nivel = "ELITE";
    $claseNivel = "elite";

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Mi Rutina</title>


<link rel="stylesheet"
href="../../css/style.css">

</head>

<body>
    <div class="sidebar">

<img src="../../img/logo1.png"
class="logo">
<div class="sidebar-user">

<div class="avatar-sidebar">

<?php echo strtoupper(substr($usuario,0,1)); ?>

</div>

<h3>

<?php echo $usuario; ?>

</h3>

<p>

Cliente

</p>

</div>

<h2></h2>

<ul>

<li>

<a href="index.php">

🏠 Inicio

</a>

</li>

<li>

<a href="mi_membresia.php">

🏋️ Mi Membresía

</a>

</li>
<li>
<a href="mi_rutina.php">
🏋️ Mi Rutina
</a>
</li>

<li>

<a href="mis_asistencias.php">

📅 Mis Asistencias

</a>

</li>

<li>

<a href="mis_compras.php">

🛒 Mis Compras

</a>

</li>
<li>

<a href="mi_progreso.php">

📈 Mi Progreso

</a>

</li>

<li>

<a href="../../logout.php">

🚪 Cerrar sesión

</a>

</li>

</ul>

</div>

<div class="main">

<div class="cards-rutina">

<div class="card">

<h3>🏋️ Ejercicios</h3>

<p><?php echo $totalEjercicios; ?></p>

</div>

<div class="card">

<h3>📅 Días por semana</h3>

<p><?php echo $totalDias; ?></p>
</div>

<div class="card nivel-card <?php echo $claseNivel; ?>">

<h3>⭐ Nivel Fitness</h3>

<div class="badge-nivel">

<?php echo $nivel; ?>

</div>

<small>

<?php echo $totalEjercicios; ?>

ejercicios totales

</small>

</div>

</div>

<br>

<h1>🏋️ Mi Rutina</h1>


<br>

<div class="card rutina-principal">

<h2>

🏋️ <?php echo $datosRutina['titulo']; ?>

</h2>

<p class="rutina-info">

Tu rutina personalizada para alcanzar tus objetivos.

</p>

<br>

<?php


?>

<div class="dias-rutina">

<?php foreach($dias as $nombreDia => $ejercicios){ ?>

<div class="dia-card">

<h3>

📅 <?php echo $nombreDia; ?>

</h3>

<ul>

<?php foreach($ejercicios as $ejercicio){ ?>

<li>

<?php echo $ejercicio; ?>

</li>

<?php } ?>

</ul>

</div>

<?php } ?>





</div>

</div>

</body>

</html>