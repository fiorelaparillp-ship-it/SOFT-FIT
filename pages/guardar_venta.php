<?php
/** @var mysqli $conexion */
include("../includes/conexion.php");

/* RECIBIR DATOS */

$data = json_decode(file_get_contents("php://input"),true);

$carrito = $data['carrito'];

$metodo_pago = $data['metodo_pago'];

$cliente_id = $data['cliente_id'];

$total = $data['total'];

/* GUARDAR VENTA */

$guardarVenta = "INSERT INTO ventas(

                 cliente_id,
                 total,
                 metodo_pago,
                 estado

                 )

                 VALUES(

                 '$cliente_id',
                 '$total',
                 '$metodo_pago',
                 'Completada'

                 )";

mysqli_query($conexion,$guardarVenta);

/* OBTENER ID VENTA */

$idVenta = mysqli_insert_id($conexion);

/* RECORRER CARRITO */

foreach($carrito as $p){

    $id = $p['id'];

    $cantidad = $p['cantidad'];

    $precio = $p['precio'];

    $subtotal = $precio * $cantidad;

    /* GUARDAR DETALLE */

    $detalle = "INSERT INTO detalle_ventas(

                venta_id,
                producto_id,
                cantidad,
                subtotal)

                VALUES(

                '$idVenta',
                '$id',
                '$cantidad',
                '$subtotal')";

    mysqli_query($conexion,$detalle);

    /* CONSULTAR STOCK */

    $consulta = "SELECT * FROM productos
                 WHERE id='$id'";

    $resultado = mysqli_query($conexion,$consulta);

    $producto = mysqli_fetch_assoc($resultado);

    $nuevoStock = $producto['stock'] - $cantidad;

    /* ACTUALIZAR STOCK */

    $actualizar = "UPDATE productos

                   SET stock='$nuevoStock'

                   WHERE id='$id'";

    mysqli_query($conexion,$actualizar);

}

/* RESPUESTA */
echo $idVenta;
exit();

?>