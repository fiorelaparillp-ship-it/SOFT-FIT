<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("productos")){
    header("Location: dashboard.php");
    exit();
}

/* VARIABLES */

$idEditar = "";
$nombreEditar = "";
$descripcionEditar = "";
$stockEditar = "";
$precioEditar = "";
$imagenEditar = "";
$categoriaEditar = "";

/* OBTENER DATOS */

if(isset($_GET['editar'])){

    $idEditar = $_GET['editar'];

    $consultaEditar = "SELECT * FROM productos
                       WHERE id='$idEditar'";

    $resultadoEditar = mysqli_query($conexion,$consultaEditar);

    $filaEditar = mysqli_fetch_assoc($resultadoEditar);

    $nombreEditar = $filaEditar['nombre'];
    $descripcionEditar = $filaEditar['descripcion'];
    $stockEditar = $filaEditar['stock'];
    $precioEditar = $filaEditar['precio'];
    $imagenEditar = $filaEditar['imagen'];
    $categoriaEditar = $filaEditar['categoria_id'];

}

if(isset($_POST['guardar'])){

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
    $categoria_id = $_POST['categoria_id'];

    $precio_mayor = 0;
    $cantidad_mayor = 0;

    // 🔴 IMAGEN CORRECTA
    $imagen = "";

    if(isset($_FILES['imagen']) && $_FILES['imagen']['name'] != ""){

        $imagen = time() . "_" . $_FILES['imagen']['name'];
        $temp = $_FILES['imagen']['tmp_name'];

        move_uploaded_file($temp, "../uploads/" . $imagen);

    }

    $guardar = "INSERT INTO productos(
        nombre,
        descripcion,
        stock,
        precio,
        precio_mayor,
        cantidad_mayor,
        imagen,
        categoria_id
    )
    VALUES(
        '$nombre',
        '$descripcion',
        '$stock',
        '$precio',
        '$precio_mayor',
        '$cantidad_mayor',
        '$imagen',
        '$categoria_id'
    )";

    mysqli_query($conexion,$guardar);

    header("Location: productos.php?toast=guardado");
    exit();
}

/* ACTUALIZAR */

