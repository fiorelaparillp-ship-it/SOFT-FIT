<?php
ob_start();

/** @var mysqli $conexion */
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");

/* TOTAL CLIENTES */

$totalClientesDashboard = mysqli_num_rows(
    mysqli_query($conexion,
    "SELECT * FROM clientes")
);

/* MEMBRESÍAS ACTIVAS */

$membresiasActivas = mysqli_num_rows(
    mysqli_query($conexion,
    "SELECT * FROM membresias
     WHERE estado='Activa'")
);

/* MEMBRESÍAS VENCIDAS */

$membresiasVencidas = mysqli_num_rows(
    mysqli_query($conexion,
    "SELECT * FROM membresias
     WHERE estado='Vencida'")
);

/* ASISTENCIAS DE HOY */

$asistenciasHoy = mysqli_num_rows(
    mysqli_query($conexion,
    "SELECT * FROM asistencias
     WHERE DATE(fecha) = CURDATE()")
);
/* INGRESOS DE HOY */

$ingresosHoy = mysqli_query($conexion,

"SELECT SUM(total) AS total
FROM ventas
WHERE DATE(fecha) = CURDATE()");

$datosIngresosHoy = mysqli_fetch_assoc($ingresosHoy);

$totalIngresosHoy = $datosIngresosHoy['total'] ?? 0;

if($totalIngresosHoy==""){

    $totalIngresosHoy = 0;

}


/* CLIENTE CON MÁS ASISTENCIAS */

$topCliente = mysqli_query($conexion,

"SELECT clientes.nombre,
COUNT(asistencias.id) AS total

FROM asistencias

INNER JOIN clientes
ON asistencias.cliente_id = clientes.id

GROUP BY clientes.id

ORDER BY total DESC

LIMIT 1");

$clienteTop = mysqli_fetch_assoc($topCliente);

/* TOTAL CLIENTES */

$clientes = mysqli_query($conexion,
"SELECT COUNT(*) AS total FROM clientes");

$totalClientes = mysqli_fetch_assoc($clientes);

/* TOTAL PRODUCTOS */

$productos = mysqli_query($conexion,
"SELECT COUNT(*) AS total FROM productos");

$totalProductos = mysqli_fetch_assoc($productos);

/* TOTAL VENTAS */

$ventas = mysqli_query($conexion,
"SELECT SUM(total) AS total FROM ventas");

$totalVentas = mysqli_fetch_assoc($ventas);

/* PRODUCTOS BAJO STOCK */

$bajoStock = mysqli_query($conexion,
"SELECT COUNT(*) AS total
FROM productos
WHERE stock <= 5");

$totalBajo = mysqli_fetch_assoc($bajoStock);

/* METODOS DE PAGO */

$efectivo = mysqli_query($conexion,
"SELECT COUNT(*) AS total
FROM ventas
WHERE metodo_pago='Efectivo'");

$yape = mysqli_query($conexion,
"SELECT COUNT(*) AS total
FROM ventas
WHERE metodo_pago='Yape'");

$tarjeta = mysqli_query($conexion,
"SELECT COUNT(*) AS total
FROM ventas
WHERE metodo_pago='Tarjeta'");

$totalEfectivo = mysqli_fetch_assoc($efectivo);

$totalYape = mysqli_fetch_assoc($yape);

$totalTarjeta = mysqli_fetch_assoc($tarjeta);


/* MEMBRESÍAS POR VENCER */

$porVencer = mysqli_query($conexion,

"SELECT clientes.nombre,
membresias.fecha_fin

FROM membresias

INNER JOIN clientes
ON membresias.cliente_id = clientes.id

WHERE membresias.estado='Activa'

ORDER BY membresias.fecha_fin ASC

LIMIT 5");

/* ASISTENCIAS POR DÍA */

$grafAsis = mysqli_query($conexion,

"SELECT fecha,
COUNT(*) AS total

FROM asistencias

GROUP BY fecha

ORDER BY fecha ASC

LIMIT 7");
$fechas = [];
$totales = [];

while($fila = mysqli_fetch_assoc($grafAsis)){

    $fechas[] = $fila['fecha'];
    $totales[] = $fila['total'];

}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Dashboard</title>

<link rel="stylesheet" href="../css/style.css?v=1">




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<!-- SIDEBAR -->

<?php include("../includes/sidebar.php"); ?>


<!-- MAIN -->
<div class="main">

   

<div class="dashboard-header">

<div>

<h1>

Bienvenido de vuelta,
<?php echo $_SESSION['nombre']; ?> 

</h1>

<p>

Aquí tienes un resumen general del gimnasio

</p>

</div>

<div class="header-date">

<?php echo date("d/m/Y"); ?>

</div>

</div>
<div class="top-search">

<input
type="text"
placeholder="Buscar clientes, ventas, productos...">

</div>
<div class="gym-banner">

<div class="banner-content">

<h2>

NO PAIN
NO GAIN

</h2>

<p>

Gestiona tu gimnasio como un profesional

</p>

</div>

</div>


   <div class="kpi-grid">

<div class="card kpi-card clientes">

<div class="kpi-icon clientes-icon">
<i class="fa-solid fa-users"></i>
</div>

<div class="kpi-info">
    
<h3>Clientes</h3>
<p><?php echo $totalClientesDashboard; ?></p>
</div>

</div>

<div class="card kpi-card activas">

<div class="kpi-icon activas-icon">
<i class="fa-solid fa-dumbbell"></i>
</div>

<div class="kpi-info">
<h3>Activas</h3>
<p><?php echo $membresiasActivas; ?></p>
</div>

</div>

<div class="card kpi-card hoy">

<div class="kpi-icon hoy-icon">
<i class="fa-solid fa-calendar-check"></i>
</div>

<div class="kpi-info">
<h3>Hoy</h3>
<p><?php echo $asistenciasHoy; ?></p>
</div>

</div>

<div class="card kpi-card ingresos">

<div class="kpi-icon ingresos-icon">
<i class="fa-solid fa-sack-dollar"></i>
</div>

<div class="kpi-info">
<h3>Ingresos</h3>
<p>S/ <?php echo number_format($totalIngresosHoy,2); ?></p>
</div>

</div>



</div>
<div class="charts-grid">

    <div class="card chart-card">
        <h2>📊 Métodos de Pago</h2>
        <canvas id="graficoPagos"></canvas>
    </div>

    <div class="card chart-card">
        <h2>📈 Asistencias por Día</h2>
        <canvas id="graficoAsistencias"></canvas>
    </div>

</div>

<div class="dashboard-grid">
<div class="dashboard-info">

<div class="card vencimientos-card">

<h2>📅 Próximas Membresías por Vencer</h2>

<div class="vencimientos-list">

<?php while($vencer = mysqli_fetch_assoc($porVencer)){ ?>

<div class="vencimiento-item">

<div>
<h4><?php echo $vencer['nombre']; ?></h4>

<small>
Vence:
<?php echo date("d/m/Y", strtotime($vencer['fecha_fin'])); ?>
</small>

</div>

<div class="badge-vencer">
⏳
</div>

</div>

<?php } ?>

</div>

</div>

</div>





<div class="ventas-section">
    <div class="bottom-grid">

<div class="card ventas-card">

<div class="card-header">

<h2>🧾 Últimas Ventas</h2>

<a href="ventas.php" class="btn-ver">
Ver todas
</a>

</div>

<table class="tabla-premium">

        <tr>

            <th>ID</th>
<th>Cliente</th>
<th>Total</th>
<th>Método</th>
<th>Fecha</th>

        </tr>

        <?php

        $ventas = mysqli_query($conexion,

"SELECT

ventas.*,
clientes.nombre

FROM ventas

LEFT JOIN clientes
ON ventas.cliente_id = clientes.id

ORDER BY ventas.id DESC

LIMIT 5");

        while($venta = mysqli_fetch_assoc($ventas)){

        ?>

        <tr>

           <td>
<?php echo $venta['id']; ?>
</td>

<td>
<?php

if($venta['nombre']==""){

    echo "Sin cliente";

}else{

    echo $venta['nombre'];

}

?>
</td>

<td>

<strong>

S/ <?php echo number_format($venta['total'],2); ?>

</strong>

</td>

            <td>

                <?php echo $venta['metodo_pago']; ?>

            </td>

            <td>

                <?php echo $venta['fecha']; ?>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>


<!-- PRODUCTOS BAJO STOCK -->

<div class="card stock-card">

<div class="card-header">

<h2>⚠ Productos con Bajo Stock</h2>

</div>

<table class="tabla-premium">

<tr>

    <th>Producto</th>
    <th>Stock</th>

</tr>

<?php

$consultaStock = mysqli_query($conexion,
"SELECT * FROM productos
WHERE stock <= 5");

while($p = mysqli_fetch_assoc($consultaStock)){

?>

<tr>

    <td><?php echo $p['nombre']; ?></td>

   <td>

<span class="stock-badge">

<?php echo $p['stock']; ?>

</span>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>








</div>

</div>


<script>

</script>


<script>

new Chart(document.getElementById('graficoPagos'), {

type:'doughnut',

data:{

labels:['Efectivo','Yape','Tarjeta'],

datasets:[{

data:[

<?php echo $totalEfectivo['total']; ?>,

<?php echo $totalYape['total']; ?>,

<?php echo $totalTarjeta['total']; ?>

],

backgroundColor:[

'#8b5cf6',
'#06b6d4',
'#f59e0b'

],

borderWidth:0

}]

},

options:{

plugins:{

legend:{

position:'bottom',

labels:{

color:'white'

}

}

}

}

});

</script>
<script>

new Chart(document.getElementById('graficoAsistencias'), {

type:'line',

data:{

labels:<?php echo json_encode($fechas); ?>,

datasets:[{

label:'Asistencias',

data:<?php echo json_encode($totales); ?>,

borderColor:'#8b5cf6',

backgroundColor:'rgba(139,92,246,.15)',

fill:true,

tension:.4,

borderWidth:4

}]

},

options:{

plugins:{

legend:{

labels:{

color:'white'

}

}

},

scales:{

x:{

ticks:{color:'white'}

},

y:{

ticks:{color:'white'}

}

}

}

});




</script>

</body>

</html>