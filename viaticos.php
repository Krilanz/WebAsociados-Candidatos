
<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit;
}



$client_id = 'asociadoscandidatos-i5gbls';
$client_secret = 'an1aMc59Oz9vCoS0WXT2JQtX3IC44IgQ3BN1aHtAdPSLzk8CJXxPFYnhqivbgNE5';

require_once 'podio-php/PodioAPI.php';

//App Viaticos
$appViaticos_id = '21057483';
$appViaticos_token = 'e128acf902f846de86375254268b9aef';
Podio::setup($client_id, $client_secret);
Podio::authenticate_with_app($appViaticos_id, $appViaticos_token);

$userViaticos = PodioItem::filter($appViaticos_id, [
    'filters' => [
        'usuario' => $_SESSION['userId'],
    ]
]);

//App Usuarios
$appUser_id = '21057475';
$appUser_token = '67c2660d1f334543ab4f3601b14c6c6b';
Podio::setup($client_id, $client_secret);
Podio::authenticate_with_app($appUser_id, $appUser_token);

$userItem = PodioItem::get_basic($_SESSION['userId']); // Get item with item_id=123

$_SESSION['userNombre'] = $userItem->fields["nombre"]-> values;
//$_SESSION['userProfesion']= $userItem->fields["profesion"]-> values;
$fieldLimite = $userItem->fields["limite-mensual"]-> values;
$_SESSION['userLimiteMensual']= $fieldLimite['currency'] . ' ' . (string)round($fieldLimite['value'],2);
$_SESSION['userDisponible']= $userItem->fields["disponible-3"]-> values;
$_SESSION['userGastado']= $userItem->fields["gastado-2"]-> values;



if(isset($_GET['descargar']))
{
   
   //Descargar documentación 
   // Get the file object. Only necessary if you don't already have it!
    $file = PodioFile::get($_GET['descargar']);

    // Download the file. This might take a while...
    //$file_content = $file->get_raw();
    
    $file_content = Podio::get($file->link . '/medium', array(), array('file_download' => true))->body;
    // Store the file on local disk
    header("Content-Description: File Transfer"); 
    header("Content-Type: application/octet-stream"); 
    header("Content-Disposition: attachment; filename='" . $file -> name . "'"); 
    file_put_contents("downloads/" . $file -> name, $file_content);

    //readfile("downloads/" . $file -> name);
    unlink("downloads/" . $file -> name);
}


?>

