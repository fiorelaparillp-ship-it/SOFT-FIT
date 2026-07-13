<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

function tienePermiso($modulo){

    global $conexion;

    // El administrador siempre tiene acceso
    if($_SESSION['rol'] == "Administrador"){
        return true;
    }

    $rol = $_SESSION['rol'];

    $consulta = mysqli_query(

        $conexion,

        "SELECT permitido
         FROM permisos
         WHERE rol='$rol'
         AND modulo='$modulo'
         LIMIT 1"

    );

    if(mysqli_num_rows($consulta)==0){

        return false;

    }

    $fila = mysqli_fetch_assoc($consulta);

    return ($fila['permitido']==1);

}