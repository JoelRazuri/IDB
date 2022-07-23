<?php
    require 'funciones/conexion.php';
    require 'funciones/funciones.php';

    $errors = array();

    if(!empty($_POST)){
    
        $nombre= $mysqli->real_escape_string($_POST['nombre']);
        $usuario= $mysqli->real_escape_string($_POST['usuario']);
        $password= $mysqli->real_escape_string($_POST['password']);
        $con_password= $mysqli->real_escape_string($_POST['con_password']);
        $email= $mysqli->real_escape_string($_POST['email']);

        $activo = 0;
        $tipo_usuario = 2;


        if (esVacio($nombre,$usuario,$password,$con_password,$email)){
            $errors[] = "Debe llenar todos los campos.";
        }

        if (!esEmail($email)){

            $errors[] = "El correo electrónico no es válido.";
        }
        if(!passIguales($password,$con_password)){
            $errors[] = "Las contraseñas no coinciden.";
        }

        if (existeUsuario($usuario)){
            $errors[] = "El nombre de usuario $usuario ya existe.";
        }

        if (existeEmail($email)){
            $errors[] = "El correo electrónico $email ya existe."; 
        }


        if(count($errors) == 0){

           $pass_hash = hashPassword($password);
           $token = generarToken(); 

           $registro = registrarUsuario($usuario,$pass_hash,$nombre,$email,$activo,$token,$tipo_usuario);
        
            if ($registro  > 0){
                echo "Se ha registrado correctamente";
                
                $url = "http://".$_SERVER["SERVER_NAME"]."/ProyectoIDB/login/activar.php?id=".$registro. "&val=".$token;

                $asunto = "Activar Cuenta - IDB COMPANY";
                $cuerpo = "Estimado/a $nombre: <br /><br />Para continuar con el proceso de registro de su cuenta acceda a este link... <a href='$url'> Activar Cuenta</a>";

                if(enviarEmail($email,$nombre,$asunto,$cuerpo)){

                    echo "Para terminar el proceso de registro siga las instrucciones que le hemos envidado a la dirección de correo electrónico: $email";
                    echo"<br><a href='index.php'>Iniciar Sesion</a>";
                    exit;
                } else{
                    $errors[] = "Error al enviar el mail.";
                }
            } else{
                $errors[]= "Erorr al registrar.";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/registrarse.css">
    <title>Registrarse</title>
</head>
<body>
    <main class="content center">
        <section class="content-title center">
            <h1>IDB Company</h1>
        </section>
        <form class="content-form center" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                <label>Nombre<input type="text" name="nombre" required></label>
                <label>Usuario<input type="text" name="usuario" required></label>
                <label>Contraseña<input type="text" name="password" required></label>
                <label>Confirmar contraseña<input type="text" name="con_password"  required></label>
                <label>Email<input type="text" name="email" required></label>
                <button type="submit">Registrarse</button>
        </form>
        <section class="content-actions">
            <p><a href="index.php">Iniciar sesión</a></p>
            <p><a href="recuperar_pass.php">Olvidé mi clave</a></p>
        </section>
        <?php echo mostrarErrores($errors);?> 
    </main>
</body>
</html>
