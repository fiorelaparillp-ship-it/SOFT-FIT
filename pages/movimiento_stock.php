<?php
/** @var mysqli $conexion */
include("../includes/conexion.php");


$id = $_POST['id'];

$tipo = $_POST['tipo'];

$cantidad = $_POST['cantidad'];

$observacion = $_POST['observacion'];

$producto = mysqli_fetch_assoc(

mysqli_query(
$conexion,
"SELECT stock
FROM productos
WHERE id='$id'"
)

);

$stockAnterior = $producto['stock'];

if($tipo == 'entrada'){

$stockNuevo =
$stockAnterior + $cantidad;

}else{

$stockNuevo =
$stockAnterior - $cantidad;

}

mysqli_query(
$conexion,
"UPDATE productos
SET stock='$stockNuevo'
WHERE id='$id'"
);

mysqli_query(
$conexion,
"INSERT INTO movimientos_inventario(

producto_id,
tipo,
cantidad,
stock_anterior,
stock_nuevo,
observacion

)

VALUES(

'$id',
'$tipo',
'$cantidad',
'$stockAnterior',
'$stockNuevo',
'$observacion'

)"
);

echo "ok";