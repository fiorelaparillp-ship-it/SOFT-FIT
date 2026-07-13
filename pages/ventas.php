<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("ventas")){
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>

<html lang="es">

<head>
    

<meta charset="UTF-8">

<title>Ventas</title>

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

<i class="fa-solid fa-receipt"></i>

Historial de Ventas

</h1>

<p>

Consulta todas las ventas realizadas en SOFT-FIT.

</p>

</div>

</div>

<?php

$consultaTotales = mysqli_query(
$conexion,

"SELECT
COUNT(*) AS ventas,
SUM(total) AS total
FROM ventas"
);

$datos = mysqli_fetch_assoc($consultaTotales);

$totalVentas = $datos['ventas'];

$totalVendido = $datos['total'];

$clientesAtendidos = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"
SELECT COUNT(DISTINCT cliente_id) AS total
FROM ventas
WHERE cliente_id IS NOT NULL
"
)
);
?>

<form method="GET" class="ventas-filtros">


<input
type="text"
name="cliente"
placeholder="Buscar cliente"
value="<?php echo isset($_GET['cliente']) ? $_GET['cliente'] : ''; ?>">

<input
type="date"
name="desde"
value="<?php echo isset($_GET['desde']) ? $_GET['desde'] : ''; ?>">

<input
type="date"
name="hasta"
value="<?php echo isset($_GET['hasta']) ? $_GET['hasta'] : ''; ?>">

<button
type="submit"
class="btn-primary">

<i class="fa-solid fa-magnifying-glass"></i>

Buscar

</button>

</form>
<br>

<div class="stats-grid">

<div class="stat-card">

<i class="fa-solid fa-receipt"></i>

<h3><?php echo $totalVentas; ?></h3>

<span>Total Ventas</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-sack-dollar"></i>

<h3>

S/ <?php echo number_format($totalVendido,2); ?>

</h3>

<span>Total Vendido</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-chart-line"></i>

<h3>

S/
<?php

if($totalVentas>0){

echo number_format($totalVendido/$totalVentas,2);

}else{

echo "0.00";

}

?>

</h3>

<span>Ticket Promedio</span>

</div>
<div class="stat-card">

<i class="fa-solid fa-users"></i>

<h3>

<?php echo $clientesAtendidos['total']; ?>

</h3>

<span>Clientes Atendidos</span>

</div>
</div>

<br>


<?php

$cliente = "";
$desde = "";
$hasta = "";

if(isset($_GET['cliente'])){
    $cliente = $_GET['cliente'];
}

if(isset($_GET['desde'])){
    $desde = $_GET['desde'];
}

if(isset($_GET['hasta'])){
    $hasta = $_GET['hasta'];
}

/* CONSULTA PRINCIPAL */

$sql = "

SELECT

ventas.*,
clientes.nombre

FROM ventas

LEFT JOIN clientes
ON ventas.cliente_id = clientes.id

WHERE 1=1

";

if($cliente!=""){
    $sql .= " AND clientes.nombre LIKE '%$cliente%' ";
}

if($desde!=""){
    $sql .= " AND DATE(ventas.fecha) >= '$desde' ";
}

if($hasta!=""){
    $sql .= " AND DATE(ventas.fecha) <= '$hasta' ";
}

$sql .= " ORDER BY ventas.id DESC ";

$consulta = mysqli_query($conexion,$sql);

/* TOTALES */


?>
<div class="table-card">

<table>

<tr>

<th>ID</th>
<th>Cliente</th>
<th>Total</th>
<th>Método</th>
<th>Estado</th>
<th>Fecha</th>
<th>Acciones</th>

</tr>

<?php

