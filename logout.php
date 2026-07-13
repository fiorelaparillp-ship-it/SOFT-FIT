<?php
session_start();

session_unset();
session_destroy();

header("Location: /SOFT-FIT/login.php");
exit();
?>