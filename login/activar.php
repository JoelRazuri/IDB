<?php

    require 'funciones/conexion.php';
    require 'funciones/funciones.php';


    if (isset($_GET['id']) AND isset($_GET['val'])){

        $idUsuario = $_GET['id'];
        $token = $_GET['val'];

        $mensaje = validaToken($idUsuario,$token);

        echo $mensaje;
    }
?>