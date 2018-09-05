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
          <h1><i class="fa fa-files-o"></i> Terminos y Condiciones</h1>
          <p></p>
        </div>
       </div>
       <ul class="termslist">
         <li>© 2017 Adecco. Derechos reservados</li>
         <br>
         <li>Adecco Argentina S.A. Empresa de servicios eventuales. Habilitación MTEySS Nro. 1037/342</li>
         <br>
         <li>Adecco tiene como uno de sus objetivos proteger su información en Internet, al igual que se protege toda información de carácter personal que llega a Adecco. </li>
         <br>
         <li>Términos y Condiciones de la Utilización del Sitio <a href="http://www.adecco.com.ar">http://www.adecco.com.ar</a> (en adelante denominada “Web Site”)
Usted podrá visitar nuestra Web Site, consultar toda la información en ella incorporada y dejar sus datos personales libremente. A través del Web Site se da a conocer al público todos los tipos de actividades que presta Adecco, debiéndose considerar la información en ella contenida a modo de introducción. Le pedimos que lea cuidadosamente los términos y condiciones para acceder a esta Web Site y a cualquier página o link inserto en la misma. Si no estuviese de acuerdo con los términos o condiciones le rogamos no acceda a esta dirección o a cualquier página o link de la misma.</li>
<br>
         <li><b>&ensp;&ensp;Política de Protección de Datos</b></li>
         <br>
         <p>Una de las finalidades primordiales de la Web Site de Adecco es el reclutamiento de candidatos para puestos de trabajo. Por tal motivo para utilizar alguno de los servicios que ofrece esta Web Site se deberán de proporcionar una serie de datos de carácter personal que se tratarán de forma automatizada y se almacenarán en la base de datos de Adecco.

Adecco utilizará dichos datos personales de acuerdo con la finalidad para la que fueron solicitados manteniendo niveles de seguridad en la protección de los citados datos acordes con las leyes vigentes, instalando todos los posibles medios a su alcance para evitar la pérdida, mal uso, alteración, y acceso no autorizado a ellos.

Dentro de los datos personales que serán almacenados en la base de datos se encuentran: la información personal y de contacto (como nombre, dirección postal, dirección de correo electrónico y número de teléfono); el nombre de usuario y contraseña cuando se registre en nuestros sitios; la información de pago (como el número de tarjeta de pago, fecha de vencimiento, número de autorización o código de seguridad); y datos de geolocalización en relación con ciertas características de nuestra Web Site.

Los usuarios, previa acreditación de su identidad, podrán ejercitar en cualquier momento y mediante comunicación fehaciente a la empresa, los derechos de acceder, cancelar y actualizar su Información Personal, incluyendo su dirección de correo electrónico, así como a oponerse al tratamiento de la misma y a ser informado de las cesiones llevadas a cabo, todo ello de conformidad a lo dispuesto en la normativa aplicable. La información será proporcionada dentro de los 10 días corridos contados a partir de la fecha de recepción de la notificación fehaciente. La notificación deberá cursarse a Adecco Argentina S.A., con domicilio en Carlos Pellegrini piso 1°, Ciudad Autónoma de Buenos Aires. Este derecho solo puede ser ejercido en forma gratuita a intervalos no inferiores a seis meses, salvo que se acredite un interés legítimo al efecto, conforme lo establecido en el artículo 14, inciso 3 de la Ley Nº 25.326.

La DIRECCION NACIONAL DE PROTECCION DE DATOS PERSONALES, Órgano de Control de la Ley Nº 25.326, tiene la atribución de atender las denuncias y reclamos que se interpongan con relación al incumplimiento de las normas sobre protección de datos personales.</p>
         <li>&ensp;&ensp;<b>Propiedad Intelectual</b></li>
         <br>
         <p>Adecco es una marca registrada e identificativa de los servicios que se presta.

Los derechos de propiedad intelectual de esta Web Site sus pantallas, información y material pertenecen a Adecco salvo aclaración en contrario. Queda prohibida su reproducción, copia, distribución, transformación o modificación de contenidos (textos, imágenes, voces o estructura) a menos que se cuente con la autorización expresa y por escrito de Adecco.

El contenido de esta Web Site está protegido por las leyes de propiedad intelectual. Dichos contenidos deberán ser usados de forma correcta y licita por el usuario y, en particular queda obligado a utilizar dichos contenidos de forma diligente, correcta y lícita.

