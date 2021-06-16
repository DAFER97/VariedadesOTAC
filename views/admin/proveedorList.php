<?php 

$db = Database::connect();
require_once 'models/Auth.php';


$admin =new Admin();
$auth = new Auth();
$Accion = "INGRESO";
$Descripción = "INGRESO AL MODULO DE PROVEEDORES";
//$_SESSION['menu'] = $_GET['objeto'];
$auth->InsertarBitacora($_SESSION['menu'],$Accion,$Descripción);


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
    
	<title>LISTA DE PROVEEDORES</title>
	</head>
	

		<!-- Page content -->
		<section class="full-box page-content">
			

			<!-- Page header -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PROVEEDORES
			</div>
			
		<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a href="proveedoresNew" class="btn btn-primary btn_new_usuario"><i class="fas fa-user-plus"></i> Nuevo Proveedor</a>
						<a target="blank" href='reporteProveedor' class="btn btn-danger btn_new_cliente"><i class="fa fa-file-pdf-o"></i> Reporte</a>
					</li>
				</ul>	
			</div>
			<!-- Content -->
			<div class="container-fluid">
				<div class="table-responsive">
					<div class="container" style="margin-top: 10px;padding: 5px">
    				<table id="tablax" class="table table-striped table-bordered" style="width:100%">
    				<thead>
							<tr class="text-center roboto-medium">
								<th>ID</th>
								<th>PROVEEDOR</th>
								<th>CONTACTO</th>
								<th>TELEFONO</th>
								<th>DIRECCION</th>
								<th>FECHA CREACION</th>
							    <th>EDITAR</th>
								<th>ELIMINAR</th>
							</tr>
						</thead>
						<tbody>
                        <?php
                        $i;
                            $admin = new Admin();
                             $result=$admin->Obtenerproveedor();
                            foreach($result as $r){ ?>
							<tr class="text-center" >
								<td><?= $r['id_proveedor'] ?></td>
								<th><?= $r['proveedor'] ?></th>
								<th><?= $r['contacto'] ?></th>
								<th><?= $r['telefono'] ?></th>
								<th><?= $r['direccion'] ?></th>
								<th><?= $r['fecha_creacion'] ?></th>
								<td>
								<script type="text/javascript">
								function confirmardelete(){
									var respuesta = confirm("Estas seguro de eliminar este proveedor");
									if (respuesta ==true) {
										return true;
									}
									else {
										return false;
									}

								}
								</script>
									<a href="<?php base_url?>proveedorUpdate&id=<?=$r['id_proveedor']?>" class="btn btn-success">
	  									<i class="fas fa-sync-alt"></i>	
									</a>
								</td>
								<td>
                                <a href="<?php base_url?>eliminarproveedor&id=<?= $r['id_proveedor']?>" class="btn btn-danger" onclick="return confirmardelete()">
	  									<i class="fa fa-times"></i>	
								</a>
									<!-- <form action="">
										<button type="button" class="btn btn-warning">
		  									<i class="far fa-trash-alt"></i>
										</button>
									</form> -->
								</td>
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
	
<?php require 'shared/footer.php'; ?>
<script type="text/javascript" src="scripts/concepto.js"></script>



