<?php
/** @var mysqli $conexion */
session_start();

if($_SESSION['rol']!="Cliente"){

    header("Location: ../dashboard.php");

}

include("../../includes/conexion.php");

$usuario = $_SESSION['usuario'];

$cliente = mysqli_query($conexion,

"SELECT * FROM clientes
WHERE LOWER(nombre)=LOWER('$usuario')");

$datosCliente = mysqli_fetch_assoc($cliente);

$idCliente = $datosCliente['id'];

$compras = mysqli_query($conexion,

"SELECT *

FROM ventas

WHERE cliente_id='$idCliente'

ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Mis Compras</title>

<link rel="stylesheet"
href="../../css/style.css">

</head>

<body>
    <div class="sidebar">

<img src="../../img/logo1.png"
class="logo">
<div class="sidebar-user">

<div class="avatar-sidebar">

<?php echo strtoupper(substr($usuario,0,1)); ?>

</div>

<h3>

<?php echo $usuario; ?>

</h3>

<p>

Cliente

</p>

</div>

<h2></h2>

<ul>

<li>

<a href="index.php">

🏠 Inicio

</a>

</li>

<li>

<a href="mi_membresia.php">

🏋️ Mi Membresía

</a>

</li>
<li>
<a href="mi_rutina.php">
🏋️ Mi Rutina
</a>
</li>

<li>

<a href="mis_asistencias.php">

📅 Mis Asistencias

</a>

</li>

<li>

<a href="mis_compras.php">

🛒 Mis Compras

</a>

</li>
<li>

<a href="mi_progreso.php">

📈 Mi Progreso

</a>

</li>

<li>

<a href="../../logout.php">

🚪 Cerrar sesión

</a>

</li>

</ul>

</div>

<div class="main">

<h1>🛒 Mis Compras</h1>

<br>

<table border="1"
cellpadding="10"
width="100%">

<tr>

<th>Fecha</th>
<th>Total</th>
<th>Método</th>
<th>Ticket</th>

</tr>

<?php while($c = mysqli_fetch_assoc($compras)){ ?>

<tr>

<td>

<?php echo $c['fecha']; ?>

</td>

<td>

S/
<?php echo $c['total']; ?>

</td>

<td>

<?php echo $c['metodo_pago']; ?>

</td>

<td>

<a
href="../ticket.php?id=<?php echo $c['id']; ?>"
target="_blank">

🎫 Ver Ticket

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>