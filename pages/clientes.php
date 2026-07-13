<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("clientes")){
    header("Location: dashboard.php");
    exit();
}

/* VARIABLES */

$idEditar = "";
$nombreEditar = "";
$dniEditar = "";
$telefonoEditar = "";
$correoEditar = "";

/* OBTENER DATOS PARA EDITAR */

if(isset($_GET['editar'])){

    $idEditar = $_GET['editar'];

    $consultaEditar = "SELECT * FROM clientes 
                       WHERE id='$idEditar'";

    $resultadoEditar = mysqli_query($conexion,$consultaEditar);

    $filaEditar = mysqli_fetch_assoc($resultadoEditar);

    $nombreEditar = $filaEditar['nombre'];
    $dniEditar = $filaEditar['dni'];
    $telefonoEditar = $filaEditar['telefono'];
    $correoEditar = $filaEditar['correo'];

}

/* GUARDAR CLIENTE */

if(isset($_POST['guardar'])){

    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
/* FOTO */

$foto = "avatar.png";

if(!empty($_FILES['foto']['name'])){

    $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

    $foto = time().".".$extension;

    move_uploaded_file(
        $_FILES['foto']['tmp_name'],
        "../uploads/clientes/".$foto
    );

}
    $insertar = "INSERT INTO clientes(

nombre,
dni,
telefono,
correo,
foto

)

VALUES(

'$nombre',
'$dni',
'$telefono',
'$correo',
'$foto'

)";

    mysqli_query($conexion,$insertar);



/* CREAR USUARIO AUTOMÁTICO */

$usuario = strtolower(trim($nombre));

$password_user = trim($dni);

$rol = "Cliente";

/* EVITAR DUPLICADOS */

$verificar = mysqli_query($conexion,

"SELECT * FROM usuarios
WHERE usuario='$usuario'");

if(mysqli_num_rows($verificar)==0){

    $crear_usuario = "INSERT INTO usuarios(

                        usuario,
                        password,
                        rol)

                        VALUES(

                        '$usuario',
                        '$password_user',
                        '$rol')";

    $resultado_usuario = mysqli_query($conexion,$crear_usuario);

    if(!$resultado_usuario){

        die(mysqli_error($conexion));

    }

}

header("Location: clientes.php?toast=guardado");
exit();
}

/* ACTUALIZAR CLIENTE */

if(isset($_POST['actualizar'])){

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
 
/* FOTO */

$consultaFoto = mysqli_query($conexion,
"SELECT foto FROM clientes WHERE id='$id'");

$datosFoto = mysqli_fetch_assoc($consultaFoto);

$foto = $datosFoto['foto'];

if(!empty($_FILES['foto']['name'])){

    $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

    $foto = time().".".$extension;

    move_uploaded_file(

        $_FILES['foto']['tmp_name'],

        "../uploads/clientes/".$foto

    );

}
   $actualizar = "UPDATE clientes
               SET nombre='$nombre',
                   dni='$dni',
                   telefono='$telefono',
                   correo='$correo',
                   foto='$foto'
               WHERE id='$id'";

    mysqli_query($conexion,$actualizar);

    header("Location: clientes.php?toast=actualizado");
exit();

}

/* ELIMINAR CLIENTE */

