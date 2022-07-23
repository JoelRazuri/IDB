<?php
    session_start();    
    require "funciones/conexion.php";
    require "funciones/funciones.php";

    $errors = array();

    if (!empty($_POST)){

        $usuario = $mysqli->real_escape_string($_POST['usuario']);
        $password = $mysqli->real_escape_string($_POST['password']);

        if (esVacioLogin($usuario,$password)){
            $errors[] = "Debe llenar todos los campos";
        }

        $error = login($usuario,$password);

        if ($error != " "){
            $errors[] = $error;
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Inicio cuenta</title>
</head>
<body>
    <main class="content center">
        <section class="content-title center">
            <img class="logo" src="Diagrama en blanco_ Lucidchart - Google Chrome 23_05_2022 11_29_09 p. m..png" alt="">
            <h1>IDB Company</h1>
        </section>
        <section class="content-subtitle center">
            <h2>Ingresar</h2>
            <p>Usuario y clave</p>
        </section>
        <form class="content-form center" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                <label>USUARIO<input type="text" placeholder=" Usuario..." name="usuario" ></label>
                <label>CLAVE<input type="text" placeholder=" Clave..." name="password" ></label>
                <button type="submit">Iniciar Sesion</button>
        </form>
        <section class="content-actions">
            <p><a href="registrarse.php">Registrarse</a></p>
            <p><a href="recuperar_pass.php">Olvide mi clave</a></p>
        </section> 
        <?php echo mostrarErrores($errors);?>
    </main>
</body>
</html>
