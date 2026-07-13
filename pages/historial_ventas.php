<?php
/** @var mysqli $conexion */
include("../includes/conexion.php");

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Historial Ventas</title>

<link rel="stylesheet"
      href="../css/dashboard.css">

<style>

body{
    background:#0f0f0f;
    color:white;
    font-family:Arial;
    margin:0;
    padding:20px;
}

h1{
    margin-bottom:20px;
}

.card-total{
    background:#1f1f1f;
    padding:20px;
    border-radius:15px;
    margin-bottom:20px;
    font-size:25px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:#1a1a1a;
}

th{
    background:#7b2cbf;
    padding:15px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #333;
}

tr:hover{
    background:#222;
}

</style>

</head>

<body>

<h1>📊 Historial de Ventas</h1>

<?php

/* TOTAL GANADO */

$totalHoy = "SELECT SUM(total) AS total
             FROM ventas";

$resultadoTotal = mysqli_query($conexion,$totalHoy);

$filaTotal = mysqli_fetch_assoc($resultadoTotal);

?>

<div class="card-total">

💰 Total Ganado:
S/ <?php echo number_format($filaTotal['total'],2); ?>

</div>

<table>

<tr>

    <th>ID</th>
    <th>Total</th>
    <th>Método Pago</th>
    <th>Fecha</th>
    <th>Ticket</th>

</tr>

<?php

$consulta = "SELECT * FROM ventas
             ORDER BY id DESC";

$resultado = mysqli_query($conexion,$consulta);

while($v = mysqli_fetch_assoc($resultado)){

?>

<tr>

    <td><?php echo $v['id']; ?></td>

    <td>
        S/ <?php echo number_format($v['total'],2); ?>
    </td>

    <td><?php echo $v['metodo_pago']; ?></td>

    <td><?php echo $v['fecha']; ?></td>

    <td>

        <a href="ticket.php?id=<?php echo $v['id']; ?>">

            🧾 Ticket

        </a>

    </td>

</tr>

<?php } ?>

</table>

</body>

</html>