<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    <title>Adecco - Asociados & Candidatos</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>
  <body class="app sidebar-mini rtl">
  <?php
    include('_layout.html');
   ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-money"></i> Reintegro De Gastos</h1>
          <p></p>
        </div>
      </div>
      <!--<div class="row">
        <div class="col-md-4">
          <div class="widget-small info"><i class="icon fa fa-balance-scale fa-3x"></i>
            <div class="info">
              <h4>Limite Mensual</h4>
              <p><b><?php //print $_SESSION['userLimiteMensual'] ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="widget-small primary"><i class="icon fa fa-bank fa-3x"></i>
            <div class="info">
              <h4>Disponible</h4>
              <p><b><?php //print $_SESSION['userDisponible'] ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="widget-small danger"><i class="icon fa fa-calculator fa-3x"></i>
            <div class="info">
              <h4>Gastado (Mes)</h4>
              <p><b><?php //print $_SESSION['userGastado'] ?></b></p>
            </div>
          </div>
        </div>
      </div>-->
      <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Solicitud de Reintegro de Gastos</h3>
                  <div class="tile-body">
                      <form method="post" action="" enctype="multipart/form-data">
                      <!--<div class="form-group">
                        <label class="control-label">Descripción</label>
                        <input class="form-control" type="text" id="proyecto" name="proyecto" placeholder="Descripcion" required>
                      </div>-->
                      <!--<div class="form-group">
                        <label class="control-label">Fecha de Pago</label>
                        <input class="form-control"   id="fecha" name="fecha" type="text" placeholder="Seleccionar fecha" required>
                      </div>-->
                      <div class="form-group">
                        <label class="control-label">Motivo del Reintegro</label>
                        <textarea class="form-control" id="motivo" name="motivo" rows="3" placeholder="Especificar motivo del reintegro"></textarea>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Monto Total</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                            <input class="form-control" id="monto" name="monto"  type="number" placeholder="Monto" required>
                            <div class="input-group-append"><span class="input-group-text">.00</span></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Comprobante</label>
                        <input class="form-control" id="comprobante" name="comprobante" type="file" required>
                      </div>

                      <div class="tile-footer">
                          <button class="btn btn-primary" name="submit" type="submit" value="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Cargar</button>
                      </div>
                    </form>
                  </div>

          </div>
        </div>
          <div class="col-md-6">

              <div class="tile">
                <h3 class="tile-title">Pedidos</h3>
                <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Fecha de Solicitud</th>
                      <!--<th>Fecha de Pago</th>-->
                      <th>Motivo</th>
                      <th>Monto Total</th>
                      <th>Estado</th>
                      <th>Imprimir</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $count = 0;
                    foreach ($userViaticos as $item) {
                        $count++;

                    ?>
                      <tr style="background:#<?php echo $item->fields["estado"]-> values[0]['color'] ?>">
                            <td><?php echo $count ?></td>
                            <td><?php echo $item->fields["fecha-de-solicitud"]-> values["start"] == null ? "" : $item->fields["fecha-de-solicitud"]-> values["start"] -> format('Y-m-d') ?></td>
                            <td><?php echo $item->fields["motivo"] == null ? "" : $item->fields["motivo"]-> values ?></td>
                            <td><?php echo $item->fields["monto-total"]-> values['currency'] . ' ' . (string)round($item->fields["monto-total"]-> values["value"],2)  ?></td>
                            <td><?php echo $item->fields["estado"] == null ? "" : $item->fields["estado"]-> values[0]['text'] ?></td>
                            <td><a href="viaticos.php?descargar=<?php echo $item->fields["comprobante-2"] -> values[0] -> file_id ?>">Imprimir</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
                </div>
              </div>

          </div>

      </div>
      
         <?php include_once('_footer.html');?>  
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Essential javascripts for application to work-->
    <script src="js/sweetalert2.all.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="https://unpkg.com/promise-polyfill@7.1.0/dist/promise.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/chart.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript">

      var data = {
      	labels: ["January", "February", "March", "April", "May"],
      	datasets: [
      		{
      			label: "My First dataset",
      			fillColor: "rgba(220,220,220,0.2)",
      			strokeColor: "rgba(220,220,220,1)",
      			pointColor: "rgba(220,220,220,1)",
      			pointStrokeColor: "#fff",
      			pointHighlightFill: "#fff",
      			pointHighlightStroke: "rgba(220,220,220,1)",
      			data: [65, 59, 80, 81, 56]
      		},
      		{
      			label: "My Second dataset",
      			fillColor: "rgba(151,187,205,0.2)",
      			strokeColor: "rgba(151,187,205,1)",
      			pointColor: "rgba(151,187,205,1)",
      			pointStrokeColor: "#fff",
      			pointHighlightFill: "#fff",
      			pointHighlightStroke: "rgba(151,187,205,1)",
      			data: [28, 48, 40, 19, 86]
      		}
      	]
      };
      var pdata = [
      	{
      		value: 300,
      		color: "#46BFBD",
      		highlight: "#5AD3D1",
      		label: "Complete"
      	},
      	{
      		value: 50,
      		color:"#F7464A",
      		highlight: "#FF5A5E",
      		label: "In-Progress"
      	}
      ]

      /*var ctxl = $("#lineChartDemo").get(0).getContext("2d");
      var lineChart = new Chart(ctxl).Line(data);

      var ctxp = $("#pieChartDemo").get(0).getContext("2d");
      var pieChart = new Chart(ctxp).Pie(pdata);*/

      $('#fecha').datepicker({
      	format: "yyyy-mm-dd",
      	autoclose: true,
      	todayHighlight: true
      });

      document.getElementById("monto").onkeypress = function(e) {
     var chr = String.fromCharCode(e.which);
     if ("-".indexOf(chr) >= 0) //tecla - bloqueada
         return false;
       };
    </script>
    <!-- Google analytics script-->
    <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
      	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      	ga('create', 'UA-72504830-1', 'auto');
      	ga('send', 'pageview');
      }
    </script>
  </body>
