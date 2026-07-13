<?php
/** @var mysqli $conexion */



$usuarios = mysqli_query(
$conexion,
"SELECT * FROM usuario
ORDER BY id DESC"
);

?>




<h2 class="section-title">

    <i class="fa-solid fa-users"></i>

    Gestión de Usuarios

</h2>

<p class="section-description">

    Administra los usuarios del sistema.

</p>

<div class="usuarios-topbar">

<div class="usuarios-actions">

<?php if(tienePermiso("usuarios")): ?>
<button
class="btn-producto"
id="btnNuevoUsuario">

<i class="fa-solid fa-user-plus"></i>

Nuevo Usuario

</button>
<?php endif; ?>

<input
type="text"
id="buscarUsuario"
class="search-input"
placeholder="Buscar usuario...">

</div>

</div>

<table class="tabla-usuarios modern-table usuarios-table">

<thead>

<tr>

<th>Usuario</th>

<th>Nombre</th>

<th>Rol</th>

<th>Estado</th>

<th>Registro</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

<?php

while($fila = mysqli_fetch_assoc($usuarios)){

?>

<tr id="fila-<?php echo $fila['id']; ?>">

<td><?php echo $fila['usuario']; ?></td>

<td>

<?php echo $fila['nombre']; ?>

</td>

<td>

<span class="rol-badge">

<?php echo $fila['rol']; ?>

</span>

</td>

<td>

<span id="estado-<?php echo $fila['id']; ?>" class="estado-badge
<?php echo $fila['estado']=="Activo" ? "activo" : "inactivo"; ?>">
<?php echo $fila['estado']; ?>
</span>

</td>

<td>

<?php

echo date(
"d/m/Y",
strtotime($fila['fecha_registro'])
);

?>

</td>
<td>

<?php if(tienePermiso("usuarios")): ?>
<a href="#" class="btn-mini editar" data-id="<?php echo $fila['id']; ?>">✏</a>

<a href="#" class="btn-mini estado"
data-id="<?php echo $fila['id']; ?>"
data-estado="<?php echo $fila['estado']; ?>">
🔒
</a>

<a href="#" class="btn-mini eliminar" data-id="<?php echo $fila['id']; ?>">🗑</a>
<?php endif; ?>

</td>
</tr>

<?php } ?>

</tbody>

</table>
<div class="modal-overlay" id="modalUsuario">

<div class="modal-box">

<div class="modal-header">

<h2 id="tituloModal">

Nuevo Usuario

</h2>

<button id="cerrarModal">

✖

</button>

</div>

<div class="modal-body">

<form id="formUsuario" method="POST">

<input
type="hidden"
name="id"
id="idUsuario">

<div class="form-group">

<label>Usuario</label>

<input
type="text"
name="usuario"
id="usuario">

</div>

<div class="form-group">

<label>Nombre completo</label>

<input
type="text"
name="nombre"
id="nombre">

</div>

<div class="form-group">

<label>Contraseña</label>

<input
type="password"
name="password"
id="password">

</div>

<div class="form-group">

<label>Rol</label>

<select
name="rol"
id="rol">

<option value="Administrador">

Administrador

</option>

<option value="Recepcionista">

Recepcionista

</option>

</select>

</div>

<div class="form-group">

<label>Estado</label>

<select
name="estado"
id="estado">

<option value="Activo">

Activo

</option>

<option value="Inactivo">

Inactivo

</option>

</select>

</div>

<br>

<button
class="btn-producto"
type="submit">

<i class="fa-solid fa-floppy-disk"></i>

Guardar Usuario

</button>

</form>

</div>

</div>

</div>
<script src="assets/js/usuarios.js"></script>