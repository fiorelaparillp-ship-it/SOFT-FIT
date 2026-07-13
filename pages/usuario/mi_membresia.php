<?php
/** @var mysqli $conexion */
session_start();

include("../../includes/conexion.php");

if($_SESSION['rol']!="Cliente"){

    header("Location: ../dashboard.php");

}

$usuario = $_SESSION['usuario'];

$cliente = mysqli_query($conexion,

"SELECT * FROM clientes
WHERE LOWER(nombre)=LOWER('$usuario')");

$datosCliente = mysqli_fetch_assoc($cliente);

$idCliente = $datosCliente['id'];

$membresia = mysqli_query($conexion,

"SELECT membresias.*,

planes_membresia.plan

FROM membresias

INNER JOIN planes_membresia

ON membresias.plan_id = planes_membresia.id

WHERE membresias.cliente_id='$idCliente'

ORDER BY membresias.id DESC

LIMIT 1");
$datos = mysqli_fetch_assoc($membresia);

$dias = 0;
$porcentaje = 0;

if($datos){

    $inicio = strtotime($datos['fecha_inicio']);
    $fin = strtotime($datos['fecha_fin']);
    $hoy = time();

    $dias = floor(($fin - $hoy) / 86400);

    $totalDias = ($fin - $inicio) / 86400;
    $diasConsumidos = ($hoy - $inicio) / 86400;

    $porcentaje = ($diasConsumidos / $totalDias) * 100;

    if($porcentaje > 100){
        $porcentaje = 100;
    }

    if($porcentaje < 0){
        $porcentaje = 0;
    }

}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Mi Membresía</title>

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

<h1>🏋️ Mi Membresía</h1>

<br>

<?php if($datos){ ?>

<div class="card membresia-premium">

<h2>

🏆 <?php echo $datos['plan']; ?>

</h2>

<br>

<div class="estado-membresia">

<?php echo $datos['estado']; ?>

</div>

<br>

<p>

⏳ <?php echo $dias; ?> días restantes

</p>

<br>

<div class="barra-membresia">

<div
class="progreso-membresia"
style="width:<?php echo $porcentaje; ?>%;">

</div>

</div>

<br>

<p>

📅 Inicio:
<?php echo $datos['fecha_inicio']; ?>

</p>

<p>

📅 Fin:
<?php echo $datos['fecha_fin']; ?>

</p>

</div>

<?php }else ?>

</div>

</body>
</html>