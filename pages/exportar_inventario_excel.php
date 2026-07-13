<?php
/** @var mysqli $conexion */
include("../includes/conexion.php");
$buscar =
$_GET['buscar'] ?? '';

$categoria =
$_GET['categoria'] ?? '';

$estado =
$_GET['estado'] ?? '';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=inventario_softfit.xls");

echo "
<table border='1'>

<tr>
<th>Producto</th>
<th>Categoría</th>
<th>Stock</th>
<th>Precio Unitario</th>
<th>Valor Total</th>
</tr>
";

$where = "WHERE 1=1";

if($buscar != ''){

$where .= "
AND productos.nombre
LIKE '%$buscar%'
";

}

if($categoria != ''){

$where .= "
AND categorias.id = '$categoria'
";

}

if($estado == 'critico'){

$where .= "
AND productos.stock <= 5
AND productos.stock > 0
";

}

if($estado == 'agotado'){

$where .= "
AND productos.stock = 0
";

}

if($estado == 'normal'){

$where .= "
AND productos.stock > 5
";

}

$sql = mysqli_query(
$conexion,
"
SELECT
productos.*,
categorias.nombre AS categoria
FROM productos
LEFT JOIN categorias
ON productos.categoria_id = categorias.id
$where
ORDER BY productos.nombre ASC
"
);
while($fila = mysqli_fetch_assoc($sql)){

$valor =
$fila['stock'] *
$fila['precio'];

echo "
<tr>

<td>".$fila['nombre']."</td>

<td>".$fila['categoria']."</td>

<td>".$fila['stock']."</td>

<td>".$fila['precio']."</td>

<td>".$valor."</td>

</tr>
";

}

echo "</table>";