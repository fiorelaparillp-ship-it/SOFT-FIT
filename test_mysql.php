<?php

$conexion = mysqli_connect(
    "localhost",
    "root",
    "",
    "softfit"
);

if($conexion){
    echo "CONEXION OK";
}else{
    echo mysqli_connect_error();
}