Está prohibida la transmisión de cualquier tipo de datos que usted pueda realizar a la Web Site, cuyos links atenten contra los derechos de propiedad de terceros, sean obscenos, pornográficos, difamatorios, de carácter amenazador o material que pueda ser considerado delito.</p>
         <li><b>&ensp;&ensp;Cookies</b></li>
         <br>
         <p>Utilizamos “cookies” para recopilar información sobre el comportamiento de los usuarios. Las cookies son pequeños archivos de texto que su navegador web coloca en el disco duro de su computadora. Nos permiten registrar datos anónimos sobre el comportamiento del usuario, por ejemplo, e información sobre qué navegador usan nuestros visitantes. No utilizamos cookies para recopilar datos personales u otra información relacionada con nuestros usuarios.

Esta información guardada por nuestros servidores web incluye información relativa a los navegadores, sistemas operativos y las direcciones IP de los equipos utilizados para acceder a la Web Site. La dirección IP puede proporcionar información sobre los proveedores de servicios de Internet utilizados y las zonas geográficas. Además, nuestros servidores web registrarán el sitio web que nuestros usuarios visitaron antes de visitar la Web Site, así como la fecha, hora y duración de su visita. En ningún momento se atribuyen estos datos a usuarios específicos.

Las cookies nos ayudan a mejorar la Web Site y a ofrecer un servicio mejor y más personalizado. Usted puede negarse a aceptar cookies activando la configuración en su navegador que le permite rechazar el almacenamiento de cookies. Esto eliminará todos los detalles de la cookie. Sin embargo, si selecciona esta configuración, es posible que no pueda acceder a determinadas partes del sitio web o utilizar ciertas funcionalidades. A menos que haya ajustado la configuración del navegador para que rechace las cookies, nuestros sistemas emitirán cookies cada vez que acceda al sitio web. Tenga en cuenta que otro sitio web de interés enlazado aquí también puede utilizar cookies, sobre las que no tenemos ningún control.

Si su equipo es compartido por otras personas, le aconsejamos que no seleccione la opción “recordar mis detalles” cuando un Servicio ofrece tal opción para almacenar determinada información introducida por usted.</p>
         <li><b>&ensp;&ensp;Enlaces a otros sitios web</b></li>
         <br>
         <p>Esta Web Site puede contener enlaces a otros sitios web de interés. Una vez que usted ha utilizado estos acoplamientos para salir de esta Web Site, usted debe notar que no tenemos ningún control sobre ese otro sitio web. Por lo tanto, no podemos ser responsables de la protección y privacidad de cualquier información que usted proporcione mientras visita dichos sitios y dichos sitios no se rigen por nuestra Política de privacidad. Usted debe tener cuidado y ver la declaración de privacidad aplicable para ese sitio web.</p>
         <li><b>&ensp;&ensp;Responsabilidades por Daños y Perjuicios</b></li>
         <br>
         <p>El usuario se compromete a utilizar esta Web Site, sus servicios y contenidos en un todo de acuerdo con las condiciones establecidas en las presentes términos y condiciones, la legislación aplicable, la buena fe y el orden público. Por ello, queda prohibido todo uso con fines ilícitos o que perjudiquen o impidan, puedan dañar y/o sobrecargar, de cualquier forma, la utilización y normal funcionamiento de la Web Site o directa o indirectamente atenten contra el mismo, contra Adecco o contra cualquier derecho de un tercero.

El usuario de la Web Site de Adecco será responsable de los daños y perjuicios que Adecco pueda sufrir directa o indirectamente, como consecuencia del incumplimiento de cualquiera de las obligaciones derivadas establecidas en el presente.</p>
         <li><b>&ensp;&ensp;Límite de Responsabilidad</b></li>
         <br>
         <p>En ningún caso Adecco, será responsable de algún daño, incluyendo sin límite, daños, pérdidas o gastos directos, indirectos inherentes o consecuentes que surjan en relación con la utilización de esta Web Site o de los enlaces con otras páginas aquí recogidas.

En todo caso, de ser requerido por orden judicial Adecco colaborará con las autoridades pertinentes en la identificación de las personas responsables de aquellos contenidos que puedan violar la ley. De igual forma, Adecco, elude toda responsabilidad en los supuestos de fallo en el rendimiento, error, omisión, interrupción, defecto de demora en la operación de transmisión, virus informático, fallo del sistema o línea, así como en el contenido, exactitud y opiniones expresadas y otras conexiones suministradas por estos medios. La Web Site de Adecco conecta con ciertos links de otras páginas web que pertenecen a terceros sobre los que Adecco no tiene control alguno. En estos supuestos Adecco no asume responsabilidad alguna ni compromiso sobre la información contenida en estas páginas.</p>
         <li><b>&ensp;&ensp;Reserva</b></li>
         <br>
         <p>Adecco se reserva el derecho a modificar unilateralmente la configuración de esta Web Site o los servicios en ella prestados, en cualquier momento y sin necesidad de previo aviso.</p>
       </ul>
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
