<?php
/** @var mysqli $conexion */
include('../includes/conexion.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=clientes.csv');
echo chr(239) . chr(187) . chr(191);
$salida = fopen('php://output', 'w');

fputcsv($salida, array(
'ID',
'Nombre',
'DNI',
'Telefono',
'Correo'
));

$clientes = mysqli_query($conexion,
"SELECT * FROM clientes");

while($c = mysqli_fetch_assoc($clientes)){

    fputcsv($salida, array(
        $c['id'],
        $c['nombre'],
        $c['dni'],
        $c['telefono'],
        $c['correo']
    ));

}

fclose($salida);

exit;

?>