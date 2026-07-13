<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("ajustes")){
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Ajustes</title>

<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/dashboard.css">
<link rel="stylesheet" href="../css/ajustes.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

<!-- Aquí construiremos todo -->
<div class="settings-layout">

    <!-- Panel Izquierdo -->

    <div class="settings-menu">

       <div class="settings-header">

    <h1>

        <i class="fa-solid fa-gear"></i>

        Ajustes

    </h1>
<br>
    <p>

        Configura y personaliza todos los módulos del sistema SOFT-FIT.

    </p>

</div>

        <div class="menu-item active"
     data-modulo="usuarios">

    <div>

        <h3>

            <i class="fa-solid fa-users"></i>

            Usuarios

        </h3>

        <span>Administra usuarios del sistema</span>

    </div>

    <i class="fa-solid fa-chevron-right"></i>

</div>

        <div class="menu-item"
             data-modulo="permisos">

            <div>

                <h3>

<i class="fa-solid fa-user-shield"></i>

Permisos

</h3>

                <span>Control de acceso</span>

            </div>

            <i class="fa-solid fa-chevron-right"></i>

        </div>

        <div class="menu-item"
             data-modulo="gimnasio">

            <div>

              <h3>

<i class="fa-solid fa-dumbbell"></i>

Gimnasio

</h3>

                <span>Información general</span>

            </div>

            <i class="fa-solid fa-chevron-right"></i>

        </div>

        <div class="menu-item"
             data-modulo="apariencia">

            <div>

                <h3>

<i class="fa-solid fa-palette"></i>

Apariencia

</h3>

                <span>Tema y colores</span>

            </div>

           <i class="fa-solid fa-chevron-right"></i>

        </div>

        <div class="menu-item"
             data-modulo="ventas">

            <div>

                <h3>

<i class="fa-solid fa-cart-shopping"></i>

Ventas

</h3>

                <span>Configuración de ventas</span>

            </div>

               <i class="fa-solid fa-chevron-right"></i>

        </div>

        

        <div class="menu-item"
             data-modulo="reportes">

            <div>

               <h3>

<i class="fa-solid fa-chart-column"></i>

Reportes

</h3>

                <span>Configuraciones</span>

            </div>

           <i class="fa-solid fa-chevron-right"></i>

        </div>

        <div class="menu-item"
             data-modulo="backup">

            <div>

               <h3>

<i class="fa-solid fa-database"></i>

Copias de Seguridad

</h3>

                <span>Respaldos automáticos</span>

            </div>

           <i class="fa-solid fa-chevron-right"></i>

        </div>

    </div>

    <!-- Panel Derecho -->

    <div class="settings-content" id="settingsContent">

        <div id="modulo-usuarios">

<?php include("modulos/usuarios.php"); ?>

</div>

<div id="modulo-permisos" style="display:none;">

<?php include("modulos/permisos.php"); ?>

</div>

    </div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/ajustes.js"></script>
<script src="../js/usuarios.js"></script>
<script src="../js/permisos.js"></script>
<script src="../js/toast.js"></script>

</body>

</html>