if(isset($_POST['actualizar'])){

    $id = $_POST['id'];

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria_id = $_POST['categoria_id'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
   $imagen = $_FILES['imagen']['name'];
 

if($imagen != ""){

    $temp = $_FILES['imagen']['tmp_name'];

    move_uploaded_file($temp,
    "../uploads/".$imagen);

}else{

    $imagen = $imagenEditar;

}

    $actualizar = "UPDATE productos
                   SET nombre='$nombre',
                       descripcion='$descripcion',
                       stock='$stock',
                       precio='$precio',
categoria_id='$categoria_id',
imagen='$imagen'

                   WHERE id='$id'";

    mysqli_query($conexion,$actualizar);

header("Location: productos.php?toast=actualizado");
exit();

}

/* ELIMINAR */

if(isset($_GET['eliminar'])){

    $id = $_GET['eliminar'];

    $eliminar = "DELETE FROM productos
                 WHERE id='$id'";

    mysqli_query($conexion,$eliminar);

    header("Location: productos.php");

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Productos</title>

    <link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/softfit-ui.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

<div class="page-card">

<div class="page-header">

    <div>

        <h1>
            <i class="fa-solid fa-box"></i>
            Productos
        </h1>

        <p>
            Gestiona el inventario y los productos del gimnasio.
        </p>

    </div>

</div>


    <form method="POST" enctype="multipart/form-data">

        <input type="hidden"
               name="id"
               value="<?php echo $idEditar; ?>">

        <div class="form-row">

<div class="form-group">

<label>
Nombre del Producto
</label>

<input
type="text"
name="nombre"
value="<?php echo $nombreEditar; ?>"
placeholder="Ej: Proteína Whey Gold"
required>

</div>

<div class="form-group">

<label>
Descripción
</label>

<input
type="text"
name="descripcion"
value="<?php echo $descripcionEditar; ?>"
placeholder="Ej: Proteína de alta calidad"
required>

</div>

</div>
<input
type="hidden"
name="categoria_id"
id="categoria_id"
value="<?php echo $categoriaEditar; ?>">
<h2 class="section-title">

<i class="fa-solid fa-layer-group"></i>

Seleccionar categoría

</h2>
<br>
<div class="categorias-grid">

<?php

$categorias = mysqli_query(
$conexion,
"SELECT * FROM categorias"
);

while($cat = mysqli_fetch_assoc($categorias)){

?>

<div
class="categoria-card
<?php

if($categoriaEditar == $cat['id']){

echo ' active';

}

?>"
data-id="<?php echo $cat['id']; ?>">
<div class="categoria-icon">

<?php

switch($cat['nombre']){

case 'Suplementos':
echo '<i class="fa-solid fa-dumbbell"></i>';
break;

case 'Creatinas':
echo '<i class="fa-solid fa-bolt"></i>';
break;

case 'Bebidas':
echo '<i class="fa-solid fa-bottle-water"></i>';
break;

case 'Snacks':
echo '<i class="fa-solid fa-cookie-bite"></i>';
break;

case 'Accesorios':
echo '<i class="fa-solid fa-bag-shopping"></i>';
break;

case 'Equipamiento':
echo '<i class="fa-solid fa-dumbbell"></i>';
break;

default:
echo '<i class="fa-solid fa-box"></i>';

}

?>

</div>

<div>

<?php echo $cat['nombre']; ?>

</div>

</div>

<?php } ?>

</div>




        <div class="form-row">

<div class="form-group">

<label>
Stock
</label>

<input
type="number"
name="stock"
value="<?php echo $stockEditar; ?>"
required>

</div>

<div class="form-group">

<label>
Precio
</label>

<input
type="number"
step="0.01"
name="precio"
value="<?php echo $precioEditar; ?>"
required>

</div>

</div> <!-- Cierra form-row -->

<div class="imagen-producto-box">

<label>
Imagen del Producto
</label>

<div class="imagenes-preview">

<?php if($imagenEditar != ""){ ?>

<div class="preview-imagen">

<h4>Actual</h4>

<img
src="../uploads/<?php echo $imagenEditar; ?>"
alt="Producto">

</div>

<?php } ?>

<div class="preview-imagen">

<h4>Nueva</h4>

<div id="placeholderPreview">

📷

<span>
Sin vista previa
</span>

</div>

<img
id="previewImagen"
style="display:none;"
alt="Vista previa">

</div>

</div>

<br>

<input
type="file"
name="imagen"
id="imagen">

</div>
        <br><br>

        <button
type="submit"
class="btn-producto"

        name="<?php

        if(isset($_GET['editar'])){

            echo 'actualizar';

        }else{

            echo 'guardar';

        }

        ?>">

        <?php

        if(isset($_GET['editar'])){

            echo 'Actualizar Producto';

        }else{

            echo 'Guardar Producto';

        }

        ?>

        </button>

    </form>

</div>

    <br><br>
 <div class="table-card">

<div class="table-header">
<div>

<h2>

<i class="fa-solid fa-box"></i>

Listado de Productos

</h2>

<p>

Administra el inventario del gimnasio.

</p>

</div>
<div class="toolbar-actions">
 <select id="filtroCategoria">
   
        <option value="all">
            Todas las categorías
        </option>

        <?php

        $categoriasFiltro =
        mysqli_query(
        $conexion,
        "SELECT * FROM categorias"
        );

        while($cat = mysqli_fetch_assoc($categoriasFiltro)){

        ?>

       <option value="<?php echo strtolower(trim($cat['nombre'])); ?>">

            <?php echo $cat['nombre']; ?>

        </option>

        <?php } ?>

    </select>
    <select id="ordenProductos">

<option value="default">
Más recientes
</option>

<option value="precioAsc">
Precio ↑
</option>

<option value="precioDesc">
Precio ↓
</option>

<option value="stockAsc">
Stock ↑
</option>

<option value="stockDesc">
Stock ↓
</option>

<option value="nombreAsc">
Nombre A-Z
</option>

<option value="nombreDesc">
Nombre Z-A
</option>

</select>

    <input
type="text"
id="buscarProducto"
placeholder="🔍 Buscar producto..."
class="search-input">

</div>
</div>
<?php

$totalProductos = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"SELECT COUNT(*) total FROM productos"
)
);

