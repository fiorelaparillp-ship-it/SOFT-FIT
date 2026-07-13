<?php
/** @var mysqli $conexion */
include("../includes/conexion.php");

$id = $_GET['id'];

/* DATOS DE LA VENTA */

$venta = mysqli_fetch_assoc(

mysqli_query(

$conexion,

"

SELECT

ventas.*,

clientes.nombre AS cliente

FROM ventas

LEFT JOIN clientes

ON clientes.id = ventas.cliente_id

WHERE ventas.id='$id'

"

)

);

/* PRODUCTOS */

$productos = mysqli_query(

$conexion,

"

SELECT

detalle_ventas.*,

productos.nombre

FROM detalle_ventas

LEFT JOIN productos

ON productos.id = detalle_ventas.producto_id

WHERE venta_id='$id'

"

);

$lista = [];

while($p = mysqli_fetch_assoc($productos)){

    $lista[] = $p;

}

echo json_encode([

    "venta"=>$venta,

    "productos"=>$lista

]);

?>