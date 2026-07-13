<?php
/** @var mysqli $conexion */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/conexion.php");
include("../includes/permisos.php");

if(!tienePermiso("pos")){
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>POS SOFT-FIT</title>

 
<link rel="stylesheet" href="../css/dashboard.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>

body{

    margin:0;

    background:#f4f6fb;

    font-family:'Segoe UI',sans-serif;

}

.main-content{

    padding:90px 30px 30px 30px;

}
/* CONTENEDOR */

.pos{

    display:flex;

    gap:30px;
    width:100%;

    align-items:flex-start;

}
/* PANEL IZQUIERDO */

.carrito{

    width:360px;

    background:#ffffff;

    border-radius:18px;

    padding:25px;

    color:#111827;

    box-shadow:0 10px 25px rgba(0,0,0,.08);

    overflow:auto;
flex-shrink:0;
 margin-top:50px;

}
.carrito h2{

    margin-top:0;

    color:#7b2cbf;

    font-size:28px;

}
/* ITEMS */

.item{

    background:#f8fafc;

    border:1px solid #e5e7eb;

    border-radius:14px;

    padding:14px;

    margin-bottom:14px;

}

.item-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.item-top strong{

    color:#111827;

    font-size:15px;

    font-weight:600;

}
.item-top span{

    color:#7b2cbf;

    font-weight:bold;

    font-size:15px;

}
.cantidad{

    display:flex;

    align-items:center;

    gap:12px;

    margin-top:12px;
    justify-content:flex-start;

}

.cantidad span{

    min-width:24px;

    text-align:center;

    font-weight:700;

    color:#111827;

}

.cantidad button{

    width:34px;

    height:34px;

    border:none;

    border-radius:10px;

    background:#7b2cbf;

    color:#fff;

    cursor:pointer;

    display:flex;

    align-items:center;

    justify-content:center;

    transition:.25s;

    font-size:13px;

}

.cantidad button:hover{

    transform:translateY(-2px);

    background:#8f3ef5;

}
.btn-remove{

    margin-left:auto;

    background:#ef4444 !important;

}

.btn-remove:hover{

    background:#dc2626 !important;

}

/* TOTAL */

.total{
    margin-top:20px;
    font-size:28px;
    font-weight:bold;
}

/* METODO PAGO */

select{

    width:100%;

    padding:14px 16px;

    margin-top:18px;

    border:1px solid #d1d5db;

    border-radius:12px;

    background:#fff;

    color:#111827;

    font-size:15px;

    outline:none;

    transition:.25s;

}

select:focus{

    border-color:#7b2cbf;

    box-shadow:0 0 0 4px rgba(123,44,191,.15);

}

/* BOTON */

.btn-pagar{

    width:100%;

    padding:15px;

    margin-top:18px;

    border:none;

    border-radius:12px;

    background:linear-gradient(135deg,#7b2cbf,#9d4edd);

    color:#fff;

    font-size:16px;

    font-weight:600;

    cursor:pointer;

    transition:.25s;

    box-shadow:0 8px 20px rgba(123,44,191,.30);

}

.btn-pagar:hover{

    transform:translateY(-2px);

    box-shadow:0 14px 28px rgba(123,44,191,.40);

}

/* PANEL DERECHO */

.productos{

    flex:1;

    background:#ffffff;

    border-radius:18px;

    padding:20px;

    box-shadow:0 10px 25px rgba(0,0,0,.08);

    
    overflow-y:auto;
 margin-top:20px;
}
/* BUSCADOR */

.buscador-box .buscador-pos{

    width:100%;

    height:52px;

    padding:0 18px 0 50px;

    background:#ffffff !important;

    color:#111827 !important;

    border:1px solid #dbe2ea !important;

    border-radius:14px;

    box-sizing:border-box;

}

.buscador-box .buscador-pos::placeholder{

    color:#9ca3af !important;

}
.buscador-pos:focus{

    border-color:#7b2cbf;

    box-shadow:0 0 0 4px rgba(123,44,191,.12);

}


.buscador-box .icono-busqueda{

    position:absolute;

    top:50%;

    left:18px;

    transform:translateY(-50%);

    color:#9ca3af;

    font-size:15px;

    pointer-events:none;

}

/* GRID PRODUCTOS */
.grid{

    display:grid;

    grid-template-columns:repeat(auto-fill,minmax(160px,1fr));

    gap:22px;

    align-items:start;

}
/* TARJETA */

.card{

    background:#ffffff;

    border-radius:14px;

    overflow:hidden;

    cursor:pointer;

    transition:.25s;

    border:1px solid #ececec;
max-width:170px;
    box-shadow:0 8px 18px rgba(0,0,0,.06);
margin:auto;
}

.card:hover{

    transform:translateY(-6px);

    box-shadow:0 18px 30px rgba(0,0,0,.12);

}

.card img{

    width:100%;

    height:125px;

    object-fit:cover;

}

.info{
    padding:10px;
}

.info h3{

    font-size:15px;

    font-weight:600;

    color:#111827;

    margin-bottom:6px;

}
.info p{

    font-size:15px;

    font-weight:bold;

    color:#7b2cbf;

    margin:0;

}
.btn-dashboard{

    position:fixed;

    top:25px;

    left:25px;

    width:58px;

    height:58px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:linear-gradient(135deg,#7b2cbf,#9d4edd);

    color:#fff;

    font-size:24px;

    text-decoration:none;

    border-radius:18px;

    box-shadow:0 12px 28px rgba(123,44,191,.35);

    transition:.25s;

    z-index:9999;

}

.btn-dashboard:hover{

    transform:translateY(-3px) scale(1.05);

    box-shadow:0 18px 35px rgba(123,44,191,.45);

}
/* ==========================
   POS SIN SIDEBAR
========================== */

.pos-page{

    margin-left:0 !important;

    width:100% !important;

    max-width:100% !important;

    padding:20px !important;

}

.btn-ticket{

    background:linear-gradient(135deg,#2563eb,#3b82f6);

}

.btn-ticket:hover{

    box-shadow:0 14px 28px rgba(59,130,246,.35);

}

.btn-nueva{

    background:linear-gradient(135deg,#059669,#10b981);

}

.btn-nueva:hover{

    box-shadow:0 14px 28px rgba(16,185,129,.35);

}
.card{

    position:relative;

}

.badge-agotado{

    position:absolute;

    top:10px;

    right:10px;

    background:#ef4444;

    color:#fff;

    padding:5px 10px;

    border-radius:20px;

    font-size:11px;

    font-weight:700;

    letter-spacing:.5px;

}

.card.agotado{

    opacity:.55;

    cursor:not-allowed;

}

.card.agotado:hover{

    transform:none;

    box-shadow:0 8px 18px rgba(0,0,0,.06);

}
.info-footer{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-top:12px;

}

.precio-pos{

    font-size:16px;

    font-weight:700;

    color:#7b2cbf;

}

.stock-pos{

    background:#f3f4f6;

    color:#374151;

    padding:5px 10px;

    border-radius:20px;

    font-size:13px;

    font-weight:600;

    display:flex;

    align-items:center;

    gap:6px;

}

.stock-pos i{

    color:#7b2cbf;

}
</style>

</head>

<body>



<div class="main-content pos-page">
<a href="dashboard.php"
   class="btn-dashboard"
   title="Volver al Dashboard">

    <i class="fa-solid fa-house"></i>

</a>
    
<div class="pos">
    <!-- CARRITO -->

    <div class="carrito">

        <h2>🛒 Carrito</h2>

        <div id="listaCarrito"></div>

        <div class="total">

            Total: S/ <span id="total">0</span>

        </div>
        <select id="cliente">

<option value="">Seleccionar Cliente</option>

<?php

$clientes = mysqli_query(
$conexion,
"SELECT * FROM clientes ORDER BY nombre ASC"
);

while($c = mysqli_fetch_assoc($clientes)){

?>

<option value="<?php echo $c['id']; ?>">

<?php echo $c['nombre']; ?>

</option>

<?php } ?>

</select>

        <!-- METODO PAGO -->

        <select id="metodoPago">

            <option value="">Método de pago</option>

            <option>Efectivo</option>

            <option>Yape</option>

            <option>Tarjeta</option>

            <option>Transferencia</option>

        </select>

        <button class="btn-pagar btn-cobrar">

    <i class="fa-solid fa-credit-card"></i>

    Cobrar

</button>
        <div id="accionesVenta"
style="display:none; margin-top:15px;">

<button
onclick="verTicket()"
class="btn-pagar btn-ticket">

<i class="fa-solid fa-receipt"></i>

Ver Ticket

</button>

<button
onclick="nuevaVenta()"
class="btn-pagar btn-nueva"
style="margin-top:10px;">

<i class="fa-solid fa-cart-plus"></i>

Nueva Venta

</button>

</div>

    </div>

    <!-- PRODUCTOS -->

    <div class="productos">
<div class="buscador-box">

    

    <input
        type="text"
        id="buscarProducto"
        class="buscador-pos"
        placeholder="Buscar productos...">

</div>

        <div class="grid">

            <?php

            $consulta = "

SELECT
productos.*,
categorias.nombre AS categoria

FROM productos

LEFT JOIN categorias
ON categorias.id = productos.categoria_id

";

            $resultado = mysqli_query($conexion,$consulta);

            while($p = mysqli_fetch_assoc($resultado)){

            ?>
<div
class="card producto-card <?php echo ($p['stock'] == 0) ? 'agotado' : ''; ?>"
data-id="<?php echo $p['id']; ?>"

data-nombre="<?php echo strtolower($p['nombre']); ?>"

onclick="<?php

if($p['stock'] > 0){

?>

agregarProducto(
<?php echo $p['id']; ?>,
'<?php echo $p['nombre']; ?>',
<?php echo $p['precio']; ?>
)

<?php

}

?>"
>



                <img src="../uploads/<?php echo $p['imagen']; ?>">
<?php if($p['stock'] == 0){ ?>

<div class="badge-agotado">

AGOTADO

</div>

<?php } ?>
            <div class="info">

    <h3>

        <?php echo $p['nombre']; ?>

    </h3>

    <div class="info-footer">

        <span class="precio-pos">

            S/ <?php echo number_format($p['precio'],2); ?>

        </span>

        <span class="stock-pos">

            <i class="fa-solid fa-cubes-stacked"></i>

            <?php echo $p['stock']; ?>

        </span>

    </div>

</div>

            </div>

            <?php } ?>

        </div>

    </div>

</div> <!-- pos -->

</div> <!-- main-content -->

<script>
let carrito = [];
let total = 0;
let ultimoTicket = "";
function agregarProducto(id,nombre,precio){

    let existe = carrito.find(p => p.id === id);

    if(existe){

        existe.cantidad++;

    }else{

        carrito.push({
            id:id,
            nombre:nombre,
            precio:precio,
            cantidad:1
        });

    }

    renderCarrito();

}

function renderCarrito(){

    let html = "";

    total = 0;

    carrito.forEach((p,index)=>{

        let subtotal = p.precio * p.cantidad;

        total += subtotal;

        html += `

        <div class="item">

            <div class="item-top">

                <strong>${p.nombre}</strong>

                <span>S/ ${subtotal}</span>

            </div>

            <div class="cantidad">

    <button onclick="disminuir(${index})">
        <i class="fa-solid fa-minus"></i>
    </button>

    <span>${p.cantidad}</span>

    <button onclick="aumentar(${index})">
        <i class="fa-solid fa-plus"></i>
    </button>

    <button class="btn-remove"
            onclick="eliminarProducto(${index})">

        <i class="fa-solid fa-trash"></i>

    </button>

</div>

        </div>

        `;

    });

    document.getElementById("listaCarrito").innerHTML = html;

    document.getElementById("total").innerText = total.toFixed(2);

}

function aumentar(index){

    carrito[index].cantidad++;

    renderCarrito();

}

function disminuir(index){

    carrito[index].cantidad--;

    if(carrito[index].cantidad <= 0){

        carrito.splice(index,1);

    }

    renderCarrito();

}
function eliminarProducto(index){

    carrito.splice(index,1);

    renderCarrito();

}
function verTicket(){

    if(ultimoTicket != ""){

        window.open(
            "ticket.php?id=" + ultimoTicket,
            "_blank"
        );

    }else{

        alert("No hay ticket generado");

    }

}
function nuevaVenta(){

    carrito = [];

    total = 0;

    ultimoTicket = "";

    document.getElementById(
    "listaCarrito"
    ).innerHTML = "";

    document.getElementById(
    "total"
    ).innerText = "0.00";

    document.getElementById(
    "cliente"
    ).value = "";

    document.getElementById(
    "metodoPago"
    ).value = "";

    document.getElementById(
    "accionesVenta"
    ).style.display = "none";

}
document.querySelector(".btn-pagar")
.addEventListener("click",()=>{

    let metodo_pago =
    document.getElementById("metodoPago").value;
    let cliente_id =
document.getElementById("cliente").value;

   if(carrito.length == 0){

    Swal.fire({
        icon:'warning',
        title:'Carrito vacío',
        text:'Agrega al menos un producto.',
        confirmButtonColor:'#7b2cbf'
    });

    return;

}
   if(cliente_id == ""){

    Swal.fire({
        icon:'warning',
        title:'Cliente requerido',
        text:'Selecciona un cliente.',
        confirmButtonColor:'#7b2cbf'
    });

    return;

}

    if(metodo_pago == ""){

    Swal.fire({
        icon:'warning',
        title:'Método de pago',
        text:'Selecciona un método de pago.',
        confirmButtonColor:'#7b2cbf'
    });

    return;

}

   fetch("guardar_venta.php",{

    method:"POST",

    headers:{
        "Content-Type":"application/json"
    },

    body:JSON.stringify({

        carrito:carrito,
        metodo_pago:metodo_pago,
        cliente_id:cliente_id,
        total:total

    })

})

.then(response => response.text())

.then(data => {

    let idVenta = data.trim();

    ultimoTicket = idVenta;

    document.getElementById(
    "accionesVenta"
    ).style.display = "block";
// Actualizar el stock de las tarjetas
carrito.forEach(function(producto){

    let tarjeta = document.querySelector(
        '.producto-card[onclick*="' + producto.id + '"]'
    );

    if(tarjeta){

        let stock = tarjeta.querySelector(".stock-pos");

        let actual = parseInt(stock.textContent);

        let nuevo = actual - producto.cantidad;

        stock.innerHTML =
        '<i class="fa-solid fa-cubes-stacked"></i> ' + nuevo;

        if(nuevo <= 0){

            tarjeta.classList.add("agotado");

            tarjeta.innerHTML +=
            '<div class="badge-agotado">AGOTADO</div>';

            tarjeta.onclick = null;

        }

    }

});
   Swal.fire({

    toast:true,

    position:'bottom-end',

    icon:'success',

    title:'¡Venta completada!',

    text:'Ahora puedes imprimir el ticket o iniciar una nueva venta.',

    background:'#1f2937',

    color:'#fff',

    showConfirmButton:false,

    timer:3000,

    timerProgressBar:true

});

    carrito = [];

    renderCarrito();

});
});

const buscador = document.getElementById("buscarProducto");

buscador.addEventListener("keyup", function(){

    let texto = this.value.toLowerCase();

    let productos = document.querySelectorAll(".producto-card");

    productos.forEach(producto=>{

        let nombre = producto.dataset.nombre;

        if(nombre.includes(texto)){

            producto.style.display="block";

        }else{

            producto.style.display="none";

        }

    });

});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>