</html>


<?php

if ($_SESSION['NuevoViatico'] == 1) {
    $_SESSION['NuevoViatico'] = 0;
    echo '<script language="javascript">';
    echo 'swal("Nuevo Reintegro","El reintegro se ha cargado correctamente.'
    . ' Recordá acercar los comprobantes originales a la Sucursal Adecco.","success")';
    echo '</script>';
}

if(isset($_POST['submit']))
{
    try{


        $disponible = (float)$_SESSION['userDisponible'];
        if( (int)$_POST['monto'] > $disponible ){

            /*echo '<script language="javascript">';
            echo 'document.getElementById("fecha").value ="'.$_POST['fecha'].'" ';
            echo '</script>';*/

            echo '<script language="javascript">';
            echo 'document.getElementById("motivo").textContent="'.$_POST['motivo'].'" ';
            echo '</script>';

            echo '<script language="javascript">';
            echo 'document.getElementById("monto").value ="'.$_POST['monto'].'" ';
            echo '</script>';

            echo '<script language="javascript">';
            echo 'swal("Error","Ha excedido el límite establecido, se lo contactará a la brevedad","error")';
            echo '</script>';
            return;
        }

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["comprobante"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["comprobante"]["tmp_name"]);
        if($check == false) {
            echo '<script language="javascript">';
            echo 'swal("Error","El archivo de comprobante tiene que ser una imagen.","error")';
            echo '</script>';
            return;
        }

        // Check if file already exists
        /*if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }*/
        // Check file size
        if ($_FILES["comprobante"]["size"] > 500000) {
            echo '<script language="javascript">';
            echo 'swal("Error","El tamaño del archivo del comprobante es demasiado grande.","error")';
            echo '</script>';
            return;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo '<script language="javascript">';
            echo 'swal("Error","Solo se permiten cargar imagenes JPG, JPEG, PNG & GIF.","error")';
            echo '</script>';
            return;
        }

        if (move_uploaded_file($_FILES["comprobante"]["tmp_name"], $target_file)) {
            //echo "The file ". basename( $_FILES["comprobante"]["name"]). " has been uploaded.";
        } else {
            echo '<script language="javascript">';
            echo 'swal("Error","Hubo un error al subir el comprobante","error")';
            echo '</script>';
            return;
        }

        require_once 'podio-php/PodioAPI.php';
        Podio::setup($client_id, $client_secret);
        Podio::authenticate_with_app($appViaticos_id, $appViaticos_token);

        $comprobanteUpload = PodioFile::upload( $target_file, $_FILES["comprobante"]["name"] );



       //Creo el nuevo viatico
       $newViatico = PodioItem::create($appViaticos_id, array('fields' => array(
                    //"descripcion" => $_POST['proyecto'],
                    "fecha-de-solicitud" =>   date("Y-m-d H:i:s") ,
                    "motivo" =>   $_POST['motivo'] == "" ? null : $_POST['motivo'],
                    "monto-total" => $_POST['monto'],
                    "comprobante-2" => $comprobanteUpload -> file_id ,
                    "usuario" => intval($_SESSION['userId']),
                    "estado" => 1,
                )));

       unlink($target_file);
    } catch (Exception $e) {


        /*echo '<script language="javascript">';
        echo 'document.getElementById("fecha").value ="'.$_POST['fecha'].'" ';
        echo '</script>';*/

        echo '<script language="javascript">';
        echo 'document.getElementById("motivo").textContent="'.$_POST['motivo'].'" ';
        echo '</script>';

        echo '<script language="javascript">';
        echo 'document.getElementById("monto").value ="'.$_POST['monto'].'" ';
        echo '</script>';


        echo '<script language="javascript">';
        echo 'swal("Error","Hubo un error al solicitar el reintegro.","error")';
        echo '</script>';


        return;
    }

   $_SESSION['NuevoViatico'] = 1;
   echo '<script language="javascript">';
   echo ' window.location.href = "viaticos.php" ; ';
   echo '</script>';







}


?>
