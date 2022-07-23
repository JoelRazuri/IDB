<?php
    require "funciones/conexion.php";
    require "funciones/funciones.php";

    $user_id = $mysqli->real_escape_string($_POST['user_id']);
    $token = $mysqli->real_escape_string($_POST['token']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $con_password = $mysqli->real_escape_string($_POST['con_password']);

    if (passIguales($password,$con_password)){

        $pass_hash = hashPassword($password);

        if (cambiaPassword($pass_hash,$user_id,$token)){
            // echo "Password modificado";
            // echo "<br> <a href='index.php'>Iniciar Sesion</a>";
        } else{
            echo "Error al modificar Password.";
        }
    } else {
        echo "Las contrasenias no coiciden.";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/guarda_pass.css">
    <link rel="shortcut icon" href="img/img1.png" type="image/x-icon">
    <title>Cambia Pass</title>
</head>
<body>
    <main class="content center">
        <h1 class="h1">Contraseña Modificada</h1>
        <!-- <button class="button" type="submit"></button> -->
        <a href="index.php" class="button">Iniciar sesion</a>
    </main>
</body>
</html> 