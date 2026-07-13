<?php
/** @var mysqli $conexion */
include('../includes/conexion.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=ventas.csv');

/* SOLUCION PARA TILDES EN EXCEL */
echo chr(239) . chr(187) . chr(191);

$salida = fopen('php://output', 'w');

/* ENCABEZADOS */

fputcsv($salida, array(
'ID',
'Cliente',
'Total',
'Fecha',
'Metodo de Pago'
));

/* CONSULTA */

$ventas = mysqli_query($conexion,

"SELECT

ventas.*,
clientes.nombre

FROM ventas

LEFT JOIN clientes
ON ventas.cliente_id = clientes.id

ORDER BY ventas.id DESC");

while($v = mysqli_fetch_assoc($ventas)){

    $cliente = $v['nombre'];

    if($cliente==""){
        $cliente = "Sin cliente";
    }

    fputcsv($salida, array(
        $v['id'],
        $cliente,
        $v['total'],
        $v['fecha'],
        $v['metodo_pago']
    ));

}

fclose($salida);

exit;

?>