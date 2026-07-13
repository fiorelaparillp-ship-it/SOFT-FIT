<?php
/** @var mysqli $conexion */
include("../includes/conexion.php");

$sql = mysqli_query(
$conexion,
"
SELECT
movimientos_inventario.*,
productos.nombre AS producto
FROM movimientos_inventario
INNER JOIN productos
ON movimientos_inventario.producto_id = productos.id
ORDER BY fecha DESC
"
);
$entradas = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"
SELECT COALESCE(SUM(cantidad),0) total
FROM movimientos_inventario
WHERE tipo='entrada'
"
)
);

$salidas = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"
SELECT COALESCE(SUM(cantidad),0) total
FROM movimientos_inventario
WHERE tipo='salida'
"
)
);

$totalMovimientos = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"
SELECT COUNT(*) total
FROM movimientos_inventario
"
)
);

?>
<div style="
display:grid;
grid-template-columns:repeat(3,1fr);
gap:15px;
margin-bottom:20px;
">

<div style="
background:#111827;
padding:15px;
border-radius:12px;
text-align:center;
">

<h2 style="
color:#22c55e;
margin:0;
">

📥 <?php echo $entradas['total']; ?>

</h2>

<p style="margin-top:8px;">
Entradas
</p>

</div>

<div style="
background:#111827;
padding:15px;
border-radius:12px;
text-align:center;
">

<h2 style="
color:#ef4444;
margin:0;
">

📤 <?php echo $salidas['total']; ?>

</h2>

<p style="margin-top:8px;">
Salidas
</p>

</div>

<div style="
background:#111827;
padding:15px;
border-radius:12px;
text-align:center;
">

<h2 style="
color:#8b5cf6;
margin:0;
">

📦 <?php echo $totalMovimientos['total']; ?>

</h2>

<p style="margin-top:8px;">
Movimientos
</p>

</div>

</div>
<div style="

display:flex;
gap:10px;
margin-bottom:15px;
align-items:center;
flex-wrap:wrap;

">

<input
type="text"
id="buscarHistorial"
placeholder="🔍 Buscar producto"
style="
padding:8px;
border-radius:8px;
border:none;
width:250px;
">

<select
id="filtroTipo"
style="
padding:8px;
border-radius:8px;
border:none;
min-width:140px;
"
>

<option value="">Todos</option>
<option value="entrada">Entradas</option>
<option value="salida">Salidas</option>

</select>

<input
type="date"
id="fechaInicio"
style="
padding:8px;
border-radius:8px;
border:none;
">

<input
type="date"
id="fechaFin"
style="
padding:8px;
border-radius:8px;
border:none;
">

</div>
<table
id="tablaHistorial"
style="width:100%;">
<thead>

<tr>

<th>Fecha</th>
<th>Producto</th>
<th>Tipo</th>
<th>Cantidad</th>
<th>Stock</th>
<th>Observación</th>

</tr>

</thead>

<tbody>

<?php

while($row = mysqli_fetch_assoc($sql)){

?>

<tr

data-producto="<?php echo strtolower($row['producto']); ?>"

data-tipo="<?php echo trim(strtolower($row['tipo'])); ?>"

data-fecha="<?php echo date('Y-m-d', strtotime($row['fecha'])); ?>"

>

<td>

<?php echo $row['fecha']; ?>

</td>

<td>

<?php echo $row['producto']; ?>

</td>

<td>

<?php echo strtoupper($row['tipo']); ?>

</td>


<td>

<?php echo $row['cantidad']; ?>

</td>

<td>

<?php echo $row['stock_anterior']; ?>

→

<?php echo $row['stock_nuevo']; ?>

</td>

<td>

<?php echo $row['observacion']; ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>
