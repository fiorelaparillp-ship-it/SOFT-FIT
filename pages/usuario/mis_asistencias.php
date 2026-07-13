<?php
/** @var mysqli $conexion */
session_start();

if($_SESSION['rol']!="Cliente"){

    header("Location: ../dashboard.php");

}
echo "Usuario: ".$_SESSION['usuario']."<br>";
echo "Rol: ".$_SESSION['rol']."<br>";

include("../../includes/conexion.php");

$usuario = $_SESSION['usuario'];

/* OBTENER CLIENTE */

$cliente = mysqli_query($conexion,

"SELECT * FROM clientes
WHERE LOWER(nombre)=LOWER('$usuario')");

$datosCliente = mysqli_fetch_assoc($cliente);

$idCliente = $datosCliente['id'];

/* ASISTENCIAS */

$asistencias = mysqli_query($conexion,

"SELECT *
FROM asistencias
WHERE cliente_id='$idCliente'
ORDER BY fecha DESC, hora DESC");

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Mis Asistencias</title>

<link rel="stylesheet"
href="../../css/style.css?v=1">

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

<h1>📅 Mis Asistencias</h1>

<br>

<table>

<tr>

<th>Fecha</th>
<th>Hora</th>

</tr>

<?php

while($a = mysqli_fetch_assoc($asistencias)){

?>

<tr>

<td>

<?php echo $a['fecha']; ?>

</td>

<td>

<?php echo $a['hora']; ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>