<?php
session_start();
include("includes/conexion.php");

$error = "";

if(isset($_POST['ingresar'])){

    $usuario = trim($_POST['usuario']);
    
    $password = trim($_POST['password']);

$consulta = "SELECT id, usuario, nombre, rol, estado, password 
             FROM usuario 
             WHERE usuario='$usuario'";
$resultado = mysqli_query($conexion, $consulta);

if($resultado && mysqli_num_rows($resultado) > 0){

    $fila = mysqli_fetch_assoc($resultado);

    if(password_verify($password, $fila['password'])){

        if($fila['estado'] != "Activo"){

            $error = "Este usuario está inactivo.";
            $shake = true;

        }else{

            $_SESSION['id'] = $fila['id'];
$_SESSION['usuario'] = $fila['usuario'];
$_SESSION['nombre'] = $fila['nombre']; // 👈 ESTA LÍNEA FALTABA
$_SESSION['rol'] = $fila['rol'];
            header("Location: loader.php");
            exit();

        }

    }else{

        $error = "Usuario o contraseña incorrectos";
        $shake = true;

    }

}else{

    $error = "Usuario o contraseña incorrectos";
    $shake = true;

}
 }

?>
<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login SOFT-FIT</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="css/global.css">
<style>

body{
    margin:0;
    font-family:Arial;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    position:relative;
    overflow:hidden;
}

body::before{
    content:"";
    position:fixed;
    inset:0;
    background: rgba(0,0,0,0.65);
    z-index:0;
}
.login{
    position: relative;
    z-index: 2;

    width: 450px;
    padding: 45px;

    background: rgba(18,18,22,.82);

    backdrop-filter: blur(22px);
    -webkit-backdrop-filter: blur(22px);

    border-radius: 24px;

    border:1px solid rgba(255,255,255,.08);

    box-shadow:
        0 20px 60px rgba(0,0,0,.60),
        0 0 40px rgba(123,44,191,.12);

    text-align:center;

    transition:.35s;
}
.logo{

    width:300px;

    margin-bottom:10px;

    filter:drop-shadow(0 0 15px rgba(157,78,221,.45));

    animation:logoFloat 3s ease-in-out infinite;

}
input{
    width:100%;
    padding:14px;
    margin-top:15px;
    border:none;
    border-radius:10px;
    background:#2a2a2a;
    color:white;
    font-size:15px;
    box-sizing:border-box;
}

button{
    width:100%;
    padding:14px;
    margin-top:20px;
    border:none;
    border-radius:10px;
    background:#7b2cbf;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#9d4edd;
}

.error{
    margin-top:15px;
    color:#ff4d6d;
}
input{
    width:100%;
    padding:14px 15px;
    margin-top:15px;

    border:none;
    outline:none;

    border-radius:12px;

    background: rgba(255,255,255,0.08);
    color:white;

    font-size:14px;

    border:1px solid rgba(255,255,255,0.1);
    transition:0.3s;
}

