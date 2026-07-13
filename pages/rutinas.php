<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("rutinas")){
    header("Location: dashboard.php");
    exit();
}



if(isset($_POST['guardar'])){

    $cliente_id = $_POST['cliente_id'];

    $titulo = $_POST['titulo'];

    $descripcion = $_POST['descripcion'];

    mysqli_query($conexion,

    "INSERT INTO rutinas(

    cliente_id,
    titulo,
    descripcion

    ) VALUES(

    '$cliente_id',
    '$titulo',
    '$descripcion'

    )");

    header("Location: rutinas.php");

}
/* ============================
   ESTADÍSTICAS
============================ */

$totalRutinas = mysqli_num_rows(
    mysqli_query($conexion,
    "SELECT * FROM rutinas")
);

$totalClientesConRutina = mysqli_num_rows(
    mysqli_query($conexion,
    "SELECT DISTINCT cliente_id
     FROM rutinas")
);
?>
<!DOCTYPE html>
<html>

<head>

<title>Rutinas</title>

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

<i class="fa-solid fa-dumbbell"></i>

Gestión de Rutinas

</h1>

<p>

Crea y administra rutinas personalizadas para tus clientes.

</p>

</div>

</div>
<div class="stats-grid">

    <div class="stat-card">

        <i class="fa-solid fa-dumbbell"></i>

        <h3>

            <?php echo $totalRutinas; ?>

        </h3>

        <span>

            Total de Rutinas

        </span>

    </div>

    <div class="stat-card">

        <i class="fa-solid fa-users"></i>

        <h3>

            <?php echo $totalClientesConRutina; ?>

        </h3>

        <span>

            Clientes con Rutina

        </span>

    </div>

</div>

<br>
<form method="POST">
<div class="form-row">

<div class="form-group">

<label>Cliente</label>

<select name="cliente_id" required>

<option value="">
Seleccionar Cliente
</option>

<?php

$clientes = mysqli_query($conexion,
"SELECT * FROM clientes");

while($c=mysqli_fetch_assoc($clientes)){

?>

<option value="<?php echo $c['id']; ?>">

<?php echo $c['nombre']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label>Título</label>

<input
type="text"
name="titulo"
placeholder="Ej. Rutina de Hipertrofia"
required>

</div>

</div>


<br><br>

<div class="form-group">

<label>Descripción</label>

<textarea
name="descripcion"
rows="8"
placeholder="Describe aquí la rutina completa..."
required>

</textarea>

</div>

<br><br>

<button
class="btn-primary"
type="submit"
name="guardar">

<i class="fa-solid fa-floppy-disk"></i>

Guardar Rutina

</button>
</form>
<hr style="margin:40px 0;border:none;border-top:1px solid #eee;">

<h2 class="section-title">

<i class="fa-solid fa-list"></i>

Rutinas Registradas

</h2>



<div class="table-card">
<div class="usuarios-topbar">

    <div class="usuarios-actions">

        <input
        type="text"
        id="buscarRutina"
        class="search-input"
        placeholder="Buscar rutina...">

    </div>
<select
id="filtroCliente"
class="search-input">

    <option value="">Todos los clientes</option>

    <?php

    $clientesFiltro = mysqli_query($conexion,
    "SELECT * FROM clientes ORDER BY nombre");

    while($cliente = mysqli_fetch_assoc($clientesFiltro)){

    ?>

        <option value="<?php echo strtolower($cliente['nombre']); ?>">

            <?php echo $cliente['nombre']; ?>

        </option>

    <?php } ?>

</select>
</div>

<br>
<table
class="modern-table"
id="tablaRutinas">
<thead>

<tr>

<th>Cliente</th>
<th>Título</th>

</tr>

</thead>

<tbody>

<?php

$rutinas = mysqli_query($conexion,

"SELECT rutinas.*,
clientes.nombre

FROM rutinas

INNER JOIN clientes

ON rutinas.cliente_id =
clientes.id");

while($r = mysqli_fetch_assoc($rutinas)){

?>

<tr
id="fila-<?php echo $r['id']; ?>"
data-cliente="<?php echo strtolower($r['nombre']); ?>">

<td>

<?php echo $r['nombre']; ?>

</td>

<td>

<?php echo $r['titulo']; ?>

</td>

</tr>

<?php } ?>
</tbody>
</table>
</div>
</div>

</div>
<script>

const buscarRutina =
document.getElementById("buscarRutina");

const filtroCliente =
document.getElementById("filtroCliente");

function filtrarRutinas(){

    let texto =
    buscarRutina.value.toLowerCase();

    let cliente =
    filtroCliente.value;

    let filas =
    document.querySelectorAll("#tablaRutinas tbody tr");

    filas.forEach(function(fila){

        let contenido =
        fila.textContent.toLowerCase();

        let nombreCliente =
        fila.dataset.cliente;

        let coincideTexto =
        contenido.includes(texto);

        let coincideCliente =
        cliente === "" || nombreCliente === cliente;

        if(coincideTexto && coincideCliente){

            fila.style.display="";

        }else{

            fila.style.display="none";

        }

    });

}

buscarRutina.addEventListener(
"keyup",
filtrarRutinas
);

filtroCliente.addEventListener(
"change",
filtrarRutinas
);

</script>
</body>

</html>