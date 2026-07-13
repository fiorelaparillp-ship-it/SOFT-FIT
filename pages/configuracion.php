<?php
session_start();

if($_SESSION['rol'] != "Admin"){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Ajustes</title>

<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/dashboard.css">

</head>

<body>

<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

<div class="settings-header">

<h1>⚙ Ajustes</h1>
<br>
<p>
Configura y personaliza tu sistema SoftFit
</p>

</div>

<div class="settings-grid">

<a href="ajustes_usuarios.php" class="setting-item">

<div class="setting-icon">👤</div>

<div class="setting-info">

<h3>Usuarios</h3>

<p>
Administra usuarios y roles del sistema
</p>

</div>

<span class="setting-arrow">›</span>

</a>

<a href="ajustes_permisos.php" class="setting-item">

<div class="setting-icon">🛡️</div>

<div class="setting-info">

<h3>Permisos</h3>

<p>
Gestiona permisos por rol
</p>

</div>

<span class="setting-arrow">›</span>

</a>

<a href="ajustes_gimnasio.php" class="setting-item">

<div class="setting-icon">🏢</div>

<div class="setting-info">

<h3>Gimnasio</h3>

<p>
Información general del gimnasio
</p>

</div>

<span class="setting-arrow">›</span>

</a>

<a href="ajustes_apariencia.php" class="setting-item">

<div class="setting-icon">🎨</div>

<div class="setting-info">

<h3>Apariencia</h3>

<p>
Tema oscuro y claro
</p>

</div>

<span class="setting-arrow">›</span>

</a>

<a href="ajustes_ventas.php" class="setting-item">

<div class="setting-icon">💰</div>

<div class="setting-info">

<h3>Ventas</h3>

<p>
Configuraciones de ventas
</p>

</div>

<span class="setting-arrow">›</span>

</a>

<a href="ajustes_membresias.php" class="setting-item">

<div class="setting-icon">🏋️</div>

<div class="setting-info">

<h3>Membresías</h3>

<p>
Planes y configuraciones
</p>

</div>

<span class="setting-arrow">›</span>

</a>

<a href="ajustes_reportes.php" class="setting-item">

<div class="setting-icon">📊</div>

<div class="setting-info">

<h3>Reportes</h3>

<p>
Opciones de reportes
</p>

</div>

<span class="setting-arrow">›</span>

</a>

<a href="ajustes_backup.php" class="setting-item">

<div class="setting-icon">☁️</div>

<div class="setting-info">

<h3>Copias de Seguridad</h3>

<p>
Respaldo del sistema
</p>

</div>

<span class="setting-arrow">›</span>

</a>

</div>

</div>

</body>
</html>