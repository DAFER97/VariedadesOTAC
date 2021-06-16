<?php 

$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=53;
$Accion="Ingreso";
$Descripción="Ingreso al restore del sistema";
$_SESSION['menu'] = $_GET['objeto'];
$Auth->InsertarVenta($_SESSION['menu'],$Accion,$Descripción);

    if(!isset($_SESSION['admin'])){
        header("location:" . base_url);
	}
     require 'admin/shared/header.php';
     require_once 'models/Admin.php'?>

     <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    	<link  href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    	<link  href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    
	
	</head>




	
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Panel de restauracion de la base de datos</h1>
	</div>
<div class="container-fluid">
		<ul class="full-box list-unstyled page-nav-tabs">

			<div class="full-box page-header">
				<h3 class="text-left">
					
			</div>
		<div>
			<center><h1> Generar restauracion de la base de datos </h1></center>
		</div>
		
		</div>

<center>
<a href='generarRestore' class="btn btn-info btn_new_cliente"><i class="fa fa-cloud-download"></i> Generar</a>
</center>
	
	
	<!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous">
        </script>
    <!-- DATATABLES -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
    </script>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js">
    </script>
    


	
<?php require 'admin/shared/footer.php'; ?>
<script type="text/javascript" src="scripts/concepto.js"></script>