while($v = mysqli_fetch_assoc($consulta)){

?>

<tr>

<td>

<?php echo $v['id']; ?>

</td>

<td>

<?php

if($v['nombre']==""){

    echo "Cliente Varios";

}else{

    echo $v['nombre'];

}

?>

</td>

<td>

S/ <?php echo $v['total']; ?>

</td>

<td>

<?php echo $v['metodo_pago']; ?>

</td>

<td>

<?php echo $v['estado']; ?>

</td>

<td>

<?php echo $v['fecha']; ?>

</td>

<td>

<div class="acciones-venta">
    <a
href="#"
class="btn-ver"
data-id="<?php echo $v['id']; ?>">

<i class="fa-solid fa-eye"></i>



</a>
<a
href="ticket.php?id=<?php echo $v['id']; ?>"
class="btn-ticket-lista"
target="_blank">

<i class="fa-solid fa-receipt"></i>



</a>

<?php if($v['estado']=="Completada"){ ?>

<a
href="#"
class="btn-anular-lista"
data-id="<?php echo $v['id']; ?>">

<i class="fa-solid fa-ban"></i>


</a>

<?php }else{ ?>

<span class="badge-anulada">

<i class="fa-solid fa-circle-xmark"></i>



</span>

<?php } ?>
</div>
</td>
</tr>

<?php } ?>



<br><br>
</table>

</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

document.querySelectorAll(".btn-anular-lista").forEach(btn=>{

    btn.addEventListener("click",function(e){

        e.preventDefault();

        let id = this.dataset.id;

        Swal.fire({

            title:"¿Anular venta?",

            html:"Esta acción devolverá automáticamente el <b>stock</b> al inventario.<br><br>Esta acción no se puede deshacer.",

            icon:"warning",

            showCancelButton:true,

            confirmButtonText:"Sí, anular",

            cancelButtonText:"Cancelar",

            confirmButtonColor:"#ef4444",

            cancelButtonColor:"#6b7280"

        }).then((result)=>{

            if(result.isConfirmed){

                window.location =
                "anular_venta.php?id="+id;

            }

        });

    });

});

</script>
<script>

const params = new URLSearchParams(window.location.search);

if(params.get("anulada") == "1"){

    Swal.fire({

        toast:true,

        position:"bottom-end",

        icon:"success",

        title:"Venta anulada correctamente",

        background:"#1f2937",

        color:"#fff",

        showConfirmButton:false,

        timer:2500,

        timerProgressBar:true

    });

}

</script>
<script>

document.querySelectorAll(".btn-ver").forEach(btn=>{

    btn.addEventListener("click",function(e){

        e.preventDefault();

        let id = this.dataset.id;

        fetch("ver_detalle_venta.php?id="+id)

        .then(response => response.json())

        .then(data => {

            let productos = "";

            data.productos.forEach(p=>{

                productos += `

                <tr>

                    <td>${p.nombre}</td>

                    <td style="text-align:center;">
                        ${p.cantidad}
                    </td>

                    <td style="text-align:right;">
                        S/ ${parseFloat(p.subtotal).toFixed(2)}
                    </td>

                </tr>

                `;

            });

            Swal.fire({

                width:700,

                title:"🧾 Detalle de la Venta",

                html:`

                <div style="text-align:left;">

                    <p><b>Cliente:</b> ${data.venta.cliente ?? 'Sin cliente'}</p>

                    <p><b>Método:</b> ${data.venta.metodo_pago}</p>

                    <p><b>Fecha:</b> ${data.venta.fecha}</p>

                    <hr>

                    <table style="width:100%; border-collapse:collapse;">

                        <thead>

                            <tr>

                                <th align="left">Producto</th>

                                <th>Cant.</th>

                                <th align="right">Subtotal</th>

                            </tr>

                        </thead>

                        <tbody>

                            ${productos}

                        </tbody>

                    </table>

                    <hr>

                    <h2 style="text-align:right; color:#7b2cbf;">

                        Total: S/ ${parseFloat(data.venta.total).toFixed(2)}

                    </h2>

                </div>

                `,

                confirmButtonText:"Cerrar",

                confirmButtonColor:"#7b2cbf"

            });

        });

    });

});

</script>
</body>

</html>