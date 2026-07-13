<div class="sidebar">

    <img src="../img/logo1.png"
     class="logo">

<div class="sidebar-user">

    <div class="avatar-admin">

        <?php echo strtoupper(substr($_SESSION['usuario'],0,1)); ?>

    </div>

   <h3>
  <?php echo $_SESSION['nombre'] ?? $_SESSION['usuario']; ?>
</h3>

    <span class="badge-admin">

        <?php echo strtoupper($_SESSION['rol']); ?>

    </span>
<br>
    <small class="user-status">

        ● En línea

    </small>

</div>

    <ul class="menu">

<li>

<a href="../loader.php?destino=pages/dashboard.php">

<i class="fa-solid fa-house"></i>

Dashboard

</a>

</li>

<li>
<a href="../loader.php?destino=pages/clientes.php">
<i class="fa-solid fa-users"></i>
 Clientes
</a>
</li>

<li>
<a href="../loader.php?destino=pages/membresias.php">
<i class="fa-solid fa-id-card"></i>
 Membresías
</a>
</li>

<li>
<a href="../loader.php?destino=pages/asignar_membresia.php">
<i class="fa-solid fa-user-check"></i>
Asignar Membresía
</a>
</li>

<li>
<a href="../loader.php?destino=pages/rutinas.php">
<i class="fa-solid fa-dumbbell"></i>
Rutinas
</a>
</li>

<li>
<a href="../loader.php?destino=pages/progreso.php">
<i class="fa-solid fa-chart-line"></i>
Progreso
</a>
</li>

<li>
<a href="../loader.php?destino=pages/checkin.php">
<i class="fa-solid fa-door-open"></i>
Check-In
</a>
</li>

<li>
<a href="../loader.php?destino=pages/productos.php">
<i class="fa-solid fa-bottle-water"></i>
Productos
</a>
</li>

<li>
<a href="../loader.php?destino=pages/inventario.php">
<i class="fa-solid fa-boxes-stacked"></i>
Inventario
</a>
</li>

<li>
<a href="../loader.php?destino=pages/pos.php">
<i class="fa-solid fa-cash-register"></i>
POS
</a>
</li>
<li>
<a href="../loader.php?destino=pages/caja_control.php">
<i class="fa-solid fa-sack-dollar"></i>
Caja
</a>
</li>
<li>
<a href="../loader.php?destino=pages/ventas.php">
<i class="fa-solid fa-cart-shopping"></i>
Ventas
</a>
</li>

<li>
<a href="../loader.php?destino=pages/reportes.php">
<i class="fa-solid fa-chart-column"></i>
Reportes
</a>
</li>

<li>
<a href="../loader.php?destino=pages/ajustes.php">
<i class="fa-solid fa-gear"></i>
Ajustes
</a>
</li>

<li>
<a href="#" onclick="confirmLogout()">
   
<i class="fa-solid fa-right-from-bracket"></i>
Cerrar sesión
</a>
</li>
</ul>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmLogout() {
    Swal.fire({
        title: "¿Cerrar sesión?",
        text: "Tu sesión se cerrará y tendrás que iniciar sesión nuevamente.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e74c3c",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sí, salir",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
           window.location.href = "/SOFT-FIT/logout.php";
        }
    });
}
</script>