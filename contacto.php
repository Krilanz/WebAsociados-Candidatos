<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit;
}

$client_id = 'asociadoscandidatos';
$client_secret = 'SrHDWvpDT2vLPIVgQ6axrkIOgYPr36hHqnnvow9uQCBUWCbz5330lP8k5pu6uNCr';

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
  <?php
    include('_layout.html');
   ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-envelope"></i> Contactenos</h1>
          <p></p>
        </div>
       </div>
          <form>

    <div class="form-contact"> 
        <label for="nombcompl" class="control-label">Nombre Completo</label>
        <input type="text" class="form-control" required="required" id="nombcntfrm" name="nombrecnt">
    </div>       
              <br>
    <div class="form-contact"> 
        <label for="tel" class="control-label">Telefono</label>
        <input type="text" class="form-control" pattern="[0-9]{0,20}" required="required" id="telcntfrm" name="telefonocnt">
    </div>                    
             <br>                
    <div class="form-contact">
        <label for="dni" class="control-label">DNI</label>
        <input type="text" class="form-control" required="required" pattern="[0-9]{0,20}" title="Debe llevar solo numeros" id="dnicntfrm" name="dnicnt">
    </div>   
 <br>
    <div class="form-contact">
        <label for="correo" class="control-label">Correo Electronico</label>
        <input type="email" class="form-control" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Por favor ingresa un email valido" id="emailcntfrm" name="emailcnt">
    </div>  
            <br>   
    <div class="form-contact">
        <label for="city_id" class="control-label">Compañía en la que Trabaja</label>
        <input type="text" class="form-control" required="required" id="companycntfrm" name="compania">
    </div>                                    
           <br>                  
    <div class="form-contact">
        <label for="state_id" class="control-label">Sucursal de Adecco</label>
        <select class="form-control" id="succntfrm" required="required">
            <option></option>
            <option value="CABA | Belgrano - Av. Cabildo 4466">CABA | Belgrano - Av. Cabildo 4466</option><option value="CABA | Centro - Av. Córdoba 1101">CABA | Centro - Av. Córdoba 1101</option><option value="CABA | Hoteles y Catering - B. de Irigoyen 454">CABA | Hoteles y Catering - B. de Irigoyen 454</option><option value="Buenos Aires | Caseros ">Buenos Aires | Caseros </option><option value="Buenos Aires | General Rodriguez">Buenos Aires | General Rodriguez</option><option value="Buenos Aires | Mercedes">Buenos Aires | Mercedes</option><option value="Buenos Aires | Morón">Buenos Aires | Morón</option><option value="Buenos Aires | San Justo">Buenos Aires | San Justo</option><option value="Buenos Aires | Pergamino">Buenos Aires | Pergamino</option><option value="Buenos Aires | San Isidro">Buenos Aires | San Isidro</option><option value="Buenos Aires | Pacheco">Buenos Aires | Pacheco</option><option value="Buenos Aires | Pilar Parque">Buenos Aires | Pilar Parque</option><option value="Buenos Aires | San Nicolás de los Arroyos">Buenos Aires | San Nicolás de los Arroyos</option><option value="Buenos Aires | Zárate">Buenos Aires | Zárate</option><option value="Buenos Aires | Avellaneda ">Buenos Aires | Avellaneda </option><option value="Buenos Aires | Bahía Blanca">Buenos Aires | Bahía Blanca</option><option value="Buenos Aires | Cañuelas">Buenos Aires | Cañuelas</option><option value="Buenos Aires | La Plata">Buenos Aires | La Plata</option><option value="Buenos Aires | Lomas de Zamora">Buenos Aires | Lomas de Zamora</option><option value="Buenos Aires | Mar del Plata">Buenos Aires | Mar del Plata</option><option value="Córdoba | Capital">Córdoba | Capital</option><option value="Córdoba | Río Cuarto">Córdoba | Río Cuarto</option><option value="Chubut | Comodoro Rivadavia">Chubut | Comodoro Rivadavia</option><option value="Entre Ríos | Gualeguaychú">Entre Ríos | Gualeguaychú</option><option value="Mendoza | Capital">Mendoza | Capital</option><option value="Mendoza | Maipú">Mendoza | Maipú</option><option value="Neuquén | Capital">Neuquén | Capital</option><option value="Río Negro | General Roca">Río Negro | General Roca</option><option value="Salta | Capital">Salta | Capital</option><option value="San Juan | Capital">San Juan | Capital</option><option value="San Luis | Capital">San Luis | Capital</option><option value="San Luis | Villa Mercedes">San Luis | Villa Mercedes</option><option value="Santa Fé | Venado Tuerto">Santa Fé | Venado Tuerto</option><option value="Santa Fé | Capital">Santa Fé | Capital</option><option value="Santa Fé | Rosario - Bvd. Oroño 4606">Santa Fé | Rosario - Bvd. Oroño 4606</option><option value="Santa Fé | Rosario - Santa Fé 1441">Santa Fé | Rosario - Santa Fé 1441</option><option value="Tucumán | San Miguel de Tucumán">Tucumán | San Miguel de Tucumán</option><option value="Desconozco / No recuerdo">Desconozco / No recuerdo</option></select>
        </select>                    
    </div>
     <br>
              <div class="form-contact"> 
        <label for="state_id" class="control-label">Motivo de Consulta</label>
        <select class="form-control" id="motivcntfrm" required="required">
            <option></option>
            <option value="Recibo de Sueldo">Recibo de Sueldo</option><option value="Obra Social">Obra Social</option><option value="Contratación / Situación Laboral">Contratación / Situación Laboral</option><option value="ART-Accidente de Trabajo">ART-Accidente de Trabajo</option><option value="Otro">Otro</option>
        </select>                    
    </div>      
     <br>
    <div class="form-contact">
        <button type="submit" class="btn btn-primary">Enviar!</button>
    </div>     
    
</form> 
        
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
