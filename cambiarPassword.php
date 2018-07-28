<?php
    session_start();

    if (!isset($_SESSION['userId'])) {
        header("Location: login.php");
        exit;
    }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Adecco - Asociados & Candidatos</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="lockscreen-content">
      <div class="logo">
        <h1>Adecco</h1>
      </div>
      <div class="lock-box">
        <img class="rounded-circle user-image" src="<?php echo $_SESSION['userImagen'] ?>">
        <h4 class="text-center user-name"><?php print $_SESSION['userNombre'] ?></h4>
        <p class="text-center text-muted">  </p>
        <form class="unlock-form" method="post">
          
          <div class="form-group">
            <label class="control-label">CONTRASEÑA ACTUAL</label>
            <input class="form-control" type="password" placeholder="Contraseña actual" id="password" name="password" autofocus>
          </div>
            <div class="form-group">
            <label class="control-label">NUEVA CONTRASEÑA</label>
            <input class="form-control" type="password" placeholder="Nueva contraseña" id ="newPassword"  name ="newPassword" autofocus>
          </div>
            <div class="form-group">
            <label class="control-label">REPETIR NUEVA CONTRASEÑA</label>
            <input class="form-control" type="password" placeholder="Repetir nueva contraseña" id="newPassword2" name="newPassword2" autofocus>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit" name="submit"><i class="fa fa-unlock fa-lg"></i>CAMBIAR</button>
          </div>
        </form>
        <p><a href="logout.php?logout">No sos <?php print $_SESSION['userNombre'] ?> ? Entrá acá.</a></p>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="js/sweetalert2.all.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="https://unpkg.com/promise-polyfill@7.1.0/dist/promise.min.js"></script>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
  </body>
</html>



<?php
session_start();

$client_id = 'asociadoscandidatos';
$client_secret = 'SrHDWvpDT2vLPIVgQ6axrkIOgYPr36hHqnnvow9uQCBUWCbz5330lP8k5pu6uNCr';
    
if (isset($_POST['submit'])) {

    require_once 'podio-php/PodioAPI.php';

    //App Usuarios
    $appUser_id = '21057475';
    $appUser_token = '67c2660d1f334543ab4f3601b14c6c6b';
    Podio::setup($client_id, $client_secret);
    Podio::authenticate_with_app($appUser_id, $appUser_token);
    
    $logincheck = PodioItem::filter($appUser_id, [
        'filters' => [
            // replace 123456 with field ID for your field with email type
            'title' => $_SESSION['userEmail'], 
            'contrasena' => $_POST['password']
                
        ]
    ]);
     IF($logincheck -> filtered > 0)
     {
        if($_POST['newPassword'] != $_POST['newPassword2']){
            echo '<script language="javascript">';
            echo 'swal("Error!","Las contraseñas no coinciden!.","error")';
            echo '</script>';
        }else{
            //Modifico datos del usuario
            PodioItem::update($_SESSION['userId'], array('fields' => array(
                "contrasena" => $_POST['newPassword']
            )));
            
            echo '<script language="javascript">';
            echo ' window.location.href = "news.php?cambiarPassword=1" ; ';
            echo '</script>';            
        }
     }else{
           echo '<script language="javascript">';
           echo 'swal("Error!","La contraseña actual es incorrecta.","error")';
           echo '</script>';
     }
   
    
    
       
}
?>