$stockCritico = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"SELECT COUNT(*) total FROM productos WHERE stock < 5"
)
);

$totalCategorias = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"SELECT COUNT(*) total FROM categorias"
)
);

$valorInventario = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"SELECT SUM(stock * precio) total FROM productos"
)
);

?>

<div class="stats-grid">

<div class="stat-card">

<i class="fa-solid fa-box"></i>

<h3><?php echo $totalProductos['total']; ?></h3>

<span>Total Productos</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-layer-group"></i>

<h3><?php echo $totalCategorias['total']; ?></h3>

<span>Categorías</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-triangle-exclamation"></i>

<h3><?php echo $stockCritico['total']; ?></h3>

<span>Stock Crítico</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-warehouse"></i>

<h3>S/ <?php echo number_format($valorInventario['total'],0); ?></h3>

<span>Valor Inventario</span>

</div>

</div>

<br>

  
<div class="productos-grid">

<?php

$consulta = "

SELECT productos.*,
categorias.nombre AS categoria

FROM productos

LEFT JOIN categorias
ON productos.categoria_id = categorias.id

";

$resultado = mysqli_query($conexion,$consulta);

while($fila = mysqli_fetch_assoc($resultado)){

?>

<div
class="producto-card producto-item

<?php

if($fila['stock'] == 0){

echo 'producto-agotado';

}

?>

"

data-categoria="<?php echo strtolower(trim($fila['categoria'])); ?>"

data-precio="<?php echo $fila['precio']; ?>"

data-stock="<?php echo $fila['stock']; ?>"

data-nombre="<?php echo strtolower($fila['nombre']); ?>">

<?php

if($fila['stock'] == 0){

?>

<div class="stock-alert agotado">

❌ AGOTADO

</div>

<?php

}elseif($fila['stock'] < 5){

?>

<div class="stock-alert">

🚨 STOCK CRÍTICO

</div>

<?php

}elseif($fila['stock'] <= 10){

?>

<div class="stock-alert warning">

⚠ STOCK BAJO

</div>

<?php

}

?>
<div class="producto-img">

<img
src="../uploads/<?php echo $fila['imagen']; ?>"
alt="">

</div>

<div class="producto-card-info">

<span class="categoria-badge">

<?php echo $fila['categoria']; ?>

</span>

<h3>

<?php echo $fila['nombre']; ?>

</h3>

<p>

<?php echo $fila['descripcion']; ?>

</p>
<div class="producto-divider"></div>

<div class="producto-stats">

<div>

<label>Stock</label>

<?php

$claseStock = "stock-alto";

if($fila['stock'] == 0){

$claseStock = "stock-agotado";

}elseif($fila['stock'] < 5){

$claseStock = "stock-bajo";

}elseif($fila['stock'] <= 10){

$claseStock = "stock-medio";

}

?>

<strong class="<?php echo $claseStock; ?>">

<?php echo $fila['stock']; ?>

</strong>

</div>

<div>

<label>Precio</label>

<strong class="precio-producto">

S/ <?php echo number_format($fila['precio'],2); ?>

</strong>

</div>



</div>

<div class="producto-actions">

<a
href="productos.php?editar=<?php echo $fila['id']; ?>"
class="btn-editar">
<i class="fa-solid fa-pen"></i>
 
Editar

</a>

<a
href="#"
class="btn-eliminar"
data-id="<?php echo $fila['id']; ?>"
data-nombre="<?php echo $fila['nombre']; ?>">
<i class="fa-solid fa-trash"></i>

Eliminar

</a>

</div>

</div>

</div>

<?php } ?>

</div>
</div>
</div>
<script>

const categorias =
document.querySelectorAll(
'.categoria-card'
);

const inputCategoria =
document.getElementById(
'categoria_id'
);

categorias.forEach(card=>{

card.addEventListener(
'click',
function(){

categorias.forEach(c=>
c.classList.remove('active')
);

this.classList.add('active');

inputCategoria.value =
this.dataset.id;

});

});

