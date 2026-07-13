<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("reportes")){
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reportes</title>

<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/softfit-ui.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

<div class="page-card">

<div class="page-header">

<div>

<h1>

<i class="fa-solid fa-chart-column"></i>

Centro de Reportes

</h1>

<p>

Genera reportes y exporta información del sistema SOFT-FIT.

</p>

</div>

</div>

<div class="report-grid">
   <div class="report-card">

<h2>

<i class="fa-solid fa-users"></i>

Clientes

</h2>

<p class="reporte-desc">

Genera un reporte completo de todos los clientes registrados.

</p>

<a href="reporte_clientes.php" target="_blank">

<button class="btn-reporte pdf">

<i class="fa-solid fa-file-pdf"></i>

Generar PDF

</button>

</a>

<br>


<a href="exportar_clientes.php">

<button class="btn-reporte csv">

<i class="fa-solid fa-file-csv"></i>

Exportar CSV

</button>
</a>


</div>
<div class="report-card">

<h2>

<i class="fa-solid fa-id-card"></i>

Membresías

</h2>
<p class="reporte-desc">

Consulta todas las membresías registradas en el sistema.

</p>


<a href="reporte_membresias.php" target="_blank">

<button class="btn-reporte pdf">

<i class="fa-solid fa-file-pdf"></i>

Generar PDF

</button>

</a>

</div>
<div class="report-card">

<h2>

<i class="fa-solid fa-cart-shopping"></i>

Ventas

</h2>
<p class="reporte-desc">

Obtén el historial completo de todas las ventas realizadas.

</p>


<a href="reporte_ventas.php" target="_blank">

<button class="btn-reporte pdf">

<i class="fa-solid fa-file-pdf"></i>

Generar PDF

</button>

</a>
<br>

<a href="exportar_ventas.php">

<button class="btn-reporte csv">

<i class="fa-solid fa-file-csv"></i>

Exportar CSV

</button>

</a>

</div>
<div class="report-card">

<h2>

<i class="fa-solid fa-calendar-days"></i>

Resumen Diario

</h2>

<p class="reporte-desc">

Consulta el historial diario de ventas, membresías, clientes diarios y productos vendidos.

</p>

<a href="reporte_resumen_diario.php" target="_blank">

<button class="btn-reporte pdf">

<i class="fa-solid fa-file-pdf"></i>

Generar PDF

</button>

</a>

<br>

<a href="exportar_resumen_diario.php">

<button class="btn-reporte csv">

<i class="fa-solid fa-file-csv"></i>

Exportar CSV

</button>

</a>

</div>
<div class="report-card">

<h2>

<i class="fa-solid fa-calendar-check"></i>

Asistencias

</h2>
<p class="reporte-desc">

Exporta el registro de asistencias de todos los clientes.

</p>


<a href="reporte_asistencias.php" target="_blank">

<button class="btn-reporte pdf">

<i class="fa-solid fa-file-pdf"></i>

Generar PDF

</button>

</a>
<br>
<a href="exportar_asistencias.php">

<button class="btn-reporte csv">

<i class="fa-solid fa-file-csv"></i>

Exportar CSV

</button>

</a>

</div>
<div class="report-card">

<h2>

<i class="fa-solid fa-chart-line"></i>

Ventas por Fecha

</h2>
<p class="reporte-desc">

Genera un reporte entre dos fechas específicas.

</p>


<form action="reporte_ventas_fecha.php" method="GET">

<label>Desde:</label>

<input type="date" name="inicio" required>

<br><br>

<label>Hasta:</label>

<input type="date" name="fin" required>



<button
class="btn-reporte pdf"
type="submit">

<i class="fa-solid fa-calendar-days"></i>

Generar PDF

</button>

</form>

</div>
<div class="report-card">

<h2>

<i class="fa-solid fa-user-check"></i>

Clientes Activos

</h2>
<p class="reporte-desc">

Lista únicamente los clientes con membresía vigente.

</p>


<a href="reporte_clientes_activos.php" target="_blank">

<button class="btn-reporte pdf">

<i class="fa-solid fa-file-pdf"></i>

Generar PDF

</button>

</a>

</div>
<div class="report-card">
<h2>

<i class="fa-solid fa-circle-xmark"></i>

Membresías Vencidas

</h2>
<p class="reporte-desc">

Consulta las membresías que ya expiraron.

</p>


<a href="reporte_membresias_vencidas.php" target="_blank">

<button class="btn-reporte pdf">

<i class="fa-solid fa-file-pdf"></i>

Generar PDF

</button>
</a>

</div>
</div>

</div>

</body>

</html>