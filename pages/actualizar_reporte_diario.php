<?php
/** @var mysqli $conexion */

include("../includes/conexion.php");

$fecha = date("Y-m-d");

/* Verificar si ya existe el registro del día */

$verificar = mysqli_query($conexion,"
SELECT id
FROM reporte_ventas_diarias
WHERE fecha='$fecha'
");

if(mysqli_num_rows($verificar)==0){

    mysqli_query($conexion,"
    INSERT INTO reporte_ventas_diarias(fecha)
    VALUES('$fecha')
    ");

}

/* ===============================
   MEMBRESÍAS
=============================== */

$res = mysqli_query($conexion,"

SELECT

COUNT(membresias.id) AS cantidad,

COALESCE(SUM(planes_membresia.precio),0) AS total

FROM membresias

INNER JOIN planes_membresia
ON membresias.plan_id=planes_membresia.id

WHERE DATE(membresias.fecha_inicio)=CURDATE()

");

$m = mysqli_fetch_assoc($res);

mysqli_query($conexion,"
UPDATE reporte_ventas_diarias
SET

membresias='{$m['cantidad']}',
total_membresias='{$m['total']}'

WHERE fecha='$fecha'
");
/* ===============================
   CLIENTES DIARIOS
=============================== */

$res = mysqli_query($conexion,"
SELECT
COUNT(id) AS cantidad,
COALESCE(SUM(monto),0) AS total
FROM clases_diarias
WHERE DATE(fecha)=CURDATE()
");

$c = mysqli_fetch_assoc($res);

mysqli_query($conexion,"
UPDATE reporte_ventas_diarias
SET
clientes_diarios='{$c['cantidad']}',
total_clientes_diarios='{$c['total']}'
WHERE fecha='$fecha'
");
/* ===============================
   VENTAS POR CATEGORÍAS
=============================== */

$categorias = mysqli_query($conexion,"
SELECT
categorias.nombre,
COALESCE(SUM(detalle_ventas.cantidad),0) AS cantidad,
COALESCE(SUM(detalle_ventas.subtotal),0) AS total
FROM categorias
LEFT JOIN productos
ON categorias.id = productos.categoria_id
LEFT JOIN detalle_ventas
ON productos.id = detalle_ventas.producto_id
LEFT JOIN ventas
ON detalle_ventas.venta_id = ventas.id
WHERE ventas.estado='Completada'
AND DATE(ventas.fecha)=CURDATE()
GROUP BY categorias.id
");
while($cat = mysqli_fetch_assoc($categorias)){

    $nombre = strtolower(trim($cat['nombre']));

    switch($nombre){

        case 'suplementos':

            mysqli_query($conexion,"
            UPDATE reporte_ventas_diarias
            SET
            suplementos='{$cat['cantidad']}',
            total_suplementos='{$cat['total']}'
            WHERE fecha='$fecha'
            ");

        break;

        case 'creatinas':

            mysqli_query($conexion,"
            UPDATE reporte_ventas_diarias
            SET
            creatinas='{$cat['cantidad']}',
            total_creatinas='{$cat['total']}'
            WHERE fecha='$fecha'
            ");

        break;

        case 'bebidas':

            mysqli_query($conexion,"
            UPDATE reporte_ventas_diarias
            SET
            bebidas='{$cat['cantidad']}',
            total_bebidas='{$cat['total']}'
            WHERE fecha='$fecha'
            ");

        break;

        case 'snacks':

            mysqli_query($conexion,"
            UPDATE reporte_ventas_diarias
            SET
            snacks='{$cat['cantidad']}',
            total_snacks='{$cat['total']}'
            WHERE fecha='$fecha'
            ");

        break;

        case 'accesorios':

            mysqli_query($conexion,"
            UPDATE reporte_ventas_diarias
            SET
            accesorios='{$cat['cantidad']}',
            total_accesorios='{$cat['total']}'
            WHERE fecha='$fecha'
            ");

        break;

        case 'equipamiento':

            mysqli_query($conexion,"
            UPDATE reporte_ventas_diarias
            SET
            equipamiento='{$cat['cantidad']}',
            total_equipamiento='{$cat['total']}'
            WHERE fecha='$fecha'
            ");

        break;

    }

}