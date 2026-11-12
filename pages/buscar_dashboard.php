<?php
/** @var mysqli $conexion */
session_start();


header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode([]);
    exit();
}

include("../includes/conexion.php");

$termino = trim($_GET['q'] ?? '');

if ($termino === '' || mb_strlen($termino) < 2) {
    echo json_encode([]);
    exit();
}

$buscar = "%" . $termino . "%";
$resultados = [];

/* BUSCAR CLIENTES */

$sqlClientes = "SELECT id, nombre, dni, telefono
                FROM clientes
                WHERE nombre LIKE ?
                   OR dni LIKE ?
                   OR telefono LIKE ?
                   OR correo LIKE ?
                   OR codigo LIKE ?
                   OR usuario LIKE ?
                LIMIT 5";

$stmt = $conexion->prepare($sqlClientes);
$stmt->bind_param("ssssss", $buscar, $buscar, $buscar, $buscar, $buscar, $buscar);
$stmt->execute();
$res = $stmt->get_result();

while ($fila = $res->fetch_assoc()) {
    $resultados[] = [
        'tipo' => 'Cliente',
        'titulo' => $fila['nombre'],
        'detalle' => 'DNI: ' . ($fila['dni'] ?? ''),
        'url' => 'clientes.php?id=' . $fila['id']
    ];
}
$stmt->close();

/* BUSCAR PRODUCTOS */

$sqlProductos = "SELECT id, nombre, descripcion, stock
                 FROM productos
                 WHERE nombre LIKE ?
                    OR descripcion LIKE ?
                    OR CAST(id AS CHAR) LIKE ?
                 LIMIT 5";

$stmt = $conexion->prepare($sqlProductos);
$stmt->bind_param("sss", $buscar, $buscar, $buscar);
$stmt->execute();
$res = $stmt->get_result();

while ($fila = $res->fetch_assoc()) {
    $resultados[] = [
        'tipo' => 'Producto',
        'titulo' => $fila['nombre'],
        'detalle' => 'Stock: ' . ($fila['stock'] ?? 0),
        'url' => 'productos.php?id=' . $fila['id']
    ];
}
$stmt->close();

/* BUSCAR VENTAS */

$sqlVentas = "SELECT ventas.id, ventas.total, ventas.fecha,
                     ventas.metodo_pago, ventas.estado,
                     clientes.nombre AS cliente
              FROM ventas
              LEFT JOIN clientes ON ventas.cliente_id = clientes.id
              WHERE CAST(ventas.id AS CHAR) LIKE ?
                 OR ventas.metodo_pago LIKE ?
                 OR ventas.estado LIKE ?
                 OR clientes.nombre LIKE ?
              ORDER BY ventas.fecha DESC
              LIMIT 5";

$stmt = $conexion->prepare($sqlVentas);
$stmt->bind_param("ssss", $buscar, $buscar, $buscar, $buscar);
$stmt->execute();
$res = $stmt->get_result();

while ($fila = $res->fetch_assoc()) {
    $resultados[] = [
        'tipo' => 'Venta',
        'titulo' => 'Venta #' . $fila['id'],
        'detalle' => 'Cliente: ' . ($fila['cliente'] ?? 'Sin cliente')
                     . ' | S/ ' . $fila['total']
                     . ' | ' . $fila['metodo_pago'],
        'url' => 'ventas.php?id=' . $fila['id']
    ];
}
$stmt->close();

echo json_encode($resultados, JSON_UNESCAPED_UNICODE);
?>