input:focus{
    border:1px solid #7b2cbf;
    box-shadow: 0 0 10px #7b2cbf;
}
button{
    width:100%;
    padding:14px;
    margin-top:20px;

    border:none;
    border-radius:12px;

    background: linear-gradient(90deg,#7b2cbf,#9d4edd);
    color:white;

    font-size:16px;
    cursor:pointer;

    box-shadow: 0 0 15px rgba(123,44,191,0.4);
    transition:0.3s;
}

button:hover{
    transform: scale(1.03);
    box-shadow: 0 0 25px rgba(123,44,191,0.7);
}
.error{
    margin-top:15px;
    color:#ff4d6d;
    font-size:14px;
}
.bg-video{
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -1;
    filter: brightness(0.75) contrast(1.1);
}
.overlay{
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: linear-gradient(
        135deg,
        rgba(123,44,191,0.5),
        rgba(0,0,0,0.75)
    );
    z-index: -2;
}
.input-group{
    position:relative;
    margin-top:18px;
}

.input-group input{
    width:100%;
    height:55px;
    padding:0 50px;
    border-radius:12px;
    border:1px solid rgba(255,255,255,.08);
    background:rgba(255,255,255,.05);
    color:white;
    font-size:15px;
    box-sizing:border-box;
}

.input-group i:first-child{
    position:absolute;
    left:18px;
    top:50%;
    transform:translateY(-50%);
    color:#9d4edd;
    font-size:16px;
}

.toggle-password{
    position:absolute;
    right:18px;
    top:50%;
    transform:translateY(-50%);
    color:#999;
    cursor:pointer;
    transition:.3s;
}

.toggle-password:hover{
    color:white;
}
.login h2{

    color:#fff;

    margin-top:20px;

    margin-bottom:8px;

    font-size:28px;

    font-weight:700;

}

.login p{

    color:#9a9a9a;

    margin-bottom:35px;

    font-size:15px;

}
.login{

    animation:login .8s ease;
}

@keyframes login{

    from{

        opacity:0;

        transform:translateY(40px);

    }

    to{

        opacity:1;

        transform:translateY(0);

    }

}
button:hover{

    transform:translateY(-2px);

    box-shadow:

    0 10px 35px rgba(157,78,221,.45);

}
form{

    margin-top:30px;

}
/* ===== TITULO ===== */

.login h1{

    margin:20px 0 8px;

    color:#ffffff;

    font-size:30px;

    font-weight:700;

    letter-spacing:.5px;

}

/* ===== SUBTITULO ===== */

.subtitulo{

    color:#bdbdbd;

    font-size:15px;

    line-height:22px;

    margin-bottom:30px;

}


@keyframes logoFloat{

    0%{

        transform:translateY(0px);

    }

    50%{

        transform:translateY(-8px);

    }

    100%{

        transform:translateY(0px);

    }

}
.login{

    animation:showLogin .8s ease;

}
@keyframes showLogin{

    from{

        opacity:0;

        transform:translateY(40px);

    }

    to{

        opacity:1;

        transform:translateY(0);

    }

}
button:disabled{

    opacity:.85;

    cursor:not-allowed;

}
/* ========================= */
/* NOTIFICACIÓN FLOTANTE */
/* ========================= */

.toast{

    position: fixed;

    top: 20px;

    right: 20px;

    width: 360px;

    padding: 18px 20px;

    display: flex;

    align-items: center;

    gap: 15px;

    background: rgba(30,30,35,.95);

    backdrop-filter: blur(15px);

    border: 1px solid rgba(255,255,255,.08);

    border-left: 5px solid #ff4d6d;

    border-radius: 15px;

    color: white;

    box-shadow:
        0 20px 40px rgba(0,0,0,.45);

    z-index: 999999;

    animation: toastEntrada .45s ease;
}

.toast i{

    font-size:22px;

    color:#ff4d6d;

}

.toast span{

    font-size:15px;

}

@keyframes toastEntrada{

    from{

        opacity:0;

        transform:translateX(120px);

    }

    to{

        opacity:1;

        transform:translateX(0);

    }

}
/*============================*/
/* MENSAJE DE ERROR LOGIN */
/*============================*/

.login-error{

    width:100%;

    margin:0 auto 25px;

    padding:14px 18px;

    border-radius:14px;

    display:flex;

    align-items:center;

    gap:12px;

    background:rgba(255,77,109,.12);

    border:1px solid rgba(255,77,109,.35);

    color:#ff7b93;

    font-size:14px;

    animation:errorShow .45s ease;

}

.login-error i{

    font-size:18px;

}

@keyframes errorShow{

    0%{

        opacity:0;

        transform:translateY(-10px);

    }

    100%{

        opacity:1;

        transform:translateY(0);

    }

}
.shake{

    animation:shake .45s;

}

@keyframes shake{

    0%{transform:translateX(0);}
    20%{transform:translateX(-8px);}
    40%{transform:translateX(8px);}
    60%{transform:translateX(-8px);}
    80%{transform:translateX(8px);}
    100%{transform:translateX(0);}

}
</style>

</head>

<body>
<video autoplay muted loop playsinline class="bg-video">
    <source src="img/gym-bg.mp4" type="video/mp4"></video>
<div class="login <?php if(isset($shake)) echo 'shake'; ?>">

<img src="img/logo1.png" class="logo">
<h1>Bienvenido</h1>

<p class="subtitulo">
    Inicia sesión para acceder al sistema
</p>

<?php if(!empty($error)){ ?>

<div class="login-error">

    <i class="fa-solid fa-circle-exclamation"></i>

    <span><?php echo $error; ?></span>

</div>

<?php } ?>
<form method="POST" autocomplete="off">

<div class="input-group">
    <i class="fa-solid fa-user"></i>
    <input
type="text"
name="usuario"
placeholder="Usuario"
autocomplete="off"
required>
</div>

<div class="input-group">
    <i class="fa-solid fa-lock"></i>
   <input
type="password"
name="password"
id="password"
placeholder="Contraseña"
autocomplete="new-password"
required>
</div>
<button type="submit" name="ingresar" id="btnLogin">

    <span id="textoBoton">
        Ingresar
    </span>

</button>

</form>



</div>

<script>
    
const togglePassword = document.getElementById("togglePassword");
const password = document.getElementById("password");

togglePassword.addEventListener("click", function(){

    const tipo = password.getAttribute("type") === "password"
        ? "text"
        : "password";

    password.setAttribute("type", tipo);

    this.classList.toggle("fa-eye");
    this.classList.toggle("fa-eye-slash");

});
</script>

<script>

const toast = document.querySelector(".toast");

if(toast){

    setTimeout(()=>{

        toast.style.transition="0.4s";
        toast.style.opacity="0";
        toast.style.transform="translateX(120px)";

        setTimeout(()=>{

            toast.remove();

        },400);

    },3000);

}

</script>
<script>

window.addEventListener("load",function(){

    document.querySelector("input[name='usuario']").value = "";
    document.querySelector("input[name='password']").value = "";

});

</script>
</body>
</html>