</script>
<script>

const buscador =
document.getElementById(
'buscarProducto'
);

const filtroCategoria =
document.getElementById(
'filtroCategoria'
);
const ordenProductos =
document.getElementById(
'ordenProductos'
);
 let visibles = 0;
function filtrarProductos(){

let visibles = 0;

let texto =
buscador.value.toLowerCase();

let categoria =
filtroCategoria.value.toLowerCase().trim();
let orden =
ordenProductos.value;

let grid =
document.querySelector(
'.productos-grid'
);

let productos =
Array.from(
document.querySelectorAll(
'.producto-item'
));

productos.forEach(function(card){

let contenido =
card.dataset.nombre;

let categoriaCard =
card.dataset.categoria;

let coincideTexto =
contenido.includes(texto);

let coincideCategoria =

categoria === 'all'

||

categoriaCard === categoria;

if(
coincideTexto &&
coincideCategoria
){

card.style.display = '';

visibles++;

}
else{

card.style.display = 'none';

}

});


productos.sort(function(a,b){

if(orden === 'precioAsc'){

return a.dataset.precio -
b.dataset.precio;

}

if(orden === 'precioDesc'){

return b.dataset.precio -
a.dataset.precio;

}

if(orden === 'stockAsc'){

return a.dataset.stock -
b.dataset.stock;

}

if(orden === 'stockDesc'){

return b.dataset.stock -
a.dataset.stock;

}

if(orden === 'nombreAsc'){

return a.dataset.nombre.localeCompare(
b.dataset.nombre
);

}

if(orden === 'nombreDesc'){

return b.dataset.nombre.localeCompare(
a.dataset.nombre
);

}

return 0;

});


grid.innerHTML = "";

productos.forEach(function(card){

    grid.appendChild(card);

});

let contador = document.getElementById("contadorProductos");

if(contador){

    contador.innerText = visibles;

}

}


buscador.addEventListener(
'keyup',
filtrarProductos
);

filtroCategoria.addEventListener(
'change',
filtrarProductos
);

ordenProductos.addEventListener(
'change',
filtrarProductos
);

filtrarProductos();
</script>
<script>

const inputImagen =
document.getElementById('imagen');

const preview =
document.getElementById('previewImagen');

inputImagen.addEventListener(
'change',
function(){

const archivo =
this.files[0];

if(archivo){

const lector =
new FileReader();

lector.onload =
function(e){

document.getElementById(
'placeholderPreview'
).style.display = 'none';

preview.src =
e.target.result;

preview.style.display =
'block';

}

lector.readAsDataURL(
archivo
);

}

}
);

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

if(isset($_GET['toast'])){

if($_GET['toast'] == 'guardado'){

?>

<script>

Swal.fire({

toast:true,

position:'bottom-end',

icon:'success',

title:'Producto guardado',

background:'#1f2937',

color:'#fff',

showConfirmButton:false,

timer:2000,

timerProgressBar:true

});

</script>

<?php

}

if($_GET['toast'] == 'actualizado'){

?>

<script>

Swal.fire({

toast:true,

position:'bottom-end',

icon:'success',

title:'Producto actualizado',

background:'#1f2937',

color:'#fff',

showConfirmButton:false,

timer:2000,

timerProgressBar:true

});

</script>

<?php

}

}

?>
<script>

document
.querySelectorAll('.btn-eliminar')
.forEach(btn=>{

btn.addEventListener(
'click',
function(e){

e.preventDefault();

let id =
this.dataset.id;

let nombre =
this.dataset.nombre;

Swal.fire({

title:'⚠ Eliminar',

html:`
<p>¿Deseas eliminar?</p>
<b>${nombre}</b>
`,

width:'380px',

icon:'warning',

showCancelButton:true,

confirmButtonText:'Sí, eliminar',

cancelButtonText:'Cancelar',

confirmButtonColor:'#ef4444',

cancelButtonColor:'#6b7280',

background:'#1f2937',

color:'#fff'

}).then((result)=>{

if(result.isConfirmed){

window.location =
'productos.php?eliminar=' + id;

}

});

});

});

</script>



</body>

</html>