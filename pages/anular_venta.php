<?php
/** @var mysqli $conexion */
session_start();

include("../includes/conexion.php");

if(!isset($_GET['id'])){
    exit("Venta no encontrada");
}

$idVenta = intval($_GET['id']);

/* Verificar estado */

$venta = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"SELECT * FROM ventas WHERE id='$idVenta'"
));

if(!$venta){
    exit("Venta inexistente");
}

if($venta['estado'] == 'Anulada'){
    exit("La venta ya fue anulada");
}

/* Obtener detalle */

$detalle = mysqli_query(
$conexion,
"SELECT * FROM detalle_ventas
WHERE venta_id='$idVenta'"
);

/* Devolver stock */

while($d = mysqli_fetch_assoc($detalle)){

    mysqli_query(
    $conexion,

    "UPDATE productos
     SET stock = stock + ".$d['cantidad']."
     WHERE id=".$d['producto_id']
    );

}

/* Cambiar estado */

mysqli_query(
$conexion,

"UPDATE ventas
SET estado='Anulada'
WHERE id='$idVenta'"
);

header("Location: ventas.php?anulada=1");
exit();
?>