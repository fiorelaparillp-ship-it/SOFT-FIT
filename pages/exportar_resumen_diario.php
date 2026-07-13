<?php
/** @var mysqli $conexion */
include("../includes/conexion.php");

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=resumen_diario.csv');

/* Para que Excel reconozca correctamente las tildes */
echo chr(239) . chr(187) . chr(191);

$salida = fopen('php://output', 'w');

/* ENCABEZADOS */

fputcsv($salida, array(

'Fecha',
'Membresías',
'Ingreso Membresías',

'Clientes diarios',
'Ingreso Clientes',

'Suplementos',
'Ingreso Suplementos',

'Creatinas',
'Ingreso Creatinas',

'Bebidas',
'Ingreso Bebidas',

'Snacks',
'Ingreso Snacks',

'Accesorios',
'Ingreso Accesorios',

'Equipamiento',
'Ingreso Equipamiento',

'Total del Día'

));

/* CONSULTA */

$consulta = mysqli_query($conexion, "

SELECT *

FROM reporte_ventas_diarias

ORDER BY fecha DESC

");

while($fila = mysqli_fetch_assoc($consulta)){

    $totalDia =
        $fila['total_membresias']
        + $fila['total_clientes_diarios']
        + $fila['total_suplementos']
        + $fila['total_creatinas']
        + $fila['total_bebidas']
        + $fila['total_snacks']
        + $fila['total_accesorios']
        + $fila['total_equipamiento'];

    fputcsv($salida, array(

        $fila['fecha'],

        $fila['membresias'],
        $fila['total_membresias'],

        $fila['clientes_diarios'],
        $fila['total_clientes_diarios'],

        $fila['suplementos'],
        $fila['total_suplementos'],

        $fila['creatinas'],
        $fila['total_creatinas'],

        $fila['bebidas'],
        $fila['total_bebidas'],

        $fila['snacks'],
        $fila['total_snacks'],

        $fila['accesorios'],
        $fila['total_accesorios'],

        $fila['equipamiento'],
        $fila['total_equipamiento'],

        $totalDia

    ));

}

fclose($salida);

exit;