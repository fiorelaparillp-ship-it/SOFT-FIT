<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("progreso")){
    header("Location: dashboard.php");
    exit();
}


include("../includes/conexion.php");

$clientes = mysqli_query($conexion,

"SELECT * FROM clientes");
if(isset($_POST['guardar'])){

    $id = $_POST['id'];

    $cliente_id = $_POST['cliente_id'];

    $peso = $_POST['peso'];

    $altura = $_POST['altura'];

    $imc = round($peso / ($altura * $altura),2);

    $objetivo = $_POST['objetivo'];

    $meta_peso = $_POST['meta_peso'];

    if($id==""){

        mysqli_query($conexion,"
        INSERT INTO progreso_cliente(

            cliente_id,
            peso,
            altura,
            imc,
            objetivo,
            meta_peso

        )VALUES(

            '$cliente_id',
            '$peso',
            '$altura',
            '$imc',
            '$objetivo',
            '$meta_peso'

        )");

        header("Location: progreso.php?ok=1");

        exit();

    }else{

        mysqli_query($conexion,"
        UPDATE progreso_cliente
        SET

        cliente_id='$cliente_id',
        peso='$peso',
        altura='$altura',
        imc='$imc',
        objetivo='$objetivo',
        meta_peso='$meta_peso'

        WHERE id='$id'
        ");

        header("Location: progreso.php?editado=1");

        exit();

    }

}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Progreso Clientes</title>

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

<h1 id="tituloFormulario">

<i class="fa-solid fa-chart-line"></i>

Registrar Progreso

</h1>
<p>

Registra y controla la evolución física de cada cliente.

</p>

</div>

</div>

<form action="" method="POST">
    <input
type="hidden"
name="id"
id="idProgreso">
<div class="form-row">

<div class="form-group">

<label>Cliente</label>

<select
name="cliente_id"
id="cliente_id"
required>

<option value="">Seleccione</option>

<?php

mysqli_data_seek($clientes,0);

while($c = mysqli_fetch_assoc($clientes)){

?>

<option value="<?php echo $c['id']; ?>">

<?php echo $c['nombre']; ?>

</option>

<?php } ?>

</select>

</div>



</div>


<div class="form-row">

    <div class="form-group">

        <label>Peso (kg)</label>

        <input
type="number"
step="0.01"
name="peso"
id="peso"
required>
    </div>

    <div class="form-group">

        <label>Altura (m)</label>

        <input
        type="number"
        step="0.01"
        name="altura"
        id="altura"
        required>

    </div>

    <div class="imc-card">

        <h4>
            <i class="fa-solid fa-chart-column"></i>
            IMC
        </h4>

        <h1 id="resultadoIMC">
            0.00
        </h1>

        <span id="estadoIMC">
            Esperando datos...
        </span>

    </div>

</div>
<br>
<div class="form-row">

    <div class="form-group">

        <label>Meta de Peso (kg)</label>

        <input
type="number"
step="0.01"
name="meta_peso"
id="meta_peso"
required>

    </div>

    <div class="form-group">

        <label>Objetivo</label>

        <input
type="text"
name="objetivo"
id="objetivo"
placeholder="Ej. Ganar masa muscular"
required>
    </div>

</div>

<br>

<button
class="btn-primary"
type="submit"
name="guardar"
id="btnGuardar">
<i class="fa-solid fa-floppy-disk"></i>

Guardar Progreso

</button>
<button
type="button"
class="btn-secondary"
id="btnCancelar"
style="display:none;">

<i class="fa-solid fa-xmark"></i>

Cancelar

</button>
</form>
<hr style="margin:40px 0; border:none; border-top:1px solid #eee;">



<?php

$consultaProgreso = mysqli_query($conexion,"
SELECT
progreso_cliente.*,
clientes.nombre
FROM progreso_cliente
INNER JOIN clientes
ON progreso_cliente.cliente_id = clientes.id
ORDER BY progreso_cliente.id DESC
");

if(!$consultaProgreso){

    die(mysqli_error($conexion));

}
?>



<div class="table-card">

<h2 class="section-title">

<i class="fa-solid fa-clock-rotate-left"></i>

Historial de Progreso

</h2>

<table>

<thead>

<tr>

<th>Cliente</th>
<th>Peso</th>
<th>Altura</th>
<th>IMC</th>
<th>Meta</th>
<th>Objetivo</th>
<th>Fecha</th>
<th>Acciones</th>

</tr>

</thead>

<tbody>

<?php while($p=mysqli_fetch_assoc($consultaProgreso)){ ?>

<tr>

<td><?php echo $p['nombre']; ?></td>

<td><?php echo $p['peso']; ?> kg</td>

<td><?php echo $p['altura']; ?> m</td>

<td><?php echo $p['imc']; ?></td>

<td><?php echo $p['meta_peso']; ?> kg</td>

<td style="max-width:220px; word-break:break-word;">

<?php echo $p['objetivo']; ?>

</td>
<td style="white-space:nowrap;">

<?php
echo date(
'd/m/Y',
strtotime($p['fecha'])
);
?>

</td>
<td>

<a
href="#"
class="btn-accion editar"
data-id="<?php echo $p['id']; ?>"

data-cliente="<?php echo $p['cliente_id']; ?>"

data-peso="<?php echo $p['peso']; ?>"

data-altura="<?php echo $p['altura']; ?>"

data-meta="<?php echo $p['meta_peso']; ?>"

data-objetivo="<?php echo htmlspecialchars($p['objetivo']); ?>">

<i class="fa-solid fa-pen-to-square"></i>

</a>

<a
href="#"
class="btn-accion eliminar"
data-id="<?php echo $p['id']; ?>">

<i class="fa-solid fa-trash"></i>

</a>
</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<script>

const peso =
document.getElementById("peso");

const altura =
document.getElementById("altura");

const resultado =
document.getElementById("resultadoIMC");

function calcularIMC(){

let p = parseFloat(peso.value);

let a = parseFloat(altura.value);

if(!isNaN(p) && !isNaN(a) && a > 0){

let imc = p / (a * a);

imc = imc.toFixed(2);

resultado.innerHTML = imc;

let estado =
document.getElementById("estadoIMC");
estado.style.fontWeight = "700";
if(imc < 18.5){

estado.innerHTML =
"🔵 Bajo peso";

estado.style.color =
"#3b82f6";

}
else if(imc < 25){

estado.innerHTML =
"🟢 Peso normal";

estado.style.color =
"#22c55e";

}
else if(imc < 30){

estado.innerHTML =
"🟡 Sobrepeso";

estado.style.color =
"#eab308";

}
else{

estado.innerHTML =
"🔴 Obesidad";

estado.style.color =
"#ef4444";

}

}

}

peso.addEventListener(
"input",
calcularIMC
);

altura.addEventListener(
"input",
calcularIMC
);

</script>
<?php if(isset($_GET['ok'])){ ?>

<script>

Swal.fire({

    toast:true,
    position:'bottom-end',
    icon:'success',
    title:'Progreso registrado correctamente',
    background:'#1f2937',
    color:'#fff',
    showConfirmButton:false,
    timer:2200,
    timerProgressBar:true

});

</script>

<?php } ?>

<?php if(isset($_GET['editado'])){ ?>

<script>

Swal.fire({

    toast:true,
    position:'bottom-end',
    icon:'success',
    title:'Progreso actualizado correctamente',
    background:'#1f2937',
    color:'#fff',
    showConfirmButton:false,
    timer:2200,
    timerProgressBar:true

});

</script>

<?php } ?>
<script>

document.querySelectorAll(".editar").forEach(function(boton){

    boton.addEventListener("click",function(e){

        e.preventDefault();

        document.getElementById("idProgreso").value =
        this.dataset.id;

        document.getElementById("cliente_id").value =
        this.dataset.cliente;

        document.getElementById("peso").value =
        this.dataset.peso;

        document.getElementById("altura").value =
        this.dataset.altura;

        document.getElementById("meta_peso").value =
        this.dataset.meta;

        document.getElementById("objetivo").value =
        this.dataset.objetivo;

        calcularIMC();

        document.getElementById("tituloFormulario").innerHTML =
        '<i class="fa-solid fa-pen-to-square"></i> Editar Progreso';

        document.getElementById("btnGuardar").innerHTML =
        '<i class="fa-solid fa-floppy-disk"></i> Actualizar Progreso';

        document.getElementById("btnCancelar").style.display =
        "inline-block";

        window.scrollTo({

            top:0,

            behavior:"smooth"

        });

    });

});

document.getElementById("btnCancelar").addEventListener("click",function(){

    document.querySelector("form").reset();

    document.getElementById("idProgreso").value="";

    document.getElementById("resultadoIMC").innerHTML="0.00";

    document.getElementById("estadoIMC").innerHTML="Esperando datos...";

    document.getElementById("estadoIMC").style.color="#6b7280";

    document.getElementById("tituloFormulario").innerHTML =
    '<i class="fa-solid fa-chart-line"></i> Registrar Progreso';

    document.getElementById("btnGuardar").innerHTML =
    '<i class="fa-solid fa-floppy-disk"></i> Guardar Progreso';

    this.style.display="none";

});

</script>
<script>

document.querySelectorAll(".eliminar").forEach(function(boton){

    boton.addEventListener("click",function(e){

        e.preventDefault();

        let id = this.dataset.id;

        Swal.fire({

            title:"¿Eliminar progreso?",

            text:"Esta acción no podrá deshacerse.",

            icon:"warning",

            showCancelButton:true,

            confirmButtonColor:"#dc2626",

            cancelButtonColor:"#6b7280",

            confirmButtonText:"Sí, eliminar",

            cancelButtonText:"Cancelar"

        }).then((result)=>{

            if(result.isConfirmed){

                window.location =
                "eliminar_progreso.php?id="+id;

            }

        });

    });

});

</script>
<?php if(isset($_GET['eliminado'])){ ?>

<script>

Swal.fire({

    toast:true,

    position:'bottom-end',

    icon:'success',

    title:'Progreso eliminado correctamente',

    background:'#1f2937',

    color:'#fff',

    showConfirmButton:false,

    timer:2200,

    timerProgressBar:true

});

</script>

<?php } ?>
</body>

</html>