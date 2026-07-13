<?php
/** @var mysqli $conexion */
include("../includes/conexion.php");

$id = $_GET['id'];

$sql = mysqli_query($conexion,"
SELECT *
FROM movimientos_inventario
WHERE producto_id='$id'
ORDER BY fecha DESC
");

$html = "

<table style='
width:100%;
border-collapse:collapse;
color:white;
'>

<thead>

<tr style='background:#374151;'>

<th style='padding:10px;'>Tipo</th>
<th style='padding:10px;'>Cantidad</th>
<th style='padding:10px;'>Stock</th>
<th style='padding:10px;'>Observación</th>
<th style='padding:10px;'>Fecha</th>

</tr>

</thead>

<tbody>

";

while($row = mysqli_fetch_assoc($sql)){

$tipo = "
<span style='color:#22c55e;font-weight:bold;'>
➕ Entrada
</span>
";

if($row['tipo'] == 'salida'){

$tipo = "
<span style='color:#ef4444;font-weight:bold;'>
➖ Salida
</span>
";

}

$html .= "

<tr>

<td style='padding:10px;text-align:center;'>
$tipo
</td>

<td style='padding:10px;text-align:center;'>
".$row['cantidad']."
</td>

<td style='padding:10px;text-align:center;'>
".$row['stock_anterior']."
 →
 ".$row['stock_nuevo']."
</td>

<td style='padding:10px;'>
".$row['observacion']."
</td>

<td style='padding:10px;'>
".$row['fecha']."
</td>

</tr>

";

}

$html .= "

</tbody>

</table>

";

echo $html;