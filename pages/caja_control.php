<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");
include("actualizar_reporte_diario.php");

if(!tienePermiso("membresias")){
    header("Location: dashboard.php");
    exit();
}

/* VERIFICAR CAJA ABIERTA */

$consultaCaja = "SELECT * FROM caja
                 WHERE estado='abierta'
                 LIMIT 1";

$resultadoCaja = mysqli_query($conexion,$consultaCaja);

$caja = mysqli_fetch_assoc($resultadoCaja);

/* HISTORIAL DE CAJAS */

$historialCaja = mysqli_query($conexion,"
SELECT
caja.*,
ua.nombre AS apertura,
uc.nombre AS cierre,
COALESCE(SUM(gastos_caja.monto),0) AS total_gastos
FROM caja

LEFT JOIN usuario ua
ON caja.usuario_apertura = ua.id

LEFT JOIN usuario uc
ON caja.usuario_cierre = uc.id

LEFT JOIN gastos_caja
ON gastos_caja.caja_id = caja.id

GROUP BY caja.id
ORDER BY caja.id DESC
");
/* HISTORIAL DE GASTOS */

$historialGastos = mysqli_query($conexion,"

SELECT

gastos_caja.*,

usuario.nombre AS usuario

FROM gastos_caja

INNER JOIN usuario

ON gastos_caja.usuario_id = usuario.id

ORDER BY gastos_caja.id DESC

");
/* RESUMEN DE MEMBRESÍAS */

$resumenMembresias = mysqli_query($conexion,"

SELECT

COUNT(membresias.id) AS cantidad,

COALESCE(SUM(planes_membresia.precio),0) AS total

FROM membresias

INNER JOIN planes_membresia
ON membresias.plan_id = planes_membresia.id

WHERE DATE(membresias.fecha_inicio)=CURDATE()

");

$membresias = mysqli_fetch_assoc($resumenMembresias);
/* CLIENTES DIARIOS */

$consultaClientesDiarios = mysqli_query($conexion,"

SELECT

COUNT(id) AS cantidad,

COALESCE(SUM(monto),0) AS total

FROM clases_diarias

WHERE DATE(fecha)=CURDATE()

");

$clientesDiarios = mysqli_fetch_assoc($consultaClientesDiarios);
/* RESUMEN DE VENTAS POR CATEGORÍA */

$resumenCategorias = mysqli_query($conexion, "

SELECT

categorias.id,

categorias.nombre,

SUM(detalle_ventas.cantidad) AS cantidad,

COALESCE(SUM(detalle_ventas.subtotal),0) AS total

FROM categorias

LEFT JOIN productos
ON categorias.id = productos.categoria_id

LEFT JOIN detalle_ventas
ON productos.id = detalle_ventas.producto_id

LEFT JOIN ventas
ON detalle_ventas.venta_id = ventas.id

AND ventas.estado='Completada'
WHERE DATE(fecha)=CURDATE()

GROUP BY categorias.id

ORDER BY categorias.id

");

/* TOTALES DE LA CAJA ABIERTA */

$totalVentasCaja = 0;
$totalGastosCaja = 0;
$totalEsperado = 0;

if($caja){

    // Total de ventas

    $ventas = mysqli_query($conexion,"
        SELECT COALESCE(SUM(total),0) AS total
        FROM ventas
        WHERE fecha BETWEEN '{$caja['fecha_apertura']}' AND NOW()
    ");

    $rowVentas = mysqli_fetch_assoc($ventas);

    $totalVentasCaja = $rowVentas['total'];

    // Total de gastos

    $gastos = mysqli_query($conexion,"
        SELECT COALESCE(SUM(monto),0) AS total
        FROM gastos_caja
        WHERE caja_id='{$caja['id']}'
    ");

    $rowGastos = mysqli_fetch_assoc($gastos);

    $totalGastosCaja = $rowGastos['total'];

    // Total esperado

    $totalEsperado =
        $caja['monto_inicial']
        + $totalVentasCaja
        - $totalGastosCaja;

}
/* ABRIR CAJA */

if(isset($_POST['abrir'])){

    $monto = $_POST['monto'];
$usuario = $_SESSION['id'];
   $abrir = "INSERT INTO caja(

usuario_id,
monto_inicial,
total_ventas,
ventas_turno,
total_final,
estado,
usuario_apertura

)

VALUES(

'$usuario',
'$monto',
0,
0,
'$monto',
'abierta',
'$usuario'

)";

    mysqli_query($conexion,$abrir);

    header("Location:caja_control.php");

}
/* REGISTRAR GASTO */

if(isset($_POST['registrarGasto'])){

    $idCaja = $_POST['idCaja'];

    $usuario = $_SESSION['id'];

    $concepto = mysqli_real_escape_string($conexion,$_POST['concepto']);

    $monto = $_POST['monto'];

    mysqli_query($conexion,"
    INSERT INTO gastos_caja
    (
        caja_id,
        usuario_id,
        concepto,
        monto
    )
    VALUES
    (
        '$idCaja',
        '$usuario',
        '$concepto',
        '$monto'
    )
    ");

    header("Location:caja_control.php");

    exit();

}
/* CERRAR CAJA */

if(isset($_POST['cerrar'])){
    
    $usuarioCierre = $_SESSION['id'];

    $idCaja = $_POST['idCaja'];

    $passwordIngresado = $_POST['passwordConfirmacion'];

$verificar = mysqli_query($conexion,"
SELECT *
FROM usuario
WHERE id='$usuarioCierre'
LIMIT 1
");

$usuarioBD = mysqli_fetch_assoc($verificar);

if(
    !$usuarioBD ||
    !password_verify($passwordIngresado, $usuarioBD['password'])
){

    header("Location: caja_control.php?error=credenciales");

    exit();

}
    /* DATOS CAJA */

    $datosCaja = "SELECT * FROM caja
                  WHERE id='$idCaja'";

    $resultadoDatos = mysqli_query($conexion,$datosCaja);

    $cajaDatos = mysqli_fetch_assoc($resultadoDatos);
   
/* VENTAS DEL TURNO */

$fechaApertura = $cajaDatos['fecha_apertura'];

$consultaVentas = mysqli_query($conexion,"
SELECT
COUNT(id) AS cantidad,
COALESCE(SUM(total),0) AS total
FROM ventas
WHERE fecha BETWEEN '$fechaApertura' AND NOW()
");
/* GASTOS DEL TURNO */

$consultaGastos = mysqli_query($conexion,"

SELECT

COALESCE(SUM(monto),0) AS total

FROM gastos_caja

WHERE caja_id='$idCaja'

");

$gastosTurno = mysqli_fetch_assoc($consultaGastos);

$totalGastos = $gastosTurno['total'];

$ventasTurno = mysqli_fetch_assoc($consultaVentas);

$totalVentas = $ventasTurno['total'];

$cantidadVentas = $ventasTurno['cantidad'];
    $montoInicial = $cajaDatos['monto_inicial'];

    $totalFinal = $montoInicial + $totalVentas - $totalGastos;

    /* ACTUALIZAR */

    $cerrar = "UPDATE caja

SET total_ventas='$totalVentas',
    ventas_turno='$cantidadVentas',
    total_final='$totalFinal',
    fecha_cierre=NOW(),
    estado='cerrada',
    usuario_cierre='$usuarioCierre'

WHERE id='$idCaja'";

  if(mysqli_query($conexion,$cerrar)){

    header("Location: caja_control.php?cerrada=1");
    exit();

}else{

    die(mysqli_error($conexion));

}
    header("Location:caja_control.php");

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Control Caja</title>

<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/softfit-ui.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

<div class="page-card">

<div class="page-header">

<div>

<h1>

<i class="fa-solid fa-cash-register"></i>

Control de Caja

</h1>

<p>

Administra la apertura y cierre de caja del turno.

</p>

</div>

</div>

<?php if(!$caja){ ?>

  <form method="POST" id="formCerrarCaja">
<h2 class="section-title">

<i class="fa-solid fa-lock-open"></i>

Aperturar Caja

</h2>

       <div class="form-group">

<label>

Monto Inicial

</label>

<input
type="number"
step="0.01"
name="monto"
placeholder="Ingrese el monto inicial"
required>

</div>

        <button
class="btn-primary"
name="abrir">

<i class="fa-solid fa-lock-open"></i>

Abrir Caja

</button>

    </form>

<?php }else{ ?>

<h2 class="section-title">

<i class="fa-solid fa-lock-open"></i>

Caja Abierta

</h2>

<div class="stats-grid">

    <div class="stat-card">

        <i class="fa-solid fa-user"></i>

        <h3>

        <?php echo $_SESSION['nombre']; ?>

        </h3>

        <span>Recepcionista</span>

    </div>

    <div class="stat-card">

        <i class="fa-solid fa-money-bill-wave"></i>

        <h3>

        S/ <?php echo number_format($caja['monto_inicial'],2); ?>

        </h3>

        <span>Monto Inicial</span>

    </div>

    <div class="stat-card">

        <i class="fa-solid fa-cart-shopping"></i>

        <h3>

        <?php echo $caja['ventas_turno']; ?>

        </h3>

        <span>Ventas del Turno</span>

    </div>

    <div class="stat-card">

        <i class="fa-solid fa-clock"></i>

        <h3>

        <?php echo date("H:i",strtotime($caja['fecha_apertura'])); ?>

        </h3>

        <span>Hora de Apertura</span>

    </div>

</div>
<br>

<div style="display:flex;justify-content:flex-end;gap:10px;">

<button
type="button"
style="
background:#7b2cbf;
color:white;
padding:12px 20px;
border:none;
border-radius:8px;
cursor:pointer;
font-size:15px;
font-weight:bold;"
id="btnRegistrarGasto">
<i class="fa-solid fa-receipt"></i>

Registrar gasto

</button>

</div>
<br>
<form method="POST" id="formGasto">

<input
type="hidden"
name="idCaja"
value="<?php echo $caja['id']; ?>">

<input
type="hidden"
name="concepto"
id="conceptoGasto">

<input
type="hidden"
name="monto"
id="montoGasto">

</form>
<form method="POST" id="formCerrarCaja">

<input
type="hidden"
name="idCaja"
value="<?php echo $caja['id']; ?>">



<input
type="hidden"
name="passwordConfirmacion"
id="passwordConfirmacion">
<button
type="submit"
class="btn-primary"
name="cerrar"
id="btnCerrarCaja">

<i class="fa-solid fa-lock"></i>

Cerrar Caja

</button>
</form>

</form>

<?php } ?>
<br>
<hr class="module-divider">

<div class="tabs-caja">

<button
type="button"
class="tab-btn active"
id="tabCaja">

<i class="fa-solid fa-cash-register"></i>

Historial Caja

</button>

<button
type="button"
class="tab-btn"
id="tabGastos">

<i class="fa-solid fa-receipt"></i>

Historial Gastos

</button>

<button
type="button"
class="tab-btn"
id="tabTotales">

<i class="fa-solid fa-chart-column"></i>

Totales

</button>

</div>

<div id="panelCaja" class="table-card">

<table class="modern-table">

<thead>
<tr>

<th style="width:110px;">Apertura</th>

<th style="width:110px;">Cierre</th>

<th style="width:100px;">Us. Aperturó</th>

<th style="width:120px;">Us. Cerró</th>

<th style="width:100px;">Monto Inicial</th>

<th style="width:60px;">Ventas</th>

<th style="width:120px;">Tot. Vendido</th>

<th style="width:100px;">Gastos</th>

<th style="width:120px;">Total Caja</th>

<th style="width:90px;">Estado</th>

</tr>
</thead>

<tbody>

<?php while($h=mysqli_fetch_assoc($historialCaja)){ ?>

<tr>

<td>

<?php
echo date("d/m/Y", strtotime($h['fecha_apertura']));
?>

<br>

<small style="color:#9ca3af;">

<?php
echo date("H:i", strtotime($h['fecha_apertura']));
?>

</small>

</td>
<td>

<?php

if($h['fecha_cierre']){

    echo date("d/m/Y", strtotime($h['fecha_cierre']));

    echo "<br>";

    echo "<small style='color:#9ca3af;'>";

    echo date("H:i", strtotime($h['fecha_cierre']));

    echo "</small>";

}else{

    echo "-";

}

?>

</td>

<td>
<?php echo $h['apertura']; ?>
</td>

<td>
<?php echo $h['cierre'] ?: "-"; ?>
</td>

<td>
S/ <?php echo number_format($h['monto_inicial'],2); ?>
</td>

<td>
<?php echo $h['ventas_turno']; ?>
</td>

<td>
S/ <?php echo number_format($h['total_ventas'],2); ?>
</td>
<td>
S/ <?php echo number_format($h['total_gastos'],2); ?>
</td>
<td>
S/ <?php echo number_format($h['total_final'],2); ?>
</td>

<td>

<span class="estado-badge <?php echo $h['estado']=="abierta" ? "activo":"inactivo"; ?>">

<?php echo ucfirst($h['estado']); ?>

</span>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>
<div
id="panelGastos"
class="table-card"
style="display:none;">

<h2 class="section-title">

<i class="fa-solid fa-receipt"></i>

Historial de Gastos

</h2>

<table class="modern-table">

<thead>

<tr>

<th>Fecha</th>
<th style="width:45%;">Concepto</th>
<th style="width:12%;text-align:center;">Monto</th>
<th style="width:18%;">Usuario</th>

</tr>

</thead>

<tbody>

<?php while($g = mysqli_fetch_assoc($historialGastos)){ ?>

<tr>

<td>

<?php
echo date("d/m/Y", strtotime($g['fecha']));
?>

<br>

<small style="color:#9ca3af;">

<?php
echo date("H:i", strtotime($g['fecha']));
?>

</small>

</td>

<td>

<?php echo $g['concepto']; ?>

</td>

<td style="text-align:center;">

<strong>

S/ <?php echo number_format($g['monto'],2); ?>

</strong>

</td>

<td>

<?php echo $g['usuario']; ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<div
id="panelTotales"
class="table-card"
style="display:none;">

<h2 class="section-title">

<i class="fa-solid fa-chart-column"></i>

Resumen de Ventas

</h2>

<table class="modern-table">

<thead>

<tr>

<th>Tipo</th>
<th>Cantidad</th>
<th>Ingreso Total</th>
<th>Usuario</th>

</tr>

</thead>
<tbody>

<tr>

    <td>Membresías</td>

    <td style="text-align:center;">
        <?php echo $membresias['cantidad']; ?>
    </td>

    <td>
        S/ <?php echo number_format($membresias['total'],2); ?>
    </td>

    <td>-</td>

</tr>

<tr>

    <td>Clientes diarios</td>

    <td style="text-align:center;">
        <?php echo $clientesDiarios['cantidad']; ?>
    </td>

    <td>
        S/ <?php echo number_format($clientesDiarios['total'],2); ?>
    </td>

    <td>-</td>

</tr>

<?php

$totalCantidad = $membresias['cantidad'];
$totalIngreso  = $membresias['total'];

while($categoria=mysqli_fetch_assoc($resumenCategorias)){

    $totalCantidad += $categoria['cantidad'];
    $totalIngreso  += $categoria['total'];

?>

<tr>

    <td><?php echo $categoria['nombre']; ?></td>

    <td style="text-align:center;">
        <?php echo $categoria['cantidad']; ?>
    </td>

    <td>
        S/ <?php echo number_format($categoria['total'],2); ?>
    </td>

    <td>-</td>

</tr>

<?php } ?>

<tr style="font-weight:bold;background:#f5f5f5;">

    <td>TOTAL GENERAL</td>

    <td style="text-align:center;">
        <?php echo $totalCantidad; ?>
    </td>

    <td>
        S/ <?php echo number_format($totalIngreso,2); ?>
    </td>

    <td>-</td>

</tr>

</tbody>

</table>

</div>


</div>
<br>


</div>

</div>
<!-- MODAL NUEVO GASTO -->

<div id="modalGasto" class="modal-gasto">

    <div class="modal-gasto-contenido">

       <div class="modal-header">

    <div>

        <h2>
            <i class="fa-solid fa-wallet"></i>
            Registrar gasto
        </h2>

        <small>
            Registra los gastos realizados durante el turno.
        </small>

    </div>

    <span id="cerrarModal" class="cerrar-modal">
        &times;
    </span>

</div>

        <div class="modal-body">

<div class="gasto-grid">

<div class="input-icon">

<label>Tipo de gasto</label>

<i class="fa-solid fa-tags"></i>

<select id="tipoGasto">

<option value="">Seleccione</option>

<option>Agua</option>

<option>Bebidas</option>

<option>Proteínas</option>

<option>Suplementos</option>

<option>Limpieza</option>

<option>Mantenimiento</option>

<option>Otros</option>

</select>

</div>

<div class="input-icon">

<label>Monto</label>

<i class="fa-solid fa-dollar-sign"></i>

<input
id="montoGastoModal"
type="number"
step="0.01"
placeholder="0.00">

</div>

</div>

<div class="input-icon">

<label>Descripción</label>

<i class="fa-solid fa-align-left"></i>

<textarea
id="descripcionGasto"
rows="4"
placeholder="Describe el gasto realizado..."></textarea>

</div>
<div class="modal-footer">

<button
type="button"
class="btn-cancelar"
id="cerrarModal2">

Cancelar

</button>

<button
type="button"
class="btn-guardar"
id="guardarGasto">

Guardar gasto

</button>

</div>

</div>

    </div>

</div>
<script>

//==============================
// BOTÓN CERRAR CAJA
//==============================

const btnCerrar = document.getElementById("btnCerrarCaja");

if(btnCerrar){

btnCerrar.addEventListener("click",function(e){

e.preventDefault();

Swal.fire({

title:"Cerrar Caja",

icon:"warning",

background:"#1f2937",

color:"#fff",

showCancelButton:true,

confirmButtonColor:"#7b2cbf",

confirmButtonText:"Cerrar Caja",

cancelButtonText:"Cancelar",

html:`

<div style="margin-bottom:15px;color:#9ca3af">
Confirma tu contraseña para cerrar la caja.
</div>

<input
id="swalPassword"
type="password"
class="swal2-input"
placeholder="Contraseña">

`,

preConfirm:()=>{

const password=document.getElementById("swalPassword").value;

if(password==""){

Swal.showValidationMessage("Ingrese la contraseña");

return false;

}

return{
password
};

}

}).then((result)=>{

if(result.isConfirmed){

document.getElementById("passwordConfirmacion").value=result.value.password;

let cerrar=document.createElement("input");

cerrar.type="hidden";

cerrar.name="cerrar";

cerrar.value="1";

document.getElementById("formCerrarCaja").appendChild(cerrar);

document.getElementById("formCerrarCaja").submit();

}

});

});

}



//======================
// MODAL GASTOS
//======================

const modal=document.getElementById("modalGasto");

const abrir=document.getElementById("btnRegistrarGasto");

const cerrar=document.getElementById("cerrarModal");
const cerrar2=document.getElementById("cerrarModal2");

if(cerrar2){

cerrar2.onclick=function(){

modal.style.display="none";

}

}
if(abrir){

abrir.onclick=function(){

modal.style.display="flex";

}

}

if(cerrar){

cerrar.onclick=function(){

modal.style.display="none";

}

}
//==============================
// GUARDAR GASTO
//==============================

const btnGuardarGasto = document.getElementById("guardarGasto");

if(btnGuardarGasto){

btnGuardarGasto.onclick=function(){

const tipo = document.getElementById("tipoGasto").value;

const descripcion = document.getElementById("descripcionGasto").value;

const monto = document.getElementById("montoGastoModal").value;

if(tipo=="" || monto==""){

Swal.fire({

icon:"warning",

title:"Complete los datos",

text:"Debe seleccionar un tipo de gasto e ingresar el monto."

});

return;

}

// Concepto completo
document.getElementById("conceptoGasto").value =
tipo + " - " + descripcion;

document.getElementById("montoGasto").value =
monto;

// Crear input oculto

let gasto=document.createElement("input");

gasto.type="hidden";

gasto.name="registrarGasto";

gasto.value="1";

document.getElementById("formGasto").appendChild(gasto);

// Enviar formulario

document.getElementById("formGasto").submit();

};

}

//==============================
// PESTAÑAS CONTROL DE CAJA
//==============================

const tabCaja = document.getElementById("tabCaja");
const tabGastos = document.getElementById("tabGastos");
const tabTotales = document.getElementById("tabTotales");

const panelCaja = document.getElementById("panelCaja");
const panelGastos = document.getElementById("panelGastos");
const panelTotales = document.getElementById("panelTotales");

function activarTab(tab, panel){

    panelCaja.style.display = "none";
    panelGastos.style.display = "none";
    panelTotales.style.display = "none";

    tabCaja.classList.remove("active");
    tabGastos.classList.remove("active");
    tabTotales.classList.remove("active");

    panel.style.display = "block";
    tab.classList.add("active");

}

tabCaja.onclick = function(){

    activarTab(tabCaja, panelCaja);

}

tabGastos.onclick = function(){

    activarTab(tabGastos, panelGastos);

}

tabTotales.onclick = function(){

    activarTab(tabTotales, panelTotales);

}
//==============================
// SUBPESTAÑAS TOTALES
//==============================

const btnResumen = document.getElementById("btnResumen");
const btnTipoGasto = document.getElementById("btnTipoGasto");

const panelResumenTotal = document.getElementById("panelResumenTotal");
const panelTipoGasto = document.getElementById("panelTipoGasto");

if(btnResumen){

    btnResumen.addEventListener("click",function(){

        panelResumenTotal.style.display="block";
        panelTipoGasto.style.display="none";

        btnResumen.classList.add("active");
        btnTipoGasto.classList.remove("active");

    });

}

if(btnTipoGasto){

    btnTipoGasto.addEventListener("click",function(){

        panelResumenTotal.style.display="none";
        panelTipoGasto.style.display="block";

        btnTipoGasto.classList.add("active");
        btnResumen.classList.remove("active");

    });

}
</script>


<?php  ?>
</body>

</html>