<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("checkin")){
    header("Location: dashboard.php");
    exit();
}

date_default_timezone_set("America/Lima");

/* REGISTRAR CLASE DIARIA */

if(isset($_POST['guardarClase'])){

    $nombre = mysqli_real_escape_string($conexion, $_POST['nombreCliente']);

    $tipo = mysqli_real_escape_string($conexion, $_POST['tipoClase']);

    $monto = $_POST['precio'];

    $formaPago = mysqli_real_escape_string($conexion, $_POST['formaPago']);

    $usuario = $_SESSION['id'];

    mysqli_query($conexion,"
        INSERT INTO clases_diarias
        (
            nombre_cliente,
            tipo_clase,
            monto,
            forma_pago,
            usuario_id
        )
        VALUES
        (
            '$nombre',
            '$tipo',
            '$monto',
            '$formaPago',
            '$usuario'
        )
    ");
    mysqli_query($conexion,"
INSERT INTO ventas
(
    total,
    metodo_pago,
    estado
)
VALUES
(
    '$monto',
    '$formaPago',
    'Completada'
)
");

   header("Location: checkin.php?toast=clase_guardada");
exit();
}

/* REGISTRAR ASISTENCIA */

if(isset($_POST['registrar'])){

    $codigo = isset($_POST['codigo'])
? trim($_POST['codigo'])
: '';

$codigo = str_replace("-", "", $codigo);

    $fecha = date("Y-m-d");

    $hora = date("H:i:s");

$buscar = mysqli_query($conexion,

"SELECT clientes.*,

membresias.estado,
membresias.fecha_fin,

planes_membresia.plan

FROM clientes

LEFT JOIN membresias
ON clientes.id=membresias.cliente_id

LEFT JOIN planes_membresia
ON membresias.plan_id=planes_membresia.id

WHERE CONCAT('SF',TRIM(clientes.dni))='$codigo'

LIMIT 1");

    $datos = mysqli_fetch_assoc($buscar);
    

    if($datos){

    $cliente = $datos['id'];

}else{

    $cliente = 0;

}

    /* VALIDAR MEMBRESÍA */

    $validar = mysqli_query($conexion,

    "SELECT * FROM membresias

    WHERE cliente_id='$cliente'

    AND estado='Activa'");
    
/* VALIDAR SI YA INGRESÓ HOY */

$yaIngreso = mysqli_query($conexion,

"SELECT * FROM asistencias

WHERE cliente_id='$cliente'

AND fecha='$fecha'

LIMIT 1");
    if(mysqli_num_rows($validar)>0){

    if(mysqli_num_rows($yaIngreso)>0){
        $registro = mysqli_fetch_assoc($yaIngreso);

$horaIngreso = date("h:i A", strtotime($registro['hora']));
        $nombreCliente = $datos['nombre'];

$planCliente = $datos['plan'];

$foto = "../uploads/clientes/".$datos['foto'];

if(
empty($datos['foto']) ||
$datos['foto']=="avatar.png" ||
!file_exists($foto)
){

    $foto = "../img/avatar.png";

}
$mensaje = "

<div class='checkin-ok'>

<img src='$foto'>

<h2>👋 ¡Hola nuevamente!</h2>

<h1>$nombreCliente</h1>

<p>$planCliente</p>

<div class='info-checkin'>

<div>

⏰ Ya registraste tu ingreso

<br><br>

<b>$horaIngreso</b>

</div>

</div>

<span>

No es necesario registrar otra entrada hoy.

</span>

</div>

";
       
        // Aquí mostraremos el mensaje de "ya ingresó"

    }else{

        // Aquí continúa el código que ya tienes para guardar la asistencia
        $guardar = "INSERT INTO asistencias(

                    cliente_id,
                    fecha,
                    hora)

                    VALUES(

                    '$cliente',
                    '$fecha',
                    '$hora')";

        mysqli_query($conexion,$guardar);
        $fotoCliente = $datos['foto'];

if(empty($fotoCliente)){

    $fotoCliente = "../img/avatar.png";

}else{

    $fotoCliente = "../uploads/clientes/".$fotoCliente;

}
        $nombreCliente = $datos['nombre'];

$planCliente = $datos['plan'];
$fechaFin = $datos['fecha_fin'];

$dias = floor(

(strtotime($fechaFin)-time())

/86400

);

if($dias<0){

    $dias=0;

}
if(
    !empty($datos['foto']) &&
    file_exists("../uploads/clientes/".$datos['foto'])
){

    $foto = "../uploads/clientes/".$datos['foto'];

}else{

    $foto = "../img/avatar.png";

}

$mensaje = "

<div class='checkin-ok'>

<img src='$foto'>

<h2>¡Bienvenido!</h2>

<h1>$nombreCliente</h1>

<p>$planCliente</p>

<div class='info-checkin'>

<div>

📅 Vence

<br>

<b>$fechaFin</b>

</div>

<div>

⏳ Restan

<br>

<b>$dias días</b>

</div>

<div>

🟢 Estado

<br>

<b>Activa</b>

</div>

</div>

<span>

Ingreso registrado correctamente

</span>

</div>

";

   }

    }else{

       $mensaje = "

<div class='checkin-error'>

<i class='fa-solid fa-circle-xmark'></i>

<h2>Acceso denegado</h2>

<p>El cliente no posee una membresía activa.</p>

</div>

";

    }

}

/* CONSULTAR ASISTENCIAS */

$asistencias = mysqli_query($conexion,

"SELECT asistencias.*,

clientes.nombre,
clientes.foto

FROM asistencias

INNER JOIN clientes
ON asistencias.cliente_id=clientes.id

ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Check-In Gym</title>

<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/softfit-ui.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
   <?php include("../includes/sidebar.php"); ?>
    
<div class="main-content">

<div class="page-card">

<div class="page-header">

    <div>

        <h1>

            <i class="fa-solid fa-door-open"></i>

            Check-In Gym

        </h1>

        <p>

            Registro de ingreso de clientes al gimnasio.

        </p>

    </div>

</div>
<?php

$totalHoy = mysqli_num_rows(mysqli_query($conexion,

"SELECT * FROM asistencias
WHERE fecha=CURDATE()"));

$totalClientes = mysqli_num_rows(mysqli_query($conexion,

"SELECT * FROM clientes"));

$membresiasActivas = mysqli_num_rows(mysqli_query($conexion,

"SELECT * FROM membresias
WHERE estado='Activa'"));

?>

<div class="stats-grid">

<div class="stat-card">

<i class="fa-solid fa-right-to-bracket"></i>

<h3><?php echo $totalHoy; ?></h3>

<span>Ingresos Hoy</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-users"></i>

<h3><?php echo $totalClientes; ?></h3>

<span>Clientes</span>

</div>

<div class="stat-card">

<i class="fa-solid fa-id-card"></i>

<h3><?php echo $membresiasActivas; ?></h3>

<span>Membresías Activas</span>

</div>

</div>
<br>

<?php

if(isset($mensaje)){

    echo "<div id='mensajeCheckin'>$mensaje</div>";

}

?>

<h2 class="section-title">

<i class="fa-solid fa-barcode"></i>

Registrar ingreso

</h2>

<form method="POST" class="form-grid">

<div class="campo">

<label>

<i class="fa-solid fa-barcode"></i>

Código del Cliente

</label>

<input
type="text"
id="codigo"
name="codigo"
placeholder="SF12345678"
autocomplete="off"
required>

</div>

<div class="acciones-form">

<button
type="submit"
name="registrar">

<i class="fa-solid fa-right-to-bracket"></i>

Registrar Entrada

</button>

</div>

</form>
<br>

<div style="display:flex;justify-content:flex-end;">

<button
type="button"
id="btnClaseDiaria"
class="btn-primary">

<i class="fa-solid fa-calendar-day"></i>

Clase diaria

</button>

</div>


<br><br>

<div class="table-card">

<div class="table-header">

<div>

<h2>Historial de ingresos</h2>

<p>Últimos registros de asistencia.</p>

</div>

<div>

<input
type="text"
id="buscarAsistencia"
placeholder="Buscar cliente...">

</div>

</div>

<table class="tabla-clientes" id="tablaAsistencias">

<thead>

<tr>

<th>Cliente</th>

<th>Fecha</th>

<th>Hora</th>

</tr>

</thead>

<tbody>

<?php while($a = mysqli_fetch_assoc($asistencias)){ ?>

<tr>

<td>

<?php

$foto = "../uploads/clientes/".$a['foto'];

if(
empty($a['foto']) ||
$a['foto']=="avatar.png" ||
!file_exists($foto)
){

    $foto = "../img/avatar.png";

}

?>

<div class="cliente-checkin">

<img
src="<?php echo $foto; ?>"
class="foto-checkin">

<div>

<span class="nombre-checkin">

<?php echo $a['nombre']; ?>

</span>

</div>

</div>

</td>

<td>

<?php echo date("d/m/Y",strtotime($a['fecha'])); ?>

</td>

<td>

<?php echo date("h:i A",strtotime($a['hora'])); ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>
</div>
<div id="modalClaseDiaria" class="modal-gasto" style="display:none;">

    <div class="modal-gasto-contenido">

        <div class="modal-header">

            <div>

                <h2>
                    <i class="fa-solid fa-calendar-day"></i>
                    Venta de Clase Diaria
                </h2>

                <small>
                    Registrar pago de un cliente diario.
                </small>

            </div>

            <span id="cerrarClaseDiaria" class="cerrar-modal">
                &times;
            </span>

        </div>

        <form method="POST" id="formClaseDiaria">

            <div class="modal-body">

                <div class="input-icon">

                    <label>Nombre del cliente</label>

                    <i class="fa-solid fa-user"></i>

                    <input
                    type="text"
                    name="nombreCliente"
                    placeholder="Ingrese el nombre del cliente"
                    required>

                </div>

                <div class="gasto-grid">

                    <div class="input-icon">

                        <label>Tipo de clase</label>

                        <i class="fa-solid fa-dumbbell"></i>

                        <select name="tipoClase" id="tipoClase">

                            <option value="Diario" data-precio="8">
                                Diario - S/8
                            </option>

                            <option value="Diario + Duchas" data-precio="15">
                                Diario + Duchas - S/15
                            </option>

                        </select>

                    </div>

                    <div class="input-icon">

                        <label>Precio</label>

                        <i class="fa-solid fa-money-bill-wave"></i>

                        <input
                        type="number"
                        step="0.01"
                        id="precioClase"
                        name="precio"
                        value="8"
                        readonly>

                    </div>

                </div>

                <div class="input-icon">

                    <label>Forma de pago</label>

                    <i class="fa-solid fa-credit-card"></i>

                    <select name="formaPago">

                        <option>Efectivo</option>

                        <option>Yape</option>

                        <option>Plin</option>

                        <option>Transferencia</option>

                        <option>Tarjeta</option>

                    </select>

                </div>

            </div>

            <div class="modal-footer">

                <button
                type="button"
                class="btn-cancelar"
                id="cerrarClaseDiaria2">

                    Cancelar

                </button>

                <button
                type="submit"
                name="guardarClase"
                class="btn-guardar">

                    <i class="fa-solid fa-cash-register"></i>

                    Realizar pago

                </button>

            </div>

        </form>

    </div>

</div>
<script>

const buscarAsistencia = document.getElementById("buscarAsistencia");

buscarAsistencia.addEventListener("keyup", function(){

    let texto = this.value.toLowerCase();

    document.querySelectorAll("#tablaAsistencias tbody tr").forEach(fila=>{

        let contenido = fila.textContent.toLowerCase();

        fila.style.display = contenido.includes(texto)
            ? ""
            : "none";

    });

});

</script>
<script>

const codigo = document.getElementById("codigo");

if(codigo){

    codigo.focus();

}

const mensaje = document.getElementById("mensajeCheckin");

if(mensaje){

    setTimeout(()=>{

        mensaje.style.transition="all .4s";
        mensaje.style.opacity="0";

        setTimeout(()=>{

            mensaje.remove();

        },400);

    },20000);

}

if(codigo){

    codigo.value="";
    codigo.focus();

}


/*MODAL CLASE DIARIA*/

const btnClaseDiaria = document.getElementById("btnClaseDiaria");

const modalClaseDiaria = document.getElementById("modalClaseDiaria");

const cerrarClaseDiaria = document.getElementById("cerrarClaseDiaria");

const cerrarClaseDiaria2 = document.getElementById("cerrarClaseDiaria2");

btnClaseDiaria.onclick = function(){

    modalClaseDiaria.style.display="flex";

}

cerrarClaseDiaria.onclick = function(){

    modalClaseDiaria.style.display="none";

}

cerrarClaseDiaria2.onclick = function(){

    modalClaseDiaria.style.display="none";

}

const tipoClase=document.getElementById("tipoClase");
const precioClase=document.getElementById("precioClase");

tipoClase.addEventListener("change",function(){

    precioClase.value=this.options[this.selectedIndex].dataset.precio;

});


</script>
<?php

if(isset($_GET['toast'])){

    if($_GET['toast'] == 'clase_guardada'){

?>

<script>

Swal.fire({

    toast:true,

    position:'bottom-end',

    icon:'success',

    title:'Pago realizado correctamente',

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
</body>

</html>