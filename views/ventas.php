<?php 

$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=25;
$Accion="INGRESO";
$Descripción="INGRESO A CONSULTAR VENTAS";
//$_SESSION['menu'] = $_GET['objeto'];
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
    
	<title>LISTA DE VENTAS</title>
	</head>




	
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Panel de ventas</h1>
	</div>
<div class="container-fluid">
		<ul class="full-box list-unstyled page-nav-tabs">

			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE VENTAS
				</h3>
			</div>
		</ul>
	</div>

<a href='VentasNew' class="btn btn-primary btn_new_cliente"><i class="fas fa-user-plus"></i> Nueva Venta</a>
<a href='reporteVenta' class="btn btn-danger btn_new_cliente"><i class="fa fa-file-pdf-o"></i> Reporte</a>

	<div class="container-fluid">
				<div class="table-responsive">
					<div class="container" style="margin-top: 10px;padding: 5px">
    				<table id="tablax" class="table table-striped table-bordered" style="width:100%">
    					<thead>
							<tr class="text-center roboto-medium">
								
								<th>ID</th>
								<th>FECHA</th>
								<th>ARTICULOS VENDIDOS</th>
								<th>DNI</th>
								<th>CLIENTE</th>
							</tr>
						</thead>
						<tbody>
                        <?php
                        
                            $admin = new Admin();
                             $result=$admin->ObtenerVentas();
                            foreach($result as $r){ ?>
							<tr class="text-center" >
								
								<th><?= $r['id_venta'] ?></th>
								<th><?= $r['fecha_venta'] ?></th>
								<th><?= $r['total_venta'] ?></th>
								<th><?= $r['DNI'] ?></th>
								<th><?= $r['nombre_cliente'] ?></th>
								<td>
										<button onclick="verFactura(<?= $r['id_venta'] ?>)" type="button" class="btn btn-primary view_factura" >Ver recibo</button>
									</td>
								
							</tr>
                            <?php  }?>
						</tbody>
					</table>
				</div>
	
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
    <script>
        $(document).ready(function () {
            $('#tablax').DataTable({
                language: {
                    processing: "Tratamiento en curso...",
                    search: "Buscar&nbsp;:",
                    lengthMenu: "Agrupar de _MENU_ items",
                    info: "Mostrando del item _START_ al _END_ de un total de _TOTAL_ items",
                    infoEmpty: "No existen datos.",
                    infoFiltered: "(filtrado de _MAX_ elementos en total)",
                    infoPostFix: "",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron datos con tu busqueda",
                    emptyTable: "No hay datos disponibles en la tabla.",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Ultimo"
                    },
                    aria: {
                        sortAscending: ": active para ordenar la columna en orden ascendente",
                        sortDescending: ": active para ordenar la columna en orden descendente"
                    }
                },
                scrollY: 400,
                lengthMenu: [ [10, 25, -1], [10, 25, "All"] ],
            });
        });
    </script>
	



	
<?php require 'admin/shared/footer.php'; ?>
<script type="text/javascript" src="scripts/concepto.js"></script>




<script type="text/javascript">
	function verFactura(id){
       window.open(`../recibo.php?id=${ id }`, '_blank');
	}
</script>
