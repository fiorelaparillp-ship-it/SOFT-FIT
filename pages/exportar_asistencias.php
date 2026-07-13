<?php
/** @var mysqli $conexion */
include('../includes/conexion.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=asistencias.csv');

/* CORREGIR TILDES EN EXCEL */
echo chr(239) . chr(187) . chr(191);

$salida = fopen('php://output', 'w');

/* ENCABEZADOS */

fputcsv($salida, array(
'ID',
'Cliente',
'Fecha',
'Hora'
));

/* CONSULTA */

$asistencias = mysqli_query($conexion,

"SELECT
asistencias.*,
clientes.nombre

FROM asistencias

INNER JOIN clientes
ON asistencias.cliente_id = clientes.id

ORDER BY asistencias.id DESC");

while($a = mysqli_fetch_assoc($asistencias)){

    fputcsv($salida, array(
        $a['id'],
        $a['nombre'],
        $a['fecha'],
        $a['hora']
    ));

}

fclose($salida);

exit;

?>