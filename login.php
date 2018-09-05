<!DOCTYPE html>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.1/animate.css">
    <title>Login - Adecco Asociados & Candidatos </title>
  </head>
  <body>

    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
          <p></p>

      </div>
      <div class="login-box">
        <form class="login-form" method="post">
          <img src="https://www.adecco.com.ar/wp-content/uploads/2016/09/logo.png" alt="Adecco Argentina" class="loginlogoadecco">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>LOG IN</h3>


         <?php if (isset($errMSG)) { ?>
                <div class="form-group">
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                    </div>
                </div>
         <?php } ?>


          <div class="form-group">
            <label class="control-label">USUARIO</label>
            <input id="email" name="email" class="form-control" type="email" placeholder="Email" required autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input id="password"  name="password" class="form-control" type="password" placeholder="Password" required>
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label>
                  <input type="checkbox"><span class="label-text">Recordarme</span>
                </label>
              </div>
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Olvide mi Contraseña</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit" name="login"><i class="fa fa-sign-in fa-lg fa-fw"></i>LOG IN</button>
          </div>



        </form >
        <form class="forget-form" method="post">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Olvide mi Contraseña</h3>
          <div class="form-group">
            <label class="control-label">EMAIL</label>
            <input class="form-control" type="email" id="email" name="email" placeholder="Email">
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit" name="recuperarPassword"><i class="fa fa-unlock fa-lg fa-fw"></i>RECUPERAR</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Volver al Login</a></p>
          </div>
        </form>
      </div>
    </section>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <!-- Essential javascripts for application to work-->
    <script src="js/sweetalert2.all.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="https://unpkg.com/promise-polyfill@7.1.0/dist/promise.min.js"></script>


    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>

    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>

<?php
$lifetime=time()+60*60*24*30;
session_set_cookie_params($lifetime, '/', NULL); 

 if(!empty($_POST["recordarme"])) {
     setcookie("email",$_POST["email"],time()+60*60*24*30, '/');
     setcookie("password",$_POST["password"],time()+60*60*24*30, '/');
  } 
  else 
  {
    setcookie("email","");
     setcookie("password","");
  }
session_start();
// if session is set direct to index
if (isset($_SESSION['userId'])) {
    header("Location: news.php");
    exit;
}

$client_id = 'asociadoscandidatos';
$client_secret = 'SrHDWvpDT2vLPIVgQ6axrkIOgYPr36hHqnnvow9uQCBUWCbz5330lP8k5pu6uNCr';
require_once 'podio-php/PodioAPI.php';


if (isset($_POST['login'])) {


    //App Usuarios
    $appUser_id = '21057475';
    $appUser_token = '67c2660d1f334543ab4f3601b14c6c6b';
    Podio::setup($client_id, $client_secret);
    Podio::authenticate_with_app($appUser_id, $appUser_token);

    // Output the title of each item

    $logincheck = PodioItem::filter($appUser_id, [
        'filters' => [
            // replace 123456 with field ID for your field with email type
            'title' => $_POST['email'],
            'contrasena' => $_POST['password']

        ]
    ]);
    
    $firtsloginflag = true;
    

    IF($logincheck -> filtered > 0)
    {

        foreach ($logincheck as $item) {
            $_SESSION['userId'] = $item->item_id ;
            $_SESSION['userNombre'] = $item->fields["nombre"]-> values;
            $_SESSION['userProfesion']= $item->fields["profesion"]-> values;
            $_SESSION['userEmail']= $item->fields["title"]-> values;

            if( $item->fields["imagen"] == NULL){
                $_SESSION['userImagen']= "images/defaultavatar_large.png";
            }else{
                $_SESSION['userImagen']= $item->fields["imagen"] -> values[0]-> link;
            }

            if($item->fields['primer-login']->values[0][text] == "si" || !isset($item->fields['primer-login']->values[0][text]))
            {
                echo '<script language="javascript">';
                echo ' window.location.href = "cambiarPassword.php" ; ';
                echo '</script>';
            } 
            else 
            {
                echo '<script language="javascript">';
                echo ' window.location.href = "news.php" ; ';
                echo '</script>';
            }

            echo '<script language="javascript">';
            echo ' window.location.href = "news.php" ; ';
            echo '</script>';

        }

    }else{
        echo '<script language="javascript">';
        echo 'swal("Error!","Email o contraseña incorrectos.","error")';
        echo '</script>';
        //$errMSG = "Email o contraseña incorrectos.";
    }
    
    
}

