<?php
ob_start();
require_once '../libs/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

include("../includes/conexion.php");


/* OBTENER ID */

$idVenta = $_GET['id'];

/* OBTENER VENTA */

$venta = mysqli_query($conexion,

"SELECT

ventas.*,
clientes.nombre

FROM ventas

LEFT JOIN clientes
ON ventas.cliente_id = clientes.id

WHERE ventas.id='$idVenta'");

$v = mysqli_fetch_assoc($venta);

/* OBTENER DETALLES */

$detalles = mysqli_query($conexion,

"SELECT detalle_ventas.*,
productos.nombre

FROM detalle_ventas

INNER JOIN productos
ON detalle_ventas.producto_id = productos.id

WHERE detalle_ventas.venta_id='$idVenta'");
/* HTML PDF */

$html = '

<h1 style="text-align:center;">

SOFT-FIT

</h1>

<hr>

<p>

<b>Cliente:</b> '.$v['nombre'].'<br>

<b>Venta #:</b> '.$v['id'].'<br>

<b>Fecha:</b> '.$v['fecha'].'<br>

<b>Método Pago:</b> '.$v['metodo_pago'].'

</p>

<hr>

<table width="100%"
border="1"
cellspacing="0"
cellpadding="8">

<tr>

<th>Producto</th>
<th>Cantidad</th>
<th>Subtotal</th>

</tr>

';

/* RECORRER PRODUCTOS */

while($d = mysqli_fetch_assoc($detalles)){

$html .= '

<tr>

<td>'.$d['nombre'].'</td>

<td>'.$d['cantidad'].'</td>

<td>S/ '.$d['subtotal'].'</td>

</tr>

';

}

$html .= '

</table>

<h2>

Total:
S/ '.$v['total'].'

</h2>

<p style="text-align:center;">

Gracias por su compra

</p>

';

/* CREAR PDF */

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper('A4');

$dompdf->render();
ob_end_clean();

$dompdf->stream("ticket.pdf", ["Attachment" => false]);

