<?php
/** @var mysqli $conexion */

$modulos = mysqli_query($conexion,"
SELECT DISTINCT modulo
FROM permisos
ORDER BY modulo
");

$roles = ["Administrador","Recepcionista"];
?>
<h2 class="section-title">

    <i class="fa-solid fa-user-shield"></i>

    Gestión de Permisos

</h2>

<p class="section-description">

    Controla qué módulos puede utilizar cada rol del sistema.

</p>
<table class="tabla-usuarios modern-table permisos-table">

<thead>

<tr>

<th>Módulo</th>

<?php foreach($roles as $rol){ ?>

<th class="rol-header">

<?php echo $rol; ?>

</th>
<?php } ?>

</tr>

</thead>

<tbody>

<?php while($modulo=mysqli_fetch_assoc($modulos)){ ?>

<tr>

<td>

<strong>

<?php echo ucfirst(str_replace("_"," ",$modulo['modulo'])); ?>

</strong>

</td>

<?php

foreach($roles as $rol){

$consulta = mysqli_query(

$conexion,

"SELECT *
FROM permisos
WHERE rol='$rol'
AND modulo='".$modulo['modulo']."'
LIMIT 1"

);

$permiso = mysqli_fetch_assoc($consulta);

?>

<td style="text-align:center;">

<input
type="checkbox"
class="checkPermiso permiso-check"
data-id="<?php echo $permiso['id']; ?>"
<?php if($permiso['permitido']) echo "checked"; ?>>
</td>

<?php } ?>

</tr>

<?php } ?>

</tbody>

</table>