<?php
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\SMTP;
   use PHPMailer\PHPMailer\Exception;
    

    function esVacio($nombre,$user,$pass,$pass_con,$email)
    {

        if (strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1){

            return true;
        } else {
            return false;
        }
    }


    function esEmail($email)
    {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        } else{
            return false;
        }
    }


    function passIguales($pass,$con_pass)
    {

        if (strcmp($pass,$con_pass) != 0){
            return false;
        }else{
            return true;
        }
    }

    function minMax($min,$max,$valor)
    {

        if (strlen(trim($valor)) < $min){
            return true;
        } else if (strlen(trim($valor)) > $max){
            return true;
        } else{
            return false;
        }
    }

    function existeUsuario($usuario)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");
        $stmt->bind_param("s",$usuario);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows;
        $stmt->close();

        if ($num > 0){
            return true;
        } else{
            return false;
        }
    }

    function existeEmail($email)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows;
        $stmt->close();

        if ($num > 0){
            return true;
        } else{
            return false;
        }

    }

    function generarToken()
    {
        $gen = md5(uniqid(mt_rand(),false));
        return $gen;
    }
    
    
    function hashPassword($pass)
    {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        return $hash;
    }


    function registrarUsuario($usuario,$hash_pass,$nombre,$email,$activo,$token,$tipo_usuario)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("INSERT INTO usuarios (usuario, pass, nombre, correo, activacion, token, id_tipo) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssisi', $usuario,$hash_pass,$nombre,$email,$activo,$token,$tipo_usuario);
        
        if ($stmt->execute()){
            return $mysqli->insert_id;
        } else{
            return 0;
        }
    
    }
    
    
    function enviarEmail($email,$nombre,$asunto,$cuerpo)
    {
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php'; 
        require 'PHPMailer/src/Exception.php';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp-mail.outlook.com'; //smtp.live.com. hotmail
        $mail->Port = 587;

        $mail->Username = 'jrazuri98@hotmail.com';
        $mail->Password = '5y6jys';

        $mail->setFrom('jrazuri98@hotmail.com','IDB COMPANY');
        $mail->addAddress($email,$nombre);

        $mail->Subject = $asunto;
        $mail->Body = $cuerpo;
        $mail->IsHTML(true);

        if($mail->send()){
            return true;
        } else{
            return false;
        }
    }

    function mostrarErrores($errors)
    {
        if (count($errors) > 0){

            echo "<ul>";

            foreach($errors as $errors)
            {
                echo "<li>".$errors."</li>";
            }
            echo "</ul>";
        }

    }

    function validaToken($id,$token)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1");
        $stmt->bind_param("is",$id,$token);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;
        
        if($rows > 0){
            $stmt->bind_result($activacion);
            $stmt->fetch();

            if ($activacion == 1){
                $mensaje = "La cuenta ya ha sido activada.";
            } else{
                if (activarUsuario($id)){
                    $mensaje = "Cuenta activada.";
                } else{
                    $mensaje = "Error al activar cuenta.";
                }
            }
        } else{
            $mensaje = "No existe el registro para activar.";
        }
        return $mensaje;
    }

    
    function activarUsuario($id)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("UPDATE usuarios SET activacion=1 WHERE id = ?");
        $stmt->bind_param('s',$id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    
    
    function esVacioLogin($usuario,$password)
    {
        if (strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1){
            return true;
        } else{
            return false;
        }
    }

    
    function esActivo($usuario)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
        $stmt->bind_param('ss',$usuario,$$usuario);
        $stmt->execute();
        $stmt->bind_result($activacion);
        $stmt->fetch();

        if ($activacion == 1){
            return true;
        } else{
            return false;
        }
    }
    
    

    function lastSession($id)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("UPDATE usuarios SET last_session=NOW(),token_password='',password_request=1 WHERE id = ?");
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $stmt->close();
    }

    
    function login($usuario,$password)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT id, id_tipo, pass FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
        $stmt->bind_param("ss",$usuario,$usuario);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;

        $errors=" ";

        if ($rows > 0){
            
            if (esActivo($usuario)){

                $stmt->bind_result($id,$id_tipo,$pass);
                $stmt->fetch();

                $validaPassw = password_verify($password,$pass);
                
                if ($validaPassw){

                    lastSession($id);
                    $_SESSION['id_usuario'] = $id;
                    $_SESSION['id_tipo'] = $id_tipo;

                    header("location:../IDB/home.php");

                } else{
                    $errors = "La contrasenia es incorrecta.";
                }
            } else{
                $errors = "El usuario no está activo. Verifique su mail para activarlo.";
            }
        } else{
            if (strlen(trim($usuario)) != 0){
                $errors = "El nombre de usuario o correo electrónico no existen.";
            }
        }

        return $errors;
    }


    function getValor($campo,$campoWhere,$valor)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT $campo FROM usuarios WHERE $campoWhere = ? LIMIT 1");
        $stmt->bind_param('s',$valor);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows;

        if ($num > 0){
            $stmt->bind_result($_campo);
            $stmt->fetch();
            return $_campo;
        } else {

        }
    }   

    function generarTokenPass($user_id)
    {
        global $mysqli;

        $token = generarToken();

        $stmt = $mysqli->prepare("UPDATE usuarios SET token_password=?, password_request=1 WHERE id=?");
        $stmt->bind_param('ss',$token,$user_id);
        $stmt->execute();
        $stmt->close();

        return $token;
    }


    function verificaTokenPass($user_id,$token)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id=? AND token_password=? AND password_request=1 LIMIT 1");
        $stmt->bind_param('is',$user_id,$token);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows;

        if ($num > 0){
            $stmt->bind_result($activacion);
            $stmt->fetch();

            if ($activacion == 1){
                return true;
            } else{
                return false;
            }
        } else{

        }
    }


    function cambiaPassword($pass,$user_id,$token)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("UPDATE usuarios SET pass=?, token_password='',password_request=0 WHERE id=? AND token_password=?");
        $stmt->bind_param('sis',$pass,$user_id,$token);

        if ($stmt->execute()){
            return true;
        } else{
            return false;
        }
    }

    
?>