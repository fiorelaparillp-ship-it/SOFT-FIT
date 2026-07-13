<?php
/** @var mysqli $conexion */
session_start();

include("../../includes/conexion.php");

include("../../includes/permisos.php");

if(!tienePermiso("usuarios")){
    exit("Sin permisos");
}
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$usuario = trim($_POST['usuario']);
$nombre = trim($_POST['nombre']);
$password = trim($_POST['password']);
$rol = trim($_POST['rol']);
$estado = trim($_POST['estado']);

if(
$usuario=="" ||
$nombre==""
){

    echo "error";
    exit();

}

$password = password_hash(
$password,
PASSWORD_DEFAULT
);

if($id==0){

    $buscar=mysqli_query(
    $conexion,
    "SELECT id
     FROM usuario
     WHERE usuario='$usuario'"
    );

}else{

    $buscar=mysqli_query(
    $conexion,
    "SELECT id
     FROM usuario
     WHERE usuario='$usuario'
     AND id!='$id'"
    );

}

if(mysqli_num_rows($buscar)>0){

    echo "existe";
    exit();

}

if($id==0){

    mysqli_query(

        $conexion,

        "INSERT INTO usuario(

        usuario,
        password,
        nombre,
        rol,
        estado

        )

        VALUES(

        '$usuario',
        '$password',
        '$nombre',
        '$rol',
        '$estado'

        )"

    );

}else{

    if($password!=""){

        $password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        mysqli_query(

            $conexion,

            "UPDATE usuario SET

            usuario='$usuario',
            password='$password',
            nombre='$nombre',
            rol='$rol',
            estado='$estado'

            WHERE id='$id'"

        );

    }else{

        mysqli_query(

            $conexion,

            "UPDATE usuario SET

            usuario='$usuario',
            nombre='$nombre',
            rol='$rol',
            estado='$estado'

            WHERE id='$id'"

        );

    }

}

echo "ok";