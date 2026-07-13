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
$nombreCliente = $datosCliente['nombre'];
$correoCliente = $datosCliente['correo'];
$telefonoCliente = $datosCliente['telefono'];
/* PROGRESO DEL CLIENTE */

$progreso = mysqli_query($conexion,

"SELECT * FROM progreso_cliente

WHERE cliente_id='$idCliente'

ORDER BY id DESC

LIMIT 1");

$datosProgreso = mysqli_fetch_assoc($progreso);

$peso = $datosProgreso['peso'] ?? 0;
$altura = $datosProgreso['altura'] ?? 0;
$imc = $datosProgreso['imc'] ?? 0;
if($imc < 18.5){

$estadoIMC = "🔵 Bajo peso";

}
elseif($imc < 25){

$estadoIMC = "🟢 Peso normal";

}
elseif($imc < 30){

$estadoIMC = "🟡 Sobrepeso";

}
else{

$estadoIMC = "🔴 Obesidad";

}
$objetivo = $datosProgreso['objetivo'] ?? 'Sin objetivo';

$rutina = mysqli_query($conexion,

"SELECT * FROM rutinas
WHERE cliente_id='$idCliente'

ORDER BY id DESC

LIMIT 1");

$datosRutina = mysqli_fetch_assoc($rutina);

/* DATOS CLIENTE */
$cliente = mysqli_query($conexion,

"SELECT * FROM clientes
WHERE LOWER(nombre)=LOWER('$usuario')");

$datosCliente = mysqli_fetch_assoc($cliente);



$idCliente = $datosCliente['id'];
/* MEMBRESÍA */

$mem = mysqli_query($conexion,

"SELECT * FROM membresias
WHERE cliente_id='$idCliente'

ORDER BY id DESC LIMIT 1");



$datosMem = mysqli_fetch_assoc($mem);



/* ASISTENCIAS */

$asis = mysqli_query($conexion,

"SELECT * FROM asistencias
WHERE cliente_id='$idCliente'");

$totalAsis = mysqli_num_rows($asis);

/* TOTAL GASTADO */

$consultaCompras = mysqli_query($conexion,

"SELECT SUM(total) AS total_gastado

FROM ventas

WHERE cliente_id='$idCliente'");

$datosCompras = mysqli_fetch_assoc($consultaCompras);

$totalGastado = $datosCompras['total_gastado'];

if($totalGastado==""){

    $totalGastado = 0;

}
/* CANTIDAD DE COMPRAS */

$consultaCantidad = mysqli_query($conexion,

"SELECT COUNT(*) AS total_compras

FROM ventas

WHERE cliente_id='$idCliente'");

$datosCantidad = mysqli_fetch_assoc($consultaCantidad);

$totalCompras = $datosCantidad['total_compras'];

/* DÍAS RESTANTES */

$dias = 0;

if($datosMem){

$fin = strtotime($datosMem['fecha_fin']);

$hoy = strtotime(date("Y-m-d"));

$dias = ($fin - $hoy) / 86400;

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Panel Cliente</title>

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

<div class="dashboard-header">

<div>

<h1>

👋 Hola, <?php echo $usuario; ?>

</h1>

<p>

Bienvenido a SOFT-FIT

</p>

</div>

<div class="fecha-dashboard">

<?php echo date("d/m/Y"); ?>

</div>

</div>

<br><br>

<div class="dashboard-grid">

    <div class="left-panel">

       <div class="card membresia-card">
            <div class="card-icon">
🏋️
</div>

<h3>Mi Membresía</h3>

            <div class="estado-badge">

<?php echo strtoupper($datosMem['estado']); ?>

</div>

            <p>
                Vence:
                <?php echo date("d/m/Y", strtotime($datosMem['fecha_fin'])); ?>
            </p>

            <p>
                ⏳ <?php echo intval($dias); ?> días restantes
            </p>
            <div class="progress">
<div class="progress-fill"></div>
</div>

        </div>

        <div class="card asistencia-card">

<h3>📅 Mis Asistencias</h3>

<canvas
id="graficaAsistencias"
width="170"
height="170">
</canvas>

<p>

<?php echo $totalAsis; ?>

asistencias

</p>

</div>

        <div class="card compra-card"
onclick="location.href='mis_compras.php'"
style="cursor:pointer;">

<h3>🛒 Resumen de Compras</h3>

<h1>
S/ <?php echo number_format($totalGastado,2); ?>
</h1>

<small>
<?php echo $totalCompras; ?>
compras realizadas
</small>

</div>
        <div class="card rutina">

            <h3>🏋️ Rutina Asignada</h3>

           <div class="rutina-badge">

💪 PLAN ACTUAL

</div>

<h2>
<?php echo $datosRutina['titulo']; ?>
</h2>

            <br>

            <a href="mi_rutina.php"
            class="btn-rutina">

            Ver rutina completa

            </a>

        </div>
        <div class="card progreso">

<h3>📈 Mi Progreso</h3>

<div class="stats">

<div class="stat-box">
<h2>⚖️</h2>
<h4>Peso</h4>
<p><?php echo $peso; ?> kg</p>
</div>
<div class="stat-box">

<h2>📏</h2>

<h4>Altura</h4>

<p><?php echo $altura; ?> m</p>

</div>

<div class="stat-box">
<h2>📊</h2>
<h4>IMC</h4>
<p><?php echo $imc; ?></p>
</div>

<div class="stat-box">

<h2>❤️</h2>

<h4>Estado</h4>

<p>

<?php echo $estadoIMC; ?>

</p>

</div>
<div class="stat-box">
<h2>🎯</h2>
<h4>Objetivo</h4>
<p><?php echo $objetivo; ?></p>
</div>
</div>

</div>

    </div>

    <div class="right-panel">

        <div class="card perfil">

            <h3>👤 Mi Perfil</h3>

            <div class="avatar">
<?php echo strtoupper(substr($nombreCliente,0,1)); ?>
</div>
            <br>

            <strong>
                <?php echo $nombreCliente; ?>
            </strong>

            <br><br>

            <?php echo $correoCliente; ?>

            <br><br>

            <?php echo $telefonoCliente; ?>

        </div>

        <div class="card estado">

            <h3>📌 Estado de Cuenta</h3>

            <p>✅ Membresía activa</p>

            <p>
                ⏳ <?php echo intval($dias); ?>
                días restantes
            </p>

            <p>
                🛒 <?php echo $totalCompras; ?>
                compras realizadas
            </p>

        </div>

    </div>
<div class="card progreso-destacado">

<h2>

🎯 Tu objetivo fitness

</h2>

<p>

Sigue entrenando para alcanzar tus metas.

</p>

<a href="mi_progreso.php"
class="btn-progreso">

Ver progreso

</a>

</div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('graficaAsistencias');

new Chart(ctx, {

type: 'doughnut',

data: {

labels: ['Asistencias','Faltantes'],

datasets: [{

data: [<?php echo $totalAsis; ?>, 20-<?php echo $totalAsis; ?>],

backgroundColor: [

'#7c3aed',
'#2a2a3d'

],

borderWidth:0

}]

},

options: {

plugins: {

legend: {

display:false

}

}

}

});

</script>

</body>

</body>

</html>