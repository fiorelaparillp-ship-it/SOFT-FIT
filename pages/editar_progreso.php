<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");

$id = $_GET['id'];

$consulta = mysqli_query($conexion,
"SELECT * FROM progreso_cliente WHERE id='$id'");

$progreso = mysqli_fetch_assoc($consulta);

if(isset($_POST['guardar'])){

    $peso = $_POST['peso'];
    $altura = $_POST['altura'];

    $imc = round($peso / ($altura * $altura),2);

    $meta = $_POST['meta_peso'];
    $objetivo = $_POST['objetivo'];

    mysqli_query($conexion,"
    UPDATE progreso_cliente
    SET
        peso='$peso',
        altura='$altura',
        imc='$imc',
        meta_peso='$meta',
        objetivo='$objetivo'
    WHERE id='$id'
    ");

    header("Location: progreso.php?editado=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Editar Progreso</title>

<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/softfit-ui.css">

</head>

<body>

<div class="main-content">

<div class="page-card">

<h2>Editar Progreso</h2>

<form method="POST">

<label>Peso</label>

<input
type="number"
step="0.01"
name="peso"
value="<?php echo $progreso['peso']; ?>">

<label>Altura</label>

<input
type="number"
step="0.01"
name="altura"
value="<?php echo $progreso['altura']; ?>">

<label>Meta de peso</label>

<input
type="number"
step="0.01"
name="meta_peso"
value="<?php echo $progreso['meta_peso']; ?>">

<label>Objetivo</label>

<input
type="text"
name="objetivo"
value="<?php echo $progreso['objetivo']; ?>">

<br><br>

<button
class="btn-primary"
name="guardar">

Guardar Cambios

</button>

</form>

</div>

</div>

</body>

</html>