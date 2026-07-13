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
$clienteEditar = "";
$planEditar = "";
$inicioEditar = "";
$finEditar = "";
/* OBTENER DATOS PARA EDITAR */

if(isset($_GET['editar'])){

    $idEditar = $_GET['editar'];

    $editar = mysqli_query($conexion,

    "SELECT * FROM membresias
    WHERE id='$idEditar'");

    $fila = mysqli_fetch_assoc($editar);

    $clienteEditar = $fila['cliente_id'];
    $planEditar = $fila['plan_id'];
    $inicioEditar = $fila['fecha_inicio'];
    $finEditar = $fila['fecha_fin'];

}
/* ACTUALIZAR */

if(isset($_POST['actualizar'])){

    $id = $_POST['id'];

    $cliente = $_POST['cliente'];

    $plan = $_POST['membresia'];

    $inicio = $_POST['inicio'];

    $fin = $_POST['fin'];

    mysqli_query($conexion,

    "UPDATE membresias SET

    cliente_id='$cliente',

    plan_id='$plan',

    fecha_inicio='$inicio',

    fecha_fin='$fin'

    WHERE id='$id'");

    header("Location: asignar_membresia.php?toast=actualizado");

    exit();

}
/* ELIMINAR */

if(isset($_GET['eliminar'])){

    $id = $_GET['eliminar'];

    mysqli_query($conexion,

    "DELETE FROM membresias
    WHERE id='$id'");

    header("Location: asignar_membresia.php?toast=eliminado");

    exit();

}
/* ACTUALIZAR ESTADOS */

$hoy = date("Y-m-d");

mysqli_query($conexion,

"UPDATE membresias
SET estado='Vencida'
WHERE fecha_fin < '$hoy'");

mysqli_query($conexion,

"UPDATE membresias
SET estado='Activa'
WHERE fecha_fin >= '$hoy'");

/* GUARDAR */

if(isset($_POST['guardar'])){

    $cliente = $_POST['cliente'];

    $membresia = $_POST['membresia'];

    $inicio = $_POST['inicio'];

    $fin = $_POST['fin'];

    $existe = mysqli_query($conexion,

"SELECT * FROM membresias
WHERE cliente_id='$cliente'
AND estado='Activa'");

if(mysqli_num_rows($existe)>0){

    header("Location: asignar_membresia.php?toast=duplicado");

    exit();

}
    $guardar = "INSERT INTO membresias(

                cliente_id,
                plan_id,
                fecha_inicio,
                fecha_fin,
                estado)

                VALUES(

                '$cliente',
                '$membresia',
                '$inicio',
                '$fin',
                'Activa')";

    mysqli_query($conexion,$guardar);

header("Location: asignar_membresia.php?toast=guardado");
exit();
}

/* CONSULTAR */

$consulta = mysqli_query($conexion,

"SELECT membresias.*,

clientes.nombre AS cliente,

planes_membresia.plan AS membresia

FROM membresias

INNER JOIN clientes
ON membresias.cliente_id = clientes.id

INNER JOIN planes_membresia
ON membresias.plan_id = planes_membresia.id");
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Asignar Membresía</title>

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

            <i class="fa-solid fa-id-card"></i>

            Asignar Membresía

        </h1>

        <p>

            Administra las membresías asignadas a los clientes.

        </p>

    </div>

</div>
<?php

$totalAsignadas = mysqli_num_rows(

mysqli_query($conexion,

"SELECT * FROM membresias")

);

?>

<div class="stats-grid">

<div class="stat-card">

<i class="fa-solid fa-id-card"></i>

<h3><?php echo $totalAsignadas; ?></h3>

<span>Membresías</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-circle-check"></i>

<h3>

<?php

echo mysqli_num_rows(

mysqli_query($conexion,

"SELECT * FROM membresias
WHERE estado='Activa'")

);

?>

</h3>

<span>Activas</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-circle-xmark"></i>

<h3>

<?php

echo mysqli_num_rows(

mysqli_query($conexion,

"SELECT * FROM membresias
WHERE estado='Vencida'")

);

?>

</h3>

<span>Vencidas</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-users"></i>

<h3>

<?php

echo mysqli_num_rows(

mysqli_query($conexion,

"SELECT * FROM clientes")

);

?>

</h3>

<span>Clientes</span>

</div>

</div>


<form method="POST" class="form-grid">
<input
type="hidden"
name="id"
value="<?php echo $idEditar; ?>">
<div class="campo">

<label>

<i class="fa-solid fa-user"></i>

Cliente

</label>

<select name="cliente" required>

<option value="">Seleccione un cliente</option>

<?php

$c = mysqli_query($conexion,"SELECT * FROM clientes");

while($cliente = mysqli_fetch_assoc($c)){

?>

<option
value="<?php echo $cliente['id']; ?>"

<?php
if($clienteEditar==$cliente['id']){
echo "selected";
}
?>>

<?php echo $cliente['nombre']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="campo">

<label>

<i class="fa-solid fa-id-card"></i>

Plan de Membresía

</label>

<select
name="membresia"
id="membresia"
required>

<option value="">Seleccione un plan</option>

<?php

$m = mysqli_query($conexion,"SELECT * FROM planes_membresia");

while($mem = mysqli_fetch_assoc($m)){

?>
<option
value="<?php echo $mem['id']; ?>"
data-duracion="<?php echo $mem['duracion']; ?>"

<?php
if($planEditar==$mem['id']){
echo "selected";
}
?>>

<?php echo $mem['plan']; ?>

</option>




<?php } ?>

</select>

</div>

<div class="campo">

<label>

<i class="fa-solid fa-calendar-days"></i>

Fecha de inicio

</label>

<input
type="date"
id="inicio"
name="inicio"
value="<?php echo $inicioEditar; ?>"
required>
</div>

<div class="campo">

<label>

<i class="fa-solid fa-calendar-check"></i>

Fecha de fin

</label>

<input
type="date"
id="fin"
name="fin"
value="<?php echo $finEditar; ?>"
required>
</div>

<div class="acciones-form">

<button
type="submit"
name="<?php echo isset($_GET['editar']) ? 'actualizar' : 'guardar'; ?>">

<i class="fa-solid fa-floppy-disk"></i>

<?php
echo isset($_GET['editar'])
? "Actualizar Asignación"
: "Asignar Membresía";
?>

</button>


</div>

</form>

<br><br>

<div class="table-card">

<div class="table-header">

    <div>

        <h2>Membresías asignadas</h2>

        <p>Listado de todas las membresías asignadas.</p>

    </div>

    <div>

        <input
        type="text"
        id="buscarMembresia"
        placeholder="Buscar cliente...">

    </div>

</div>
<h2 class="section-title">

    <i class="fa-solid fa-table"></i>

    Membresías asignadas

</h2>

<br>
<table class="tabla-clientes" id="tablaMembresias">

<thead>

<tr>
<th>Cliente</th>

<th>Membresía</th>

<th>Inicio</th>

<th>Fin</th>

<th>Estado</th>

<th>Días</th>
<th>Acciones</th>
</tr>

<tbody>
<?php

while($row = mysqli_fetch_assoc($consulta)){

?>

<tr>

<td class="cliente-col">

<?php echo $row['cliente']; ?>

</td>
<td class="plan-col">

<?php echo $row['membresia']; ?>

</td>

<td>

<?php echo $row['fecha_inicio']; ?>

</td>

<td>

<?php echo $row['fecha_fin']; ?>

</td>

<td>

<?php

if($row['estado']=="Activa"){

    echo "<span class='badge-activa'>Activa</span>";

}else{

    echo "<span class='badge-vencida'>Vencida</span>";

}

?>

</td>


<td>

<?php

$fin = strtotime($row['fecha_fin']);

$hoy = strtotime(date("Y-m-d"));

$dias = ($fin - $hoy) / 86400;

echo intval($dias);

?>

</td>
<td>

<div class="acciones">

<a href="asignar_membresia.php?editar=<?php echo $row['id']; ?>"
class="btn-icon editar">

<i class="fa-solid fa-pen"></i>

</a>

<a href="#"
class="btn-icon eliminar btn-eliminar"
data-id="<?php echo $row['id']; ?>"
data-cliente="<?php echo $row['cliente']; ?>">

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

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_GET['toast'])){ ?>

<script>

<?php if($_GET['toast']=="guardado"){ ?>

Swal.fire({
toast:true,
position:'bottom-end',
icon:'success',
title:'Membresía asignada',
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
title:'Asignación actualizada',
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
title:'Asignación eliminada',
background:'#1f2937',
color:'#fff',
showConfirmButton:false,
timer:2000,
timerProgressBar:true
});
<?php } ?>
<?php if($_GET['toast']=="duplicado"){ ?>

Swal.fire({

toast:true,

position:'bottom-end',

icon:'warning',

title:'El cliente ya tiene una membresía activa',

background:'#1f2937',

color:'#fff',

showConfirmButton:false,

timer:2500,

timerProgressBar:true

});

<?php } ?>


document.querySelectorAll('.btn-eliminar').forEach(btn => {

    btn.addEventListener('click', function(e){

        e.preventDefault();

        let id = this.dataset.id;
        let cliente = this.dataset.cliente;

        Swal.fire({

            title:'⚠ Eliminar membresía',

            html:`¿Eliminar la membresía de <b>${cliente}</b>?`,

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

                window.location='asignar_membresia.php?eliminar='+id;

            }

        });

    });

});
</script>
<?php } ?>
<script>

const buscar = document.getElementById("buscarMembresia");

buscar.addEventListener("keyup", function(){

    let texto = buscar.value.toLowerCase();

    document.querySelectorAll(".tabla-clientes tbody tr").forEach(fila=>{

        let contenido = fila.textContent.toLowerCase();

        if(contenido.includes(texto)){

            fila.style.display="";

            fila.style.background="#f8fafc";

        }else{

            fila.style.display="none";

        }

    });

});

</script>
<script>

const plan = document.getElementById("membresia");
const inicio = document.getElementById("inicio");
const fin = document.getElementById("fin");

function calcularFechaFin(){

    if(plan.value=="" || inicio.value==""){
        return;
    }

   let partes = inicio.value.split("-");
let fecha = new Date(partes[0], partes[1]-1, partes[2]);
console.log(plan.options[plan.selectedIndex].dataset.duracion);
    let duracion = plan.options[plan.selectedIndex].dataset.duracion;
console.log("Duración:", duracion);
    if(duracion == "1"){
    fecha.setMonth(fecha.getMonth() + 1);
}
else if(duracion == "3"){
    fecha.setMonth(fecha.getMonth() + 3);
}
else if(duracion == "6"){
    fecha.setMonth(fecha.getMonth() + 6);
}
else if(duracion == "12"){
    fecha.setMonth(fecha.getMonth() + 12);
}

    let año = fecha.getFullYear();
    let mes = String(fecha.getMonth()+1).padStart(2,"0");
    let dia = String(fecha.getDate()).padStart(2,"0");

    fin.value = `${año}-${mes}-${dia}`;
}

plan.addEventListener("change", calcularFechaFin);
inicio.addEventListener("change", calcularFechaFin);

</script>


</body>

</html>