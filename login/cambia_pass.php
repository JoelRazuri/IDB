<?php

    require "funciones/conexion.php";
    require "funciones/funciones.php";

    if (empty($_GET['user_id'])){
        header('Location: index.php');
    }

    if (empty($_GET['token'])){
        header('Location: index.php');
        }
    
    $user_id = $mysqli->real_escape_string($_GET['user_id']);
    $token= $mysqli->real_escape_string($_GET['token']);
        
    if (!verificaTokenPass($user_id,$token)){
        echo "No se pudo verificar los datos.";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambia Pass</title>
    <link rel="stylesheet" href="css/cambia_pass.css">
    <link rel="shortcut icon" href="img/img1.png" type="image/x-icon">
</head>
<body>
    <main class="content center">
    <section class="content-title center">
            <h1>Nueva contraseña</h1>
        </section>
        <form class="content-form center" action="guarda_pass.php" method="POST" autocomplete="off">
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" id="token" name="token" value="<?php echo $token; ?>">
            <label>
                Nueva pass 
                <input type="" name="password" placeholder="pass..">
            </label>
            <label>
                Confirmar pass 
                <input type="" name="con_password" placeholder="confirmar pass..">
            </label>
            <button type="submit">Modificar</button>
        </form> 
    </main>
</body>
</html> 