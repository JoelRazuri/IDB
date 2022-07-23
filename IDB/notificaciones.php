<?php
    session_start();    
    require "../login/funciones/conexion.php";
    require "../login/funciones/funciones.php";

    if (!isset($_SESSION['id_usuario'])){
        header("Location: ../login/index.php");
    }

    $idUsuario = $_SESSION['id_usuario'];


    $sql = "SELECT id, nombre FROM usuarios WHERE id='$idUsuario'";
    $result = $mysqli->query($sql);
    
    $row = $result->fetch_assoc();

    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/notificaciones.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="shortcut icon" href="img/img1.png" type="image/x-icon">
    <title>Notificaciones</title>
</head>
<body>
    <div class="container">
        <aside>
            <div class="top">
                    <div class="logo">
                        <img src="img/img1.png" alt="Logo IDB">
                        <h2>IDB <span class="primary">COMPANY</span></h2>
                    </div>
            </div>
            <div class="close" id="close-btn">
                <span class="material-icons-sharp">close</span>
            </div> 
            <div class="sidebar">
                <a href="home.php">
                    <span class="material-icons-sharp">pie_chart</span>
                    <h3>General</h3>
                </a>
                <a href="rendimiento.php">
                    <span class="material-icons-sharp">auto_graph</span>
                    <h3>Rendimientos</h3>
                </a>
                <a href="" class="active">
                    <span class="material-icons-sharp">notifications</span>
                    <h3>Notificaciones</h3>
                </a>
                <a href="caja.php">
                    <span class="material-icons-sharp">account_balance</span>
                    <h3>Caja </h3>
                </a>
                <a href="usuario.php">
                    <span class="material-icons-sharp">person</span>
                    <h3>Usuario</h3>
                </a>
                <a href="documentos.php">
                    <span class="material-icons-sharp">description</span>
                    <h3>Documentos</h3>
                </a>
                <a href="soporte.php">
                    <span class="material-icons-sharp">settings</span>
                    <h3>Soporte</h3>
                </a>
                <a href="../login/logout.php"">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Logout</h3>
                </a>
            </div>   
        </aside>
        <main>
            <h1>Notificaciones</h1>
            <div class="date">
                <input type="date">
            </div>
            <br><br>

            <div class="notificacionesbox">
                <h3 class="ultimas">Importante</h3>
                <div class="notificacionesinsidebox"><h3 class="textoinside">Retiro de $ procesado con exito.</h3></div>
            </div>

            <div class="insights">
                <div class="rendimiento">
                    <span class="material-icons-sharp">notifications</span>
                    <div class="middle">
                        <div class="lef">
                            <h1>Notificaciones Detalladas</h1>
                            <h1></h1>
                        </div>
                    </div>
                    <small class="text-muted">See all bellow</small>
                </div>
            </div>

            <div class="transacciones">
                <h2>Details</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Retorno / retiros</th>
                            <th>Mes</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>%</td>
                            <td></td>
                            <td>RVA</td>
                            <td class="succes">Confirm</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>%</td>
                            <td></td>
                            <td>RF</td>
                            <td class="succes">Confirm</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>%</td>
                            <td></td>
                            <td>RVA</td>
                            <td class="succes">Confirm</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>%</td>
                            <td></td>
                            <td>RF</td>
                            <td class="succes">Confirm</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                </table>
                <a href="#">Show All</a>
            </div>
        </main>
        <div class="right">
            <div class="top">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="theme-toggler">
                    <span class="material-icons-sharp active">light_mode</span>
                    <span class="material-icons-sharp">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p> Hey <?php echo utf8_decode($row['nombre']); ?></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="img/img1.png" alt="Logo IDB">
                    </div>
                </div>
            </div>
            
            <div class="recent-updates">
                <h2>Notificaciones</h2>
                <div class="updates">
                    <div class="update">
                        <div class="profile-photo">
                            <img src="img/img1.png" alt="Logo IDB">
                        </div>
                        <div class="message">
                            <p><b>Mike Travis</b> received his profit</p>
                            <small class="text-muted">2 Minutes ago</small>
                        </div>
                    </div>
                    <div class="update">
                        <div class="profile-photo">
                            <img src="img/img1.png" alt="Logo IDB">
                        </div>
                        <div class="message">
                            <p><b>Mike Travis</b> received his profit</p>
                            <small class="text-muted">2 Minutes ago</small>
                        </div>
                    </div>
                    <div class="update">
                        <div class="profile-photo">
                            <img src="img/img1.png" alt="Logo IDB">
                        </div>
                        <div class="message">
                            <p><b>Mike Travis</b> received his profit</p>
                            <small class="text-muted">2 Minutes ago</small>
                        </div>
                    </div>
                    
                </div>
            </div>
            

         <div class="sales-analytics">
            <h2>Depositos</h2>
            <div class="item rva">
                <div class="icon">
                   <span class="material-icons-sharp">paid</span>
                </div>
                <div class="right">
                    <div class="info">
                        <h3>RVA</h3>
                        <small class="text-muted">Last Month</small>
                    </div>
                    <h5 class="succes">$</h5>
                    <h3>0</h3>
                </div>
            </div> 
            <div class="item rf">
               <div class="icon">
                  <span class="material-icons-sharp">paid</span>
               </div>
               <div class="right">
                   <div class="info">
                       <h3>RF</h3>
                       <small class="text-muted">Last Month</small>
                   </div>
                   <h5 class="danger">$</h5>
                   <h3>0</h3>
               </div>
           </div> 
           <div class="item total">
               <div class="icon">
                  <span class="material-icons-sharp">paid</span>
               </div>
               <div class="right">
                   <div class="info">
                       <h3>TOTAL</h3>
                       <small class="text-muted">Last Month</small>
                   </div>
                   <h5 class="succes">$</h5>
                   <h3>0</h3>
               </div>
           </div> 
           <div class="item ver-mas">
               <div>
                   <span class="material-icons-sharp">add</span>
                    <h3>ver mas</h3>
               </div>
           </div>
        </div>
       </div>
   </div>

   <div class="downbar">
    <a href="home.php">
        <span class="material-icons-sharp">pie_chart</span>    
    </a>
    <a href="rendimiento.php">
        <span class="material-icons-sharp">auto_graph</span>   
    </a>
    <a href="notificaciones.php"  class="active">
        <span class="material-icons-sharp">notifications</span>        
    </a>
    <a href="caja.php">
        <span class="material-icons-sharp">account_balance</span>  
    </a>
    <a href="usuario.php">
        <span class="material-icons-sharp">person</span>    
    </a>
    <a href="documentos.php">
        <span class="material-icons-sharp">description</span>
    </a>
    <a href="soporte.php">
        <span class="material-icons-sharp">settings</span>
    </a>
  </div>

   <script src="js/func_tema.js"></script>
</body>
</html>