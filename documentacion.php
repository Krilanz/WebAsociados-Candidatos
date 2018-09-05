<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit;
}

$client_id = 'asociadoscandidatos-i5gbls';
$client_secret = 'an1aMc59Oz9vCoS0WXT2JQtX3IC44IgQ3BN1aHtAdPSLzk8CJXxPFYnhqivbgNE5';


require_once 'podio-php/PodioAPI.php';

//App Documentacion
$appDocumentacion_id = '21057486';
$appDocumentacion_token = '40e552f86d39477c967cac29b3475064';
Podio::setup($client_id, $client_secret);
Podio::authenticate_with_app($appDocumentacion_id, $appDocumentacion_token);

$itemsDocumentacion = PodioItem::filter($appDocumentacion_id);

if(isset($_POST['buscar']))
{
   
   //buscar documentacion por filtro
   $itemsDocumentacion = PodioItem::filter($appDocumentacion_id, [
        'filters' => [
            '170440172' => intval($_POST['categoria'])
        ]
    ]);

}

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
  <head>
    <title>Adecco - Asociados & Candidatos</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
  </head>
  <body class="app sidebar-mini rtl">
  <?php include('_layout.html');?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-book"></i> Documentación</h1>
          <p></p>
        </div>
      </div>
        
        
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="table">
                <thead>
                  <tr>
                    <th>Nombre del Documento</th>
                    <th>Categoría</th>
                    <th>Descargar</th>
                  </tr>
                </thead>
                <tbody>
                   <?php
                    foreach ($itemsDocumentacion as $item) {
                        $detalles = PodioItem::get_by_app_item_id( $appDocumentacion_id , $item -> app_item_id) ;
                        $fileId = 0;
                        foreach ($detalles -> files as $detalle) {                           
                            $fileId = $detalle -> file_id;
                        }
                    ?>
                      <tr>                            
                            <td><?php echo $item->fields["title"] == null ? "" : $item->fields["title"]-> values ?></td>
                            <td><?php echo $item->fields["categoria"] == null ? "" : $item->fields["categoria"]-> values[0]['text'] ?></td>
                            <td><a href="documentacion.php?descargar=<?php echo $fileId ?>">Descargar</a></td>
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
    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#table').DataTable({
    "language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});</script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    
    
   
    
  </body>
  
  
 
</html>

