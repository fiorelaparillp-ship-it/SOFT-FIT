<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("inventario")){
    header("Location: dashboard.php");
    exit();
}

include("../includes/sidebar.php");


$inventario = mysqli_query($conexion,"
SELECT
productos.*,
categorias.nombre AS categoria
FROM productos
LEFT JOIN categorias
ON productos.categoria_id = categorias.id
ORDER BY productos.nombre ASC
");

$totalProductos = mysqli_fetch_assoc(
mysqli_query($conexion,"
SELECT COUNT(*) total
FROM productos
")
)['total'];

$stockCritico = mysqli_fetch_assoc(
mysqli_query($conexion,"
SELECT COUNT(*) total
FROM productos
WHERE stock <= 5
AND stock > 0
")
)['total'];

$agotados = mysqli_fetch_assoc(
mysqli_query($conexion,"
SELECT COUNT(*) total
FROM productos
WHERE stock = 0
")
)['total'];

$valorInventario = mysqli_fetch_assoc(
mysqli_query($conexion,"
SELECT SUM(stock * precio) total
FROM productos
")
)['total'];

$categorias = mysqli_query(
$conexion,
"SELECT * FROM categorias ORDER BY nombre ASC"
);
?>
<link rel="stylesheet" href="../css/style.css?v=1">
<link rel="stylesheet" href="../css/dashboard.css">

<main class="contenido">

<h1 class="titulo-pagina">
 Inventario
</h1>
<div class="inventario-acciones">


</div>
<div class="inventario-top">

    <div class="resumen-card">

        <h3>Resumen Inventario</h3>

        <div class="resumen-grid">

            <div class="mini-kpi">

<div class="kpi-icon productos">
📦
</div>

<h2><?php echo $totalProductos; ?></h2>

<p>Productos</p>

<small>Total registrados</small>

</div>

           <div class="mini-kpi">

<div class="kpi-icon criticos">
⚠
</div>

<h2><?php echo $stockCritico; ?></h2>

<p>Críticos</p>

<small>Stock ≤ 5</small>

</div>

            <div class="mini-kpi">

<div class="kpi-icon agotados">
❌
</div>

<h2><?php echo $agotados; ?></h2>

<p>Agotados</p>

<small>Sin stock</small>

</div>

            <div class="mini-kpi">

<div class="kpi-icon dinero">
💰
</div>

<h2>S/<?php echo number_format($valorInventario,2); ?></h2>

<p>Valor Total</p>

<small>Inventario</small>

</div>

        </div>

    </div>

    <div class="movimientos-recientes">

<h2>
📈 Movimientos Recientes
</h2>

<?php

$movimientos = mysqli_query(
$conexion,
"
SELECT
movimientos_inventario.*,
productos.nombre AS producto
FROM movimientos_inventario
INNER JOIN productos
ON movimientos_inventario.producto_id = productos.id
ORDER BY movimientos_inventario.fecha DESC
LIMIT 3
"
);

while($mov = mysqli_fetch_assoc($movimientos)){

$color = "#22c55e";
$icono = "↑";
$signo = "+";

if($mov['tipo'] == 'salida'){

$color = "#ef4444";
$icono = "↓";
$signo = "-";

}

?>

<div
class="movimiento-item
<?php echo $mov['tipo']; ?>">

<div class="mov-info">

<div class="mov-titulo">

<span class="mov-icono">

<?php echo $icono; ?>

</span>

<strong>

<?php echo $mov['producto']; ?>

</strong>

</div>

<div class="mov-descripcion">

<?php
echo ($mov['tipo'] == 'entrada')
?
'Entrada de stock'
:
'Salida de stock';
?>

</div>

<div class="mov-fecha">

<?php echo date('d/m/Y H:i', strtotime($mov['fecha'])); ?>

</div>

</div>

<div
class="mov-cantidad"
style="color:<?php echo $color; ?>">

<?php echo $signo; ?>

<?php echo $mov['cantidad']; ?>

unid.

</div>

</div>

<?php } ?>

</div>
<div class="barra-filtros">

<input
type="text"
id="buscarProducto"
placeholder="🔍 Buscar producto">

<select id="categoriaFiltro">

<option value="">
Todas las categorías
</option>

<?php
while($cat = mysqli_fetch_assoc($categorias)){
?>

<option value="<?php echo $cat['id']; ?>">

<?php echo $cat['nombre']; ?>

</option>

<?php } ?>

</select>

<select id="estadoFiltro">

<option value="">
Estado: Todos
</option>

<option value="normal">
Normal
</option>

<option value="critico">
Crítico
</option>

<option value="agotado">
Agotado
</option>

</select>

<div class="dropdown-exportar">

<button class="btn-exportar">

📄 Exportar

</button>

<div class="menu-exportar">

<a
href="#"
id="exportarExcel">

Excel

</a>

<a
href="#"
id="exportarPDF">

PDF

</a>

</div>

</div>

</div>
<div class="ver-historial">

<a
href="#"
id="btnHistorialCompleto">

📋 Ver historial completo →

</a>

</div>
</div>

</div>

<div class="inventario-table">

<table>

<thead>


<tr>

<th>Imagen</th>
<th>Producto</th>
<th>Categoría</th>
<th>Stock</th>
<th>Ingresos</th>
<th>Egresos</th>
<th>Precio Und</th>
<th>Valor Total</th>
<th>Estado</th>
<th>Acciones</th>

</tr>

</thead>

<tbody>
    <?php

while($fila = mysqli_fetch_assoc($inventario)){

$ingresos = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"
SELECT COALESCE(SUM(cantidad),0) total
FROM movimientos_inventario
WHERE producto_id='".$fila['id']."'
AND tipo='entrada'
"
)
);

$egresos = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"
SELECT COALESCE(SUM(cantidad),0) total
FROM movimientos_inventario
WHERE producto_id='".$fila['id']."'
AND tipo='salida'
"
)
);

if($fila['stock'] == 0){

    $estado = "agotado";
    $clase = "estado-agotado";

}elseif($fila['stock'] <= 5){

    $estado = "critico";
    $clase = "estado-critico";

}else{

    $estado = "normal";
    $clase = "estado-normal";

}

?>
<tr

data-producto="<?php echo strtolower($fila['nombre']); ?>"

data-categoria="<?php echo $fila['categoria_id']; ?>"

data-estado="<?= $estado ?>"

title="<?php echo strtolower($estado); ?>"

>

<td>

<img
class="img-producto"
src="../uploads/<?php echo $fila['imagen']; ?>"
alt="<?php echo $fila['nombre']; ?>">

</td>

<td class="producto-info">

<div class="producto-nombre">
    <?php echo $fila['nombre']; ?>
</div>

<div class="producto-sku">
    SKU: <?php echo $fila['id']; ?>
</div>

</td>

<td>

<?php echo $fila['categoria']; ?>

</td>

<td>

<?php

if($fila['stock'] == 0){

    $stockClass = "stock-agotado";

}elseif($fila['stock'] <= 10){

    $stockClass = "stock-critico";

}else{

    $stockClass = "stock-normal";

}

?>

<span class="<?php echo $stockClass; ?>">

<?php echo $fila['stock']; ?>

</span>

</td>
<td>

<span style="
color:#22c55e;
font-weight:bold;
">

+<?php echo $ingresos['total']; ?>

</span>

</td>

<td>

<span style="
color:#ef4444;
font-weight:bold;
">

-<?php echo $egresos['total']; ?>

</span>

</td>
<td>

S/
<?php echo number_format($fila['precio'],2); ?>

</td>

<td>

S/ <?php echo number_format(
$fila['stock'] * $fila['precio'],
2
); ?>

</td>

<td>

<span class="<?php echo $clase; ?>">

<?php echo ucfirst($estado); ?>

</span>

</td>

<td class="acciones">

<a
href="#"
class="accion-entrada"
data-id="<?php echo $fila['id']; ?>">

↑ Entrada

</a>

<a
href="#"
class="accion-salida"
data-id="<?php echo $fila['id']; ?>"
data-stock="<?php echo $fila['stock']; ?>">

↓ Salida

</a>

<a
href="#"
class="accion-ver"
data-id="<?php echo $fila['id']; ?>"
data-producto="<?php echo $fila['nombre']; ?>">

👁 Ver

</a>

</td>
</tr>
<?php } ?>
</tbody>

</table>

</div>

</main>

<script>

document
.querySelectorAll('.accion-entrada')
.forEach(btn=>{

btn.addEventListener(
'click',
function(){

let id =
this.dataset.id;

Swal.fire({

title:'➕ Entrada',

html:`

<input
id="cantidad"
class="swal2-input"
placeholder="Cantidad">

<input
id="observacion"
class="swal2-input"
placeholder="Observación">

`,

showCancelButton:true,

confirmButtonText:'Guardar',

preConfirm:()=>{

return {

cantidad:
document.getElementById('cantidad').value,

observacion:
document.getElementById('observacion').value

}

}

}).then((result)=>{

if(result.isConfirmed){

fetch(
'movimiento_stock.php',
{

method:'POST',

headers:{
'Content-Type':
'application/x-www-form-urlencoded'
},

body:

'id='+id+

'&tipo=entrada'+

'&cantidad='+result.value.cantidad+

'&observacion='+result.value.observacion

}

)

.then(()=>{

location.reload();

});

}

});

});

});

</script>
<script>

document
.querySelectorAll('.accion-salida')
.forEach(btn=>{

btn.addEventListener(
'click',
function(){

let id =
this.dataset.id;

let stock =
parseInt(this.dataset.stock);

Swal.fire({

title:'➖ Salida',

html:`

<input
id="cantidad"
class="swal2-input"
placeholder="Cantidad">

<input
id="observacion"
class="swal2-input"
placeholder="Observación">

`,

showCancelButton:true,

confirmButtonText:'Guardar',

preConfirm:()=>{

let cantidad =
parseInt(
document.getElementById('cantidad').value
);

if(cantidad > stock){

Swal.showValidationMessage(
'No puedes retirar más stock del disponible'
);

return false;

}

return {

cantidad:cantidad,

observacion:
document.getElementById('observacion').value

}

}

}).then((result)=>{

if(result.isConfirmed){

fetch(
'movimiento_stock.php',
{

method:'POST',

headers:{
'Content-Type':
'application/x-www-form-urlencoded'
},

body:

'id='+id+

'&tipo=salida'+

'&cantidad='+result.value.cantidad+

'&observacion='+result.value.observacion

}

)

.then(()=>{

location.reload();

});

}

});

});

});

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

document
.querySelectorAll('.accion-ver')
.forEach(btn=>{

btn.addEventListener(
'click',
function(){

let id =
this.dataset.id;

let producto =
this.dataset.producto;

fetch(
'obtener_movimientos.php?id=' + id
)

.then(res=>res.text())

.then(data=>{

Swal.fire({

title:
'📦 ' + producto,

html:data,

width:'900px',

background:'#1f2937',

color:'#fff',

confirmButtonText:'Cerrar'

});

});

});

});

</script>
<script>

document
.getElementById('btnHistorialCompleto')
.addEventListener(
'click',
function(e){

e.preventDefault();

fetch(
'historial_inventario.php'
)

.then(response=>response.text())

.then(data=>{

Swal.fire({

title:'📋 Historial Completo',

html:data,

width:'1200px',

showCloseButton:true,

showConfirmButton:false,

didOpen: () => {

const buscadorHistorial =
document.getElementById(
'buscarHistorial'
);

const filtroTipo =
document.getElementById(
'filtroTipo'
);
const fechaInicio =
document.getElementById(
'fechaInicio'
);

const fechaFin =
document.getElementById(
'fechaFin'
);

function filtrarHistorial(){

const texto =
buscadorHistorial.value
.toLowerCase();

const tipo =
filtroTipo.value
.toLowerCase();

document
.querySelectorAll(
'#tablaHistorial tbody tr'
)
.forEach(fila=>{

const producto =
fila.dataset.producto
.toLowerCase();

const tipoFila =
fila.dataset.tipo
.toLowerCase();
const fechaFila =
fila.dataset.fecha;

let mostrar = true;

if(
!producto.includes(texto)
){

mostrar = false;

}

if(
tipo !== ''
&&
tipoFila !== tipo
){

mostrar = false;

}
if(
fechaInicio.value !== ''
&&
fechaFila < fechaInicio.value
){

mostrar = false;

}

if(
fechaFin.value !== ''
&&
fechaFila > fechaFin.value
){

mostrar = false;

}
fila.style.display =
mostrar
?
''
:
'none';

});

}

buscadorHistorial
.addEventListener(
'keyup',
filtrarHistorial
);

filtroTipo
.addEventListener(
'change',
filtrarHistorial
);
fechaInicio
.addEventListener(
'change',
filtrarHistorial
);

fechaFin
.addEventListener(
'change',
filtrarHistorial
);
}

});

});

});

document
.getElementById('exportarExcel')
.addEventListener(
'click',
function(e){

e.preventDefault();

let buscar =
document.getElementById(
'buscarProducto'
).value;

let categoria =
document.getElementById(
'categoriaFiltro'
).value;

let estado =
document.getElementById(
'estadoFiltro'
).value;

window.location =
'exportar_inventario_excel.php'
+
'?buscar=' + encodeURIComponent(buscar)
+
'&categoria=' + encodeURIComponent(categoria)
+
'&estado=' + encodeURIComponent(estado);

});

document
.getElementById('exportarPDF')
.addEventListener(
'click',
function(e){

e.preventDefault();

let buscar =
document.getElementById(
'buscarProducto'
).value;

let categoria =
document.getElementById(
'categoriaFiltro'
).value;

let estado =
document.getElementById(
'estadoFiltro'
).value;

window.location =
'exportar_inventario_pdf.php'
+
'?buscar=' + encodeURIComponent(buscar)
+
'&categoria=' + encodeURIComponent(categoria)
+
'&estado=' + encodeURIComponent(estado);

});

</script>
<script>

const buscarProducto =
document.getElementById(
'buscarProducto'
);

const categoriaFiltro =
document.getElementById(
'categoriaFiltro'
);

const estadoFiltro =
document.getElementById(
'estadoFiltro'
);

function filtrarInventario(){

const texto =
buscarProducto.value
.toLowerCase();

const categoria =
categoriaFiltro.value;

const estado =
estadoFiltro.value
.toLowerCase();

document
.querySelectorAll(
'.inventario-table tbody tr'
)
.forEach(fila=>{

const producto =
fila.dataset.producto;

const categoriaFila =
fila.dataset.categoria;

const estadoFila =
fila.dataset.estado;

let mostrar = true;

if(
!producto.includes(texto)
){

mostrar = false;

}

if(
categoria !== ''
&&
categoriaFila !== categoria
){

mostrar = false;

}

if(
estado !== ''
&&
estadoFila !== estado
){

mostrar = false;

}

fila.style.display =
mostrar
?
''
:
'none';

});

}

buscarProducto
.addEventListener(
'keyup',
filtrarInventario
);

categoriaFiltro
.addEventListener(
'change',
filtrarInventario
);

estadoFiltro
.addEventListener(
'change',
filtrarInventario
);

</script>

</body>
</html>