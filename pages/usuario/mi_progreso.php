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

/* HISTORIAL */

$historial = mysqli_query($conexion,

"SELECT *

FROM progreso_cliente

WHERE cliente_id='$idCliente'

ORDER BY fecha_registro DESC");

/* PRIMER REGISTRO */

$primerRegistro = mysqli_query($conexion,

"SELECT *

FROM progreso_cliente

WHERE cliente_id='$idCliente'

ORDER BY fecha_registro ASC

LIMIT 1");

$primer = mysqli_fetch_assoc($primerRegistro);

/* ÚLTIMO REGISTRO */

$ultimoRegistro = mysqli_query($conexion,

"SELECT *

FROM progreso_cliente

WHERE cliente_id='$idCliente'

ORDER BY fecha_registro DESC

LIMIT 1");

$ultimo = mysqli_fetch_assoc($ultimoRegistro);

$pesoInicial = $primer['peso'] ?? 0;

$pesoActual = $ultimo['peso'] ?? 0;

$cambioPeso = $pesoActual - $pesoInicial;
$metaPeso = $ultimo['meta_peso'] ?? 0;
$avance = 0;

if($metaPeso > 0 && $pesoInicial != $metaPeso){

$avance =
(($pesoInicial - $pesoActual) /
($pesoInicial - $metaPeso)) * 100;

if($avance < 0){

$avance = 0;

}

if($avance > 100){

$avance = 100;

}

}


$fechas = [];
$pesos = [];

$grafica = mysqli_query($conexion,

"SELECT *

FROM progreso_cliente

WHERE cliente_id='$idCliente'

ORDER BY fecha_registro ASC");

while($g = mysqli_fetch_assoc($grafica)){

$fechas[] = date(
"m/Y",
strtotime($g['fecha_registro'])
);

$pesos[] = $g['peso'];

}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Mi Progreso</title>

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

<h1>📈 Mi Historial de Progreso</h1>
<div class="card">

<h2>📈 Resumen de Progreso</h2>

<br>

<p>

⚖️ Peso Inicial:
<b><?php echo $pesoInicial; ?> kg</b>

</p>

<br>

<p>

⚖️ Peso Actual:
<b><?php echo $pesoActual; ?> kg</b>

</p>

<br>

<p>

<?php

if($cambioPeso < 0){

echo "⬇️ Has perdido ".abs($cambioPeso)." kg";

}
elseif($cambioPeso > 0){

echo "⬆️ Has ganado ".$cambioPeso." kg";

}
else{

echo "➖ Sin cambios";

}

?>
<br>

<p>

🎯 Meta:
<b><?php echo $metaPeso; ?> kg</b>

</p>

<br>

<div class="barra-progreso">

<div class="progreso"

style="width:<?php echo intval($avance); ?>%;">

</div>

</div>

<p>

<?php echo intval($avance); ?>%
completado

</p>

</p>

</div>

<br><br>
<div class="card">

<h3>📊 Evolución del Peso</h3>

<canvas id="graficaPeso"></canvas>

</div>

<br><br>

<table>

<tr>

<th>Fecha</th>

<th>Peso</th>

<th>Altura</th>

<th>IMC</th>

<th>Objetivo</th>

</tr>

<?php

while($fila = mysqli_fetch_assoc($historial)){

?>

<tr>

<td>

<?php echo $fila['fecha_registro']; ?>

</td>

<td>

<?php echo $fila['peso']; ?> kg

</td>

<td>

<?php echo $fila['altura']; ?> m

</td>

<td>

<?php echo $fila['imc']; ?>

</td>

<td>

<?php echo $fila['objetivo']; ?>

</td>

</tr>

<?php

}

?>

</table>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx =
document.getElementById('graficaPeso');

new Chart(ctx, {

type:'line',

data:{

labels:

<?php echo json_encode($fechas); ?>,

datasets:[{

label:'Peso (kg)',

data:

<?php echo json_encode($pesos); ?>,

borderColor:'#7c3aed',

backgroundColor:'#7c3aed',

fill:false,

tension:.4

}]

},

options:{

responsive:true

}

});

</script>

</body>

</html>