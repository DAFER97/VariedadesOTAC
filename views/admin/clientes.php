<?php 

$db = Database::connect();
require_once 'models/Auth.php';

$admin =new Admin();
$auth = new Auth();
$Accion = "Ingreso";
$Descripción = "Ingreso a módulo de Productos";

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
    
	<title>Lista usuarios</title>
	</head>
		<!-- Page content -->
		

			<!-- Page header -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CLIENTES
				</h3>
			</div>
		</ul>
	</div>
			
						<a href='clientesnew' class="btn btn-primary btn_new_cliente"><i class="fas fa-user-plus"></i> Nuevo Cliente</a>
						<a target="blank" href='reporteClientes2' class="btn btn-danger btn_new_cliente"><i class="fa fa-file-pdf-o"></i> Reporte</a>

			

			<!-- Content -->
			<div class="container-fluid">
				<div class="table-responsive">
					<div class="container" style="margin-top: 10px;padding: 5px">
    				<table id="tablax" class="table table-striped table-bordered" style="width:100%">
    				<thead>
							<tr class="text-center roboto-medium">
								<th>ID</th>
								<th>NOMBRE</th>
								<th>DNI</th>
								<th>TELEFONO</th>
								<th>DIRECCIÓN</th>
								<th>FECHA CREACIÓN</th>
								<th>EDITAR</th>
								<th>ELIMINAR</th>
								<th>VER</th>
							</tr>
						</thead>
						<tbody>
                        <?php
                        $i;
                            $admin = new Admin();
                             $result=$admin->ObtenerClientes();
                            foreach($result as $r){ ?>
							<tr class="text-center" >
								<td><?= $r['id_cliente'] ?></td>
								<th><center><?= $r['nombre_cliente'] ?></center></th>
								<th><?= $r['DNI'] ?></th>
								<th><?= $r['telefono_cliente'] ?></th>
								<th><?= $r['direccion_cliente'] ?></th>
								<th><?= $r['fecha_creacion'] ?></th>
								
								<td><center>

								<a href="<?php base_url?>clientesUpdate&id=<?=$r['id_cliente']?>" class="btn btn-success">
	  									<i class="fas fa-sync-alt"></i>	
									</a>
								
                               </center>
								</td>
								<td>
									 <a onclick="return confirmardelete()" href="<?php base_url?>eliminarCliente&id=<?= $r['id_cliente']?>" class="btn btn-danger">
	  									<i class="fa fa-times"></i>	
								</a>

								<td>
									 <a target="_blank"  href="../views/reporteClientes.php?id=<?= $r['id_cliente']?>" class="btn btn-green">
	  									<i class="fa fa-file-pdf-o"></i>	
								</a>
								</td>
									<!-- <form action="">
										<button type="button" class="btn btn-warning">
		  									<i class="far fa-trash-alt"></i>
										</button>
									</form> -->
								
							</tr>
                            <?php }?>
						</tbody>
					</table>
				</div>
				
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
			
	
	
<?php require 'shared/footer.php'; ?>
<script type="text/javascript" src="scripts/concepto.js"></script>
