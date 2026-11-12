
<?php
session_start();

// Si no hay sesión iniciada, ir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Si ya inició sesión, entrar al sistema
header("Location: pages/dashboard.php");
exit();
?>
