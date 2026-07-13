<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){

    header("Location: ../login.php");

}

include("../includes/conexion.php");

/* VENDER */

if(isset($_POST['vender'])){

    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    $metodo_pago = $_POST['metodo_pago'];

    $consulta = "SELECT * FROM productos
                 WHERE id='$producto_id'";

    $resultado = mysqli_query($conexion,$consulta);

    $producto = mysqli_fetch_assoc($resultado);

    $precio = $producto['precio'];

    $stockActual = $producto['stock'];

    $total = $precio * $cantidad;

    /* VALIDAR STOCK */

    if($cantidad <= $stockActual){

        /* GUARDAR VENTA */

        $guardarVenta = "INSERT INTO ventas(producto_id,cantidad,total,metodo_pago)
VALUES('$producto_id','$cantidad','$total','$metodo_pago')";

        mysqli_query($conexion,$guardarVenta);

        /* DESCONTAR STOCK */

        $nuevoStock = $stockActual - $cantidad;

        $actualizarStock = "UPDATE productos
                            SET stock='$nuevoStock'
                            WHERE id='$producto_id'";

        mysqli_query($conexion,$actualizarStock);

        $mensaje = "Venta realizada correctamente";

    }else{

        $mensaje = "Stock insuficiente";

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Caja</title>

    <link rel="stylesheet" href="../css/dashboard.css">

</head>

<body>

<div class="sidebar">

    <img src="../img/logo.png"
         class="logo">

    <h2>SOFT-FIT</h2>

    <ul class="menu">

        <li>
            <a href="dashboard.php">Dashboard</a>
        </li>

        <li>
            <a href="clientes.php">Clientes</a>
        </li>

        <li>
            <a href="membresias.php">Membresías</a>
        </li>

        <li>
            <a href="productos.php">Productos</a>
        </li>

        <li>
            <a href="caja.php">Caja</a>
        </li>

    </ul>

</div>

<div class="main-content">

    <h1>Caja / POS</h1>

    <br><br>

    <?php

    if(isset($mensaje)){

        echo "<h3>$mensaje</h3>";

    }

    ?>

    <form method="POST">

        <select name="producto_id" required>

            <option value="">Seleccione producto</option>

            <?php

            $productos = "SELECT * FROM productos";

            $resultadoProductos = mysqli_query($conexion,$productos);

            while($fila = mysqli_fetch_assoc($resultadoProductos)){

            ?>

            <option value="<?php echo $fila['id']; ?>">

                <?php echo $fila['nombre']; ?>

            </option>

            <?php } ?>

        </select>

        <br><br>

        <input type="number"
               name="cantidad"
               placeholder="Cantidad"
               required>
               <br><br>

<select name="metodo_pago" required>

    <option value="">Método de Pago</option>

    <option value="Efectivo">Efectivo</option>

    <option value="Yape">Yape</option>

    <option value="Tarjeta">Tarjeta</option>

    <option value="Transferencia">Transferencia</option>

</select>

        <br><br>

        <button type="submit"
                name="vender">

            Realizar Venta

        </button>

    </form>

    <br><br>

    <h2>Productos Disponibles</h2>

    <br>

    <table border="1" cellpadding="10">

        <tr>

            <th>Imagen</th>
            <th>Producto</th>
            <th>Stock</th>
            <th>Precio</th>

        </tr>

        <?php

        $consultaProductos = "SELECT * FROM productos";

        $resultadoConsulta = mysqli_query($conexion,$consultaProductos);

        while($producto = mysqli_fetch_assoc($resultadoConsulta)){

        ?>

        <tr>

            <td>

                <img src="../uploads/<?php echo $producto['imagen']; ?>"
                     width="80">

            </td>

            <td><?php echo $producto['nombre']; ?></td>

            <td><?php echo $producto['stock']; ?></td>

            <td>S/ <?php echo $producto['precio']; ?></td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>

</html>
