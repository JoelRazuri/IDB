<?php
    require "funciones/conexion.php";
    require "funciones/funciones.php";

    $errors = array();
    
    if(!empty($_POST))
    {
        
        $email= $mysqli->real_escape_string($_POST['email']);

        if (!esEmail($email)){
            $errors[] = "Debe ingresar un correo electrónico valido."; 
        }
            
        if(existeEmail($email)){
            $user_id = getValor('id','correo',$email);     
            $nombre = getValor('nombre','correo',$email);    

            $token = generarTokenPass($user_id);

            $url = "http://".$_SERVER["SERVER_NAME"]."/ProyectoIDB/login/cambia_pass.php?user_id=".$user_id."&token=".$token;

            $asunto = "Recuperar contrasenia - IDB COMPANY";
            $cuerpo = "Estimado/a $nombre: <br /><br />Se ha solicitado un reinicio de contrasenia. Para restaurar la misma toque el siguiente link...<a href='$url'> Cambiar Contrasenia</a>";
            
            if(enviarEmail($email,$nombre,$asunto,$cuerpo)){
                echo "Hemos enviado un correo electrónico a la dirección $email para restablecer su contrasenia.<br/>";
                echo "<a href='index.php'> Iniciar Sesión</a>";
                exit;
            } else{
                $errors[]= "Error al enivar Email.";
            }
        } else{
            $errors[] = "No existe el correo electrónico en la base de datos.";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/recuperar_pass.css">
    <link rel="shortcut icon" href="img/img1.png" type="image/x-icon">
    <title>Recupera pass</title>
</head>
<body>
    <main class="content center">
    <section class="content-title center">
            <h1>Recuperar contraseña</h1>
        </section>
        <form class="content-form center" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off" >
            <label>
                Email 
                <input type="email" name="email" placeholder="email..">
            </label>
            <button type="submit">Enviar</button>
        </form> 
        <div>
            No tiene una cuenta! <a href="registrarse.php">Registrate aquí</a>
        </div>
        <?php echo mostrarErrores($errors); ?>
    </main>
</body>
</html> 