if(isset($_GET['eliminar'])){

    $id = $_GET['eliminar'];

    $eliminar = "DELETE FROM clientes WHERE id='$id'";

    mysqli_query($conexion,$eliminar);

  header("Location: clientes.php?toast=eliminado");
exit();

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clientes - SOFT-FIT</title>

    <link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/softfit-ui.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<!-- SIDEBAR -->
<?php include("../includes/sidebar.php"); ?>

<!-- CONTENIDO -->

<div class="main-content">
    <div class="page-card">

   <div class="page-header">

    <div>

        <h1>

            <i class="fa-solid fa-users"></i>

            Clientes

        </h1>

        <p>
            Administra los clientes registrados en SOFT-FIT.
        </p>

    </div>

</div>

   
<?php

$totalClientes = mysqli_num_rows(
    mysqli_query($conexion,"SELECT * FROM clientes")
);

?>

<div class="stats-grid">

    <div class="stat-card">

        <i class="fa-solid fa-users"></i>

        <h3><?php echo $totalClientes; ?></h3>

        <span>Total Clientes</span>

    </div>

    <div class="stat-card">

        <i class="fa-solid fa-user-plus"></i>

        <h3><?php echo $totalClientes; ?></h3>

        <span>Registrados</span>

    </div>

    <div class="stat-card">

        <i class="fa-solid fa-id-card"></i>

        <h3><?php echo $totalClientes; ?></h3>

        <span>Con Acceso</span>

    </div>

    <div class="stat-card">

        <i class="fa-solid fa-chart-line"></i>

        <h3>100%</h3>

        <span>Sistema Activo</span>

    </div>

</div>
</h2>

    <!-- FORMULARIO -->
<div class="form-card">
<form method="POST" class="form-grid" enctype="multipart/form-data">

<input type="hidden"
name="id"
value="<?php echo $idEditar; ?>">

<div class="campo">

<label>
<i class="fa-solid fa-user"></i>
Nombre
</label>

<input
type="text"
name="nombre"
value="<?php echo $nombreEditar; ?>"
placeholder="Ingrese el nombre completo"
required>

</div>

<div class="campo">

<label>
<i class="fa-solid fa-id-card"></i>
DNI
</label>

<input
type="text"
name="dni"
value="<?php echo $dniEditar; ?>"
placeholder="Ingrese el DNI"
required>

</div>

<div class="campo">

<label>
<i class="fa-solid fa-phone"></i>
Teléfono
</label>

<input
type="text"
name="telefono"
value="<?php echo $telefonoEditar; ?>"
placeholder="Ingrese el teléfono"
required>

</div>

<div class="campo">

<label>
<i class="fa-solid fa-envelope"></i>
Correo electrónico
</label>

<input
type="email"
name="correo"
value="<?php echo $correoEditar; ?>"
placeholder="Ingrese el correo"
required>

</div>
<div class="campo">

<label>

<i class="fa-solid fa-camera"></i>

Fotografía

</label>

<input
type="file"
name="foto"
accept="image/*">

</div>
<div class="acciones-form">

<button
type="submit"
name="<?php echo isset($_GET['editar']) ? 'actualizar' : 'guardar'; ?>">

<?php
echo isset($_GET['editar'])
? "Actualizar Cliente"
: "Guardar Cliente";
?>

</button>

<?php if(isset($_GET['editar'])){ ?>

<a href="clientes.php" class="btn-cancelar">

    <i class="fa-solid fa-xmark"></i>

    Cancelar

</a>

<?php } ?>

</div>

</form>
</div>

    

    <!-- TABLA -->

    <div class="table-card">

<div class="table-header">

    <div>

        <h2 class="section-title">

    <i class="fa-solid fa-table"></i>

    Clientes registrados

</h2>

        <p>Listado completo de clientes.</p>

    </div>

    <div>

        <input
        type="text"
        id="buscarCliente"
        placeholder="Buscar cliente...">

    </div>

</div>

<table class="tabla-clientes">

        <thead>

<tr>

<th>ID</th>

<th>Nombre</th>

<th>DNI</th>

<th>Teléfono</th>

<th>Correo</th>

<th>Código</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

        <?php

        $porPagina = 10;

$pagina = isset($_GET['pagina'])
    ? (int)$_GET['pagina']
    : 1;

if($pagina < 1){
    $pagina = 1;
}

$inicio = ($pagina-1) * $porPagina;

$consulta = "SELECT * FROM clientes
ORDER BY id DESC
LIMIT $inicio,$porPagina";

        $resultado = mysqli_query($conexion,$consulta);

        while($fila = mysqli_fetch_assoc($resultado)){

        ?>

        <tr>

            <td><?php echo $fila['id']; ?></td>

            <td><?php echo $fila['nombre']; ?></td>

            <td><?php echo $fila['dni']; ?></td>

            <td><?php echo $fila['telefono']; ?></td>

            <td><?php echo $fila['correo']; ?></td>
            <td>

<span class="codigo-cliente">

SF<?php echo $fila['dni']; ?>

</span>

</td>

            <td>

               <div class="acciones">

<a href="clientes.php?editar=<?php echo $fila['id']; ?>" class="btn-icon editar">

    <i class="fa-solid fa-pen"></i>

</a>

<a href="#"
class="btn-icon eliminar btn-eliminar"
data-id="<?php echo $fila['id']; ?>"
data-nombre="<?php echo $fila['nombre']; ?>">

    <i class="fa-solid fa-trash"></i>

</a>

</div>
            </td>

        </tr>

        <?php } ?>
        <tr id="sinResultados" style="display:none;">

    <td colspan="7" class="sin-resultados">

        <i class="fa-solid fa-magnifying-glass"></i>

        <br><br>

        No se encontraron clientes.

    </td>

</tr>
        </tbody>

    </table>
    <?php

$totalRegistros = mysqli_num_rows(
    mysqli_query($conexion,"SELECT * FROM clientes")
);

$totalPaginas = ceil($totalRegistros/$porPagina);

?>

<div class="pagination">

<?php if($pagina>1){ ?>

<a href="?pagina=<?php echo $pagina-1; ?>">
    « Anterior
</a>

<?php } ?>

<?php

for($i=1;$i<=$totalPaginas;$i++){

?>

<a
href="?pagina=<?php echo $i; ?>"
class="<?php echo ($pagina==$i)?'activo':''; ?>">

<?php echo $i; ?>

</a>

<?php } ?>

<?php if($pagina<$totalPaginas){ ?>

<a href="?pagina=<?php echo $pagina+1; ?>">
Siguiente »
</a>

<?php } ?>

</div>
    </div>
</div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_GET['toast'])){ ?>

<script>

<?php if($_GET['toast'] == 'guardado'){ ?>
Swal.fire({
toast:true,
position:'bottom-end',
icon:'success',
title:'Cliente guardado',
background:'#1f2937',
color:'#fff',
showConfirmButton:false,
timer:2000,
timerProgressBar:true
});
<?php } ?>

<?php if($_GET['toast'] == 'actualizado'){ ?>
Swal.fire({
toast:true,
position:'bottom-end',
icon:'success',
title:'Cliente actualizado',
background:'#1f2937',
color:'#fff',
showConfirmButton:false,
timer:2000,
timerProgressBar:true
});
<?php } ?>

<?php if($_GET['toast'] == 'eliminado'){ ?>
Swal.fire({
toast:true,
position:'bottom-end',
icon:'success',
title:'Cliente eliminado',
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
        let nombre = this.dataset.nombre;

        Swal.fire({
            title: '⚠ Eliminar cliente',
            html: `¿Seguro que deseas eliminar a <b>${nombre}</b>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#1f2937',
            color: '#fff'
        }).then((result) => {

            if (result.isConfirmed) {

                window.location = 'clientes.php?eliminar=' + id;

            }

        });

    });

});



// ===============================
// BUSCADOR EN TIEMPO REAL
// ===============================

const buscador = document.getElementById("buscarCliente");

const filas = document.querySelectorAll(".tabla-clientes tbody tr");
const sinResultados = document.getElementById("sinResultados");
buscador.addEventListener("keyup", function () {

    const texto = this.value.toLowerCase();

    let encontrados = 0;

    filas.forEach(fila => {

        if (fila.id === "sinResultados") return;

        const contenido = fila.textContent.toLowerCase();

        if (contenido.includes(texto)) {

            fila.style.display = "";

            encontrados++;

        } else {

            fila.style.display = "none";

        }

    });

    if (encontrados === 0) {

        sinResultados.style.display = "";

    } else {

        sinResultados.style.display = "none";

    }

});

</script>

</body>

</html>