if (isset($_POST['recuperarPassword'])) {



    //App Usuarios
    $appUser_id = '21057475';
    $appUser_token = '67c2660d1f334543ab4f3601b14c6c6b';
    Podio::setup($client_id, $client_secret);
    Podio::authenticate_with_app($appUser_id, $appUser_token);

    // Output the title of each item

    $logincheck = PodioItem::filter($appUser_id, [
        'filters' => [
            'title' => $_POST['email']
        ]
    ]);

    IF($logincheck -> filtered > 0)
    {
        foreach ($logincheck as $item) {
            $password = $item->fields["contrasena"]-> values;
        }

    }else {
        echo '<script language="javascript">';
        echo 'swal("Error!","El email ingresado no existe.","error")';
        echo '</script>';
    }

    $to = $_POST['email'];
    $subject = "Tu Contraseña a sido recuperada.";
    $message = "Por favor usar esta contraseña para loguearse: " . $password;
    $headers = "From : support@innen.com.ar";

    if(mail($to,$subject,$message,$headers)){
        echo '<script language="javascript">';
        echo 'swal("Mail Enviado!","Se ha enviado un mail a su correo con la contraseña.","success")';
        echo '</script>';
    }else{
        echo '<script language="javascript">';
        echo 'swal("Error!","No se ha podido enviar el mail, por favor contactese con su administrador.","error")';
        echo '</script>';
    }
}
    function loggedin()
    {
        if(isset($_SESSION['userId']) || isset($_COOKIE['email']))
        {
            $loggedin = true;
            return $loggedin;
        }
    }
?>

<!DOCTYPE html>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.1/animate.css">
    <title>Login - Adecco Asociados & Candidatos </title>
  </head>
  <body>

    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
          <p></p>
       <img src="https://www.adecco.com.ar/wp-content/uploads/2016/09/logo.png" alt="Adecco Argentina">
      </div>
      <div class="login-box">
        <form class="login-form" method="post">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>LOG IN</h3>
          
          
         <?php if (isset($errMSG)) { ?>
                <div class="form-group">
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                    </div>
                </div>
         <?php } ?>

          
          <div class="form-group">
            <label class="control-label">USUARIO</label>
            <input id="email" name="email" class="form-control" type="email" placeholder="Email" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>" required autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input id="password"  name="password" class="form-control" type="password" placeholder="Password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" required>
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label>
                  <input type="checkbox" name="recordarme"><span class="label-text">Recordarme</span>
                </label>
              </div>
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Olvide mi Contraseña</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit" id="login" name="login"><i class="fa fa-sign-in fa-lg fa-fw"></i>LOG IN</button>
          </div>
          
            
        </form >
        <form class="forget-form" method="post">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Olvide mi Contraseña</h3>
          <div class="form-group">
            <label class="control-label">EMAIL</label>
            <input class="form-control" type="email" id="email" name="email" placeholder="Email">
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit" name="recuperarPassword"><i class="fa fa-unlock fa-lg fa-fw"></i>RECUPERAR</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Volver al Login</a></p>
          </div>
        </form>
      </div>
    </section>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    
    <!-- Essential javascripts for application to work-->
    <script src="js/sweetalert2.all.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="https://unpkg.com/promise-polyfill@7.1.0/dist/promise.min.js"></script>


    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>