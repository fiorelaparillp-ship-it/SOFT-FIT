<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("membresias")){
    header("Location: dashboard.php");
    exit();
}

/* VARIABLES */

$idEditar = "";
$planEditar = "";
$duracionEditar = "";
$precioEditar = "";
/* OBTENER DATOS PARA EDITAR */

if(isset($_GET['editar'])){

    $idEditar = $_GET['editar'];

    $consultaEditar = "SELECT * FROM planes_membresia
                       WHERE id='$idEditar'";

    $resultadoEditar = mysqli_query($conexion,$consultaEditar);

    $filaEditar = mysqli_fetch_assoc($resultadoEditar);

    $planEditar = $filaEditar['plan'];
    $duracionEditar = $filaEditar['duracion'];
    $precioEditar = $filaEditar['precio'];

}
/* GUARDAR PLAN */

if(isset($_POST['guardar'])){

    $plan = $_POST['plan'];

    $duracion = $_POST['duracion'];

    $precio = $_POST['precio'];

    $guardar = "INSERT INTO planes_membresia(

                plan,
                duracion,
                precio)

                VALUES(

                '$plan',
                '$duracion',
                '$precio')";

    mysqli_query($conexion,$guardar);
header("Location: membresias.php?toast=guardado");
exit();
}
/* ACTUALIZAR PLAN */

if(isset($_POST['actualizar'])){

    $id = $_POST['id'];
    $plan = $_POST['plan'];
    $duracion = $_POST['duracion'];
    $precio = $_POST['precio'];

    $actualizar = "UPDATE planes_membresia
                   SET plan='$plan',
                       duracion='$duracion',
                       precio='$precio'
                   WHERE id='$id'";

    mysqli_query($conexion,$actualizar);

    header("Location: membresias.php?toast=actualizado");
    exit();

}
/* ELIMINAR PLAN */

if(isset($_GET['eliminar'])){

    $id = $_GET['eliminar'];

    mysqli_query($conexion,
    "DELETE FROM planes_membresia
     WHERE id='$id'");

    header("Location: membresias.php?toast=eliminado");
    exit();

}
/* CONSULTAR PLANES */

$planes = mysqli_query($conexion,

"SELECT * FROM planes_membresia");

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">


<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Planes de Membresía</title>


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
            Membresías
        </h1>

        <p>

            Administra todos los planes disponibles del gimnasio.

        </p>

    </div>

</div>
<?php

$totalPlanes = mysqli_num_rows(
mysqli_query($conexion,"SELECT * FROM planes_membresia"));

?>
<div class="stats-grid">

<div class="stat-card">

<i class="fa-solid fa-layer-group"></i>

<h3><?php echo $totalPlanes; ?></h3>

<span>Total Planes</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-calendar-days"></i>

<h3>3</h3>

<span>Duraciones</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-dollar-sign"></i>

<h3>S/</h3>

<span>Precios</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-circle-check"></i>

<h3>100%</h3>

<span>Disponibles</span>

</div>

</div>
<h2 class="section-title">

    <i class="fa-solid fa-file-circle-plus"></i>

    Información del plan

</h2>

<form method="POST" class="form-grid">
<input
type="hidden"
name="id"
value="<?php echo $idEditar; ?>">
<div class="campo">

<label>

<i class="fa-solid fa-dumbbell"></i>

Nombre del plan

</label>

<input
type="text"
name="plan"
value="<?php echo $planEditar; ?>"
placeholder="Ejemplo: Mensual"
required>

</div>

<div class="campo">

<label>

<i class="fa-solid fa-calendar-days"></i>

Duración

</label>

<input
type="text"
name="duracion"
value="<?php echo $duracionEditar; ?>"
placeholder="30 días"
required>

</div>

<div class="campo">

<label>

<i class="fa-solid fa-money-bill-wave"></i>

Precio

</label>

<input
type="number"
step="0.01"
name="precio"
value="<?php echo $precioEditar; ?>"
placeholder="0.00"
required>

</div>

<div class="acciones-form">

<button
type="submit"
name="<?php echo isset($_GET['editar']) ? 'actualizar' : 'guardar'; ?>">

<i class="fa-solid fa-floppy-disk"></i>

<?php

echo isset($_GET['editar'])

? "Actualizar Plan"

: "Guardar Plan";

?>

</button>
<?php if(isset($_GET['editar'])){ ?>

<a href="membresias.php" class="btn-cancelar">

<i class="fa-solid fa-xmark"></i>

Cancelar

</a>

<?php } ?>
</div>

</form>

<br><br>

<div class="table-card">

<div class="table-header">

    <div>

        <h2>Planes registrados</h2>

        <p>Listado de todas las membresías disponibles.</p>

    </div>

    <div>

        <input
        type="text"
        id="buscarPlan"
        placeholder="Buscar plan...">

    </div>

</div>

<table class="tabla-clientes">

<thead>

<tr>

<th>ID</th>

<th>Plan</th>

<th>Duración</th>

<th>Precio</th>
<th style="width:150px;">Acciones</th>
</tr>

</thead>

<tbody>

<?php

while($p = mysqli_fetch_assoc($planes)){

?>

<tr>

<td>

<?php echo $p['id']; ?>

</td>

<td>

<?php echo $p['plan']; ?>

</td>

<td>

<?php echo $p['duracion']; ?>

</td>

<td>

S/ <?php echo $p['precio']; ?>

</td>
<td>

<div class="acciones">

<a href="membresias.php?editar=<?php echo $p['id']; ?>"
class="btn-icon editar">

<i class="fa-solid fa-pen"></i>

</a>

<a href="#"
class="btn-icon eliminar btn-eliminar"
data-id="<?php echo $p['id']; ?>"
data-plan="<?php echo $p['plan']; ?>">

<i class="fa-solid fa-trash"></i>

</a>

</div>

</td>
</tr>

<?php } ?>
</tbody>
</table>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if(isset($_GET['toast'])){ ?>

<script>

<?php if($_GET['toast']=="guardado"){ ?>

Swal.fire({
toast:true,
position:'bottom-end',
icon:'success',
title:'Plan guardado',
background:'#1f2937',
color:'#fff',
showConfirmButton:false,
timer:2000,
timerProgressBar:true
});

<?php } ?>

<?php if($_GET['toast']=="actualizado"){ ?>

Swal.fire({
toast:true,
position:'bottom-end',
icon:'success',
title:'Plan actualizado',
background:'#1f2937',
color:'#fff',
showConfirmButton:false,
timer:2000,
timerProgressBar:true
});

<?php } ?>

<?php if($_GET['toast']=="eliminado"){ ?>

Swal.fire({
toast:true,
position:'bottom-end',
icon:'success',
title:'Plan eliminado',
background:'#1f2937',
color:'#fff',
showConfirmButton:false,
timer:2000,
timerProgressBar:true
});

<?php } ?>

</script>

<?php } ?>
<script>

document.querySelectorAll('.btn-eliminar').forEach(btn => {

    btn.addEventListener('click', function(e){

        e.preventDefault();

        let id = this.dataset.id;
        let plan = this.dataset.plan;

        Swal.fire({

            title: '⚠ Eliminar plan',

            html: `¿Seguro que deseas eliminar el plan <b>${plan}</b>?`,

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#ef4444',

            cancelButtonColor: '#6b7280',

            confirmButtonText: 'Sí, eliminar',

            cancelButtonText: 'Cancelar',

            background: '#1f2937',

            color: '#fff'

        }).then((result)=>{

            if(result.isConfirmed){

                window.location =
                'membresias.php?eliminar=' + id;

            }

        });

    });

});

</script>
</body>

</html>