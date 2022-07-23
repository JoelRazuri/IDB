<?php

    $mysqli = new mysqli("localhost","root","","login");

    
    if (mysqli_connect_error()){
        echo "Conexión fallida : ", mysqli_connect_error();
        exit();
    }


?>