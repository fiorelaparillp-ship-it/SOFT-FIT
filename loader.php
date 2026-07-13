<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Cargando SOFT-FIT...</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    overflow:hidden;

    font-family:Arial,sans-serif;

    background:url("img/loading-bg.jpeg") center center/cover no-repeat;

    position:relative;

}
body::before{

    content:"";

    position:absolute;

    inset:0;

    background:rgba(0,0,0,.70);

    backdrop-filter:blur(4px);

}

.loader{

    position:relative;

    z-index:2;

    text-align:center;

}

.logo{

    width:400px;

    animation:logo 2s infinite ease-in-out;

    filter:

        drop-shadow(0 0 20px #8f3dff)

        drop-shadow(0 0 50px rgba(143,61,255,.4));

}


p{

    color:#b5b5b5;

    margin-top:10px;

    font-size:15px;

}

.dots{

    display:flex;

    justify-content:center;

    gap:10px;

    margin-top:30px;

}

.dots span{

    width:12px;

    height:12px;

    border-radius:50%;

    background:#9d4edd;

    animation:bounce 1s infinite;

}

.dots span:nth-child(2){

    animation-delay:.2s;

}

.dots span:nth-child(3){

    animation-delay:.4s;

}

@keyframes logo{

    0%{

        transform:scale(.9);

    }

    50%{

        transform:scale(1);

    }

    100%{

        transform:scale(.9);

    }

}

@keyframes bounce{

    0%,100%{

        transform:translateY(0);

    }

    50%{

        transform:translateY(-12px);

    }

}

</style>

</head>

<body>

<div class="loader">

<img src="img/logo1.png" class="logo">



<p>Preparando sistema...</p>

<div class="dots">

<span></span>

<span></span>

<span></span>

</div>

</div>

<?php

$destino = isset($_GET['destino'])
    ? $_GET['destino']
    : 'pages/dashboard.php';

?>

<script>

setTimeout(function(){

    window.location.href = "<?php echo $destino; ?>";

},1500);

</script>

</body>
</html>