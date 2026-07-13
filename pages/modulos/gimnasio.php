<?php
/** @var mysqli $conexion */






$config = mysqli_fetch_assoc(
mysqli_query(
$conexion,
"SELECT * FROM configuracion LIMIT 1"
));


if(isset($_POST['guardar'])){

$nombre = $_POST['nombre_gimnasio'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];

$logo = $_FILES['logo']['name'];

if($logo != ""){

move_uploaded_file(
$_FILES['logo']['tmp_name'],
"../uploads/".$logo
);

}else{

$logo = $config['logo'];

}

mysqli_query(
$conexion,
"UPDATE configuracion SET

nombre_gimnasio='$nombre',
telefono='$telefono',
correo='$correo',
direccion='$direccion',
logo='$logo'

WHERE id=1"
);
header("Location: ajustes_gimnasio.php?toast=actualizado");
exit();


}
    

?>


   <div class="settings-header">

<h1>🏢 Información del Gimnasio</h1>

<p>

Configura la información principal de SOFT-FIT.

</p>

</div>


<div class="gym-card">

<form
method="POST"
enctype="multipart/form-data">

<div class="form-grid">

<div class="form-group">
<label>Nombre del gimnasio</label>
<input
type="text"
name="nombre_gimnasio"
value="<?php echo $config['nombre_gimnasio']; ?>">
</div>

<div class="form-group">
<label>Teléfono</label>
<input
type="text"
name="telefono"
value="<?php echo $config['telefono']; ?>">
</div>

<div class="form-group">
<label>Correo</label>
<input
type="email"
name="correo"
value="<?php echo $config['correo']; ?>">
</div>

<div class="form-group">
<label>Dirección</label>
<input
type="text"
name="direccion"
value="<?php echo $config['direccion']; ?>">
</div>

</div>

<div class="logo-section">

<?php if($config['logo']!=""){ ?>

<img

src="../uploads/<?php echo $config['logo']; ?>"

class="gym-logo">

<?php } ?>

<label class="btn-logo">

📷 Cambiar Logo

<input
type="file"
name="logo"
hidden>

</label>

</div>

<br>

<button
type="submit"
name="guardar"
class="btn-save">

💾 Guardar Cambios

</button>

</form>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if(isset($_GET['toast'])){ ?>

<script>

<?php if($_GET['toast'] == 'guardado'){ ?>
Swal.fire({
toast:true,
position:'bottom-end',
icon:'success',
title:'Configuración guardada',
background:'#1f2937',
color:'#fff',
showConfirmButton:false,
timer:2000,
timerProgressBar:true
});
<?php } ?>

<?php if($_GET['toast'] == 'actualizado'){ ?>
Swal.fire({
toast:true,
position:'bottom-end',
icon:'success',
title:'Configuración actualizada',
background:'#1f2937',
color:'#fff',
showConfirmButton:false,
timer:2000,
timerProgressBar:true
});
<?php } ?>

</script>

<?php } ?>
