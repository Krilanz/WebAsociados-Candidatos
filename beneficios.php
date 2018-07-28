<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit;
}

$client_id = 'asociadoscandidatos';
$client_secret = 'SrHDWvpDT2vLPIVgQ6axrkIOgYPr36hHqnnvow9uQCBUWCbz5330lP8k5pu6uNCr';

require_once 'podio-php/PodioAPI.php';

//App Beneficios
$appBeneficios_id = '21057481';
$appBeneficios_token = 'caf81919713f4aa785f89f97bb3a7222';
Podio::setup($client_id, $client_secret);
Podio::authenticate_with_app($appBeneficios_id, $appBeneficios_token);

$itemsBeneficios = PodioItem::filter($appBeneficios_id);

if(isset($_POST['buscar']))
{
   
   //buscar beneficios por filtro
   $itemsBeneficios = PodioItem::filter($appBeneficios_id, [
        'filters' => [
            '170440172' => intval($_POST['categoria'])
        ]
    ]);

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
    <link rel="stylesheet" type="text/css" href="css/bracket.css">
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
          <h1><i class="fa fa-credit-card"></i> Beneficios</h1>
          <p></p>
        </div>
      </div>
      <div class="buscador-general" style="padding-left: 40px;">
        <h2 class="title">
                <span class="text">Encontrá beneficios exclusivos para vos</span>&nbsp;
                <span class="icon"></span>
        </h2>
          <form method="post">
            <div class="row" role="form">
                <div class="form-group col-md-3">
                <input id="txtPalabraClave" type="text" placeholder="Ingresá tu búsqueda" class="form-control">
                </div>
                <div class="form-group col-md-4">
                <input id="txtDonde" type="text" placeholder="Región/Provincia/Localidad/Barrio" class="form-control ui-autocomplete-input" autocomplete="off">
                </div>
                <div class="form-group col-md-3">
                <select class="form-control" id="selectCategoria" name="categoria"  placeholder="Categoría"style="padding-top: 7.5px !important;">
                            <option value="1">GASTRONOMÍA</option>

                            <option value="2">ENTRETENIMIENTO</option>

                            <option value="3">TURISMO</option>

                            <option value="4">MODA</option>
                </select>
                </div>
                <div class="form-group col-md-1" style="width: 97.5px !important; float: right;">
                <button class="btn btn-primary" name="buscar" type="submit" value="buscar"><i class="fa fa-fw fa-lg fa-search"></i>Buscar</button>
                </div>
            </div>
          </form>
    </div>
     <div class="br-pagebody pd-x-20 pd-sm-x-30 mx-wd-1350">
         
        <div class="card-deck card-deck-sm mg-x-0">
            <?php
                $count = 0;
                foreach ($itemsBeneficios as $item) {
                    $count++; 
                ?>
                    <div class="card shadow-base bd-0 mg-0">
                        <figure class="card-item">
                          <img class="img-fluid rounded-top" style="width: auto;height: 280px;"src="<?php echo $item->fields["imagen"] -> values[0]-> link; ?>" alt="Image">
                        </figure>
                        <div class="card-body pd-25">
                          <p class="tx-20 tx-uppercase tx-mont tx-semibold tx-info"><?php echo $item->fields["title"]-> values ?></p>
                          <h5 class="tx-normal tx-roboto lh-3 mg-b-15"><a href="" class="tx-inverse hover-info"> Descuento: <?php echo $item->fields["descuento-3"]-> values ?> </a></h5>
                          <p class="tx-14 tx-gray-600 mg-b-25"> <?php echo $item->fields["descripcion"] == null ? "" : $item->fields["descripcion"] -> values ?> </p>
                          <p class="tx-10 tx-gray-600 mg-b-25"> Vigente desde el <?php echo $item->fields["vigencia"]-> values["start"] == null ? "" : $item->fields["vigencia"]-> values["start"] -> format('Y/m/d') ?> hasta el <?php echo $item->fields["vigencia"]-> values["end"] == null ? "" : $item->fields["vigencia"]-> values["end"] -> format('Y/m/d') ?> <span class="pipe">|</span> <a href="">Bases</a> </p>
                          <p class="tx-15 mg-b-5">
                            <button class="btn btn-primary" ><i class="fa fa-fw fa-lg fa-exchange"></i>Canjear</button> 
                          </p>
                        </div><!-- card-body -->
                      </div><!-- card -->
            <?php
                if( $count == 3  ){ 
                    $count = 0;
                    
                ?>  
                    
                      </div><!-- card-body -->
                    </div><!-- card -->
                    
                    <div class="br-pagebody pd-x-20 pd-sm-x-30 mx-wd-1350">
                        <div class="card-deck card-deck-sm mg-x-0">

                <?php
                
                }
            }
            ?>  

        </div><!-- card-body -->
    </div><!-- card --> 
          
        
        
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
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

