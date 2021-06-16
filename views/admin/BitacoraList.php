<?php 

$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=10;
$Accion="INGRESO";
$Descripción="INGRESO A CONSULTAR BITÁCORA";
$_SESSION['menu'] = $_GET['objeto'];
$Auth->InsertarBitacora($_SESSION['menu'],$Accion,$Descripción);

    if(!isset($_SESSION['admin'])){
        header("location:" . base_url);
	}
     require 'shared/header.php';
     require_once 'models/Admin.php'?>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    	<link  href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    	<link  href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    
	<title>BITÁCORA</title>
	</head>

	
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE BITÁCORA
				</h3>
			</div>
			
	<a 	target="blank" href='reporteBitacora' class="btn btn-danger btn_new_cliente"><i class="fa fa-file-pdf-o"></i> Reporte</a>
			
			<!-- Content -->
			<div class="container-fluid">
				<div class="table-responsive">
					<div class="container" style="margin-top: 10px;padding: 5px">
    				<table id="tablax" class="table table-striped table-bordered" style="width:100%">
    				<thead>
							<tr class="text-center roboto-medium">
								
								<th>#</th>
								<th>FECHA</th>
								<th>NOMBRE</th>
								<th>PANTALLA</th>
								<th>ACCIÓN</th>
								<th>DESCRIPCIÓN</th>
							</tr>
						</thead>
						<tbody>
                        <?php
                        
                            $admin = new Admin();
                             $result=$admin->ListarBitacora();
                            foreach($result as $r){ ?>
							<tr class="text-center" >
								
								<th><?= $r['id_bitacora'] ?></th>
								<th><?= $r['fecha_creacion'] ?></th>
								<th><?= $r['usuario'] ?></th>
								<th><?= $r['objeto'] ?></th>
								<th><?= $r['accion'] ?></th>
								<th><?= $r['descripcion'] ?></th>
								<!--<td>
							
									 <form action="">
										<button type="button" class="btn btn-warning">
		  									<i class="far fa-trash-alt"></i>
										</button>
									</form> 
								</td>-->
							</tr>
                            <?php  }?>
						</tbody>
					</table>
				</div>
				<!-- <nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						<li class="page-item disabled">
							<a class="page-link" href="#" tabindex="-1">Previous</a>
						</li>
						<li class="page-item"><a class="page-link" href="#">1</a></li>
						<li class="page-item"><a class="page-link" href="#">2</a></li>
						<li class="page-item"><a class="page-link" href="#">3</a></li>
						<li class="page-item">
							<a class="page-link" href="#">Next</a>
						</li>
					</ul>
				</nav> -->
			</div>

		</section>
	</main>
	


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
                    lengthMenu: "AGRUPAR DE _MENU_ REGISTROS",
                    info: "MOSTRANDO EL REGISTROS _START_ al _END_ DE UN TOTAL DE  _TOTAL_ REGISTROS",
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
	
<?php require 'shared/footer.php'; ?>
<script type="text/javascript" src="scripts/concepto.js"></script>



