<?php 

$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=25;
$Accion="Ingreso";
$Descripción="Ingreso a consultar venta";
$_SESSION['menu'] = $_GET['objeto'];
$Auth->InsertarVenta($_SESSION['menu'],$Accion,$Descripción);

    if(!isset($_SESSION['admin'])){
        header("location:" . base_url);
	}
     require 'admin/shared/header.php';
     require_once 'models/Admin.php'?>


	<
			<!-- Page header -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CLIENTES
				</h3>
			</div>
		</ul>
	</div>
			
						<a href='#' class="btn btn-primary btn_new_cliente"><i class="fas fa-user-plus"></i> Nuevo Cliente</a>

			
			<!-- Content -->
			<div class="container-fluid">
				<div class="table-responsive">
					<table class="table table-dark table-sm">
						<thead>
							<tr class="text-center roboto-medium">
								<th>ID</th>
								<th>NOMBRE</th>
								<th>DNI</th>
								<th>TELEFONO</th>
								<th>DIRECCIÓN</th>
								<th>ACCIONES</th>
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
								<th><?= $r['nombre_cliente'] ?></th>
								<th><?= $r['DNI'] ?></th>
								<th><?= $r['telefono_cliente'] ?></th>
								<th><?= $r['direccion_cliente'] ?></th>
								
								<td>

								<a href="<?php base_url?>productosUpdate&id=<?=$r['id_producto']?>" class="btn btn-success">
	  									<i class="fas fa-sync-alt"></i>	
									</a>
								
                                <a href="<?php base_url?>eliminarCliente&id=<?= $r['id_cliente']?>" class="btn btn-warning">
	  									<i class="fas fa-sync-alt"></i>	
								</a>
								</td>
									<!-- <form action="">
										<button type="button" class="btn btn-warning">
		  									<i class="far fa-trash-alt"></i>
										</button>
									</form> -->
								
							</tr>
                            <?php  }?>
						</tbody>
					</table>
				</div>
				
			</div>

							
									<!-- <form action="">
										<button type="button" class="btn btn-warning">
		  									<i class="far fa-trash-alt"></i>
										</button>
									</form> -->
						
<?php require 'admin/shared/footer.php'; ?>
<script type="text/javascript" src="scripts/concepto.js"></script>
