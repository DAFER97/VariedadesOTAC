<?php
if(isset($_SESSION['admin']) == null){
	header("location:" . base_url);

	
	
}

$db = Database::connect();
echo "<script> alert('Bienvenido al sistema Variedades-OTAC'); </script>";
?>

<?php require 'shared/header.php';?>
	<title>Lista usuarios</title>

	



<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
	</div>


	<div class="full-box page-header">
				<h3 class="text-center">
					<i class=""></i> &nbsp; REPORTES GENERALES
				</h3>
			</div>
			<!-- /.row -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-pdf-o fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"></div>
                                            <div>Reporte de Productos</div>
                                        </div>
                                    </div>
                                </div>
                                <a target="blank" href='reporteProducto'>
                                    <div class="panel-footer">
                                        <span  class="pull-left">Ver Reporte</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-pdf-o fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"></div>
                                            <div>Reporte de Ventas</div>
                                        </div>
                                    </div>
                                </div>
                                <a target="blank" href='reporteVenta'>
                                    <div class="panel-footer">
                                        <span  class="pull-left">Ver Reporte</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-pdf-o fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"></div>
                                            <div>Reporte de usuarios</div>
                                        </div>
                                    </div>
                                </div>
                                <a target="blank" href='reporteUsuario'>
                                    <div class="panel-footer">
                                        <span  class="pull-left">Ver Reporte</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                             <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-pdf-o fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"></div>
                                            <div>Reporte de Clientes</div>
                                        </div>
                                    </div>
                                </div>
                                <a target="blank"  href='reporteClientes2'>
                                    <div class="panel-footer">
                                        <span  class="pull-left">Ver Reporte</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                             <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-pdf-o fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"></div>
                                            <div>Reporte de Proveedores</div>
                                        </div>
                                    </div>
                                </div>
                                <a target="blank"  href='reporteProveedor'>
                                    <div class="panel-footer">
                                        <span  class="pull-left">Ver Reporte</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

				

			<div class="full-box page-header">
				<h3 class="text-center">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; INFORMACIÓN  GENERAL DE LA EMPRESA
				</h3>
			</div>



<!-- Usuario -->
<a class="col-xl-3 col-md-6 mb-4" align= "center" href="usuarios&objeto=7">
<div class="card border-left-success shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Usuario</div>
<div class="h5 mb-0 font-weight-bold text-gray-800">
<?php
$produc = $db->query("SELECT COUNT(id_usuario) as amount FROM tbl_ms_usuario");
echo $produc->num_rows > 0 ? $produc->fetch_array()['amount']:0;
?>
</div>
</div>
<div class="col-auto">
<i class="fas fa-users fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</a>

 <!-- Clientes -->
<a  align= "center"class="col-xl-3 col-md-6 mb-4" href="Clientes&objeto=30">
<div class="card border-left-success shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Clientes</div>
<div class="h5 mb-0 font-weight-bold text-gray-800">
<?php
$produc = $db->query("SELECT COUNT(id_cliente) as amount FROM tbl_clientes");
echo $produc->num_rows > 0 ? $produc->fetch_array()['amount']:0;
?>
</div>
</div>
<div class="col-auto">
<i class="fas fa-users fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</a>
  
<br/>
 <!-- Productos -->
<a class="col-xl-3 col-md-6 mb-4"  align= "center" href="Productos&objeto=39">
<div class="card border-left-success shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Producto</div>
<div class="h5 mb-0 font-weight-bold text-gray-800">
<?php
$produc = $db->query("SELECT COUNT(id_producto) as amount FROM tbl_productos");
echo $produc->num_rows > 0 ? $produc->fetch_array()['amount']:0;
?>
</div>
</div>
<div class="col-auto">
<i class="fas fa-users fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</a>

 <!-- Ventas -->
<a class="col-xl-3 col-md-6 mb-4"  align= "center"href="Ventas&objeto=35">
<div class="card border-left-success shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ventas</div>
<div class="h5 mb-0 font-weight-bold text-gray-800">
<?php
$produc = $db->query("SELECT COUNT(id_venta) as amount FROM tbl_ventas");
echo $produc->num_rows > 0 ? $produc->fetch_array()['amount']:0;
?>
</div>
</div>
<div class="col-auto">
<i class="fas fa-users fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</a>
	</div>
<?php require 'shared/footer.php'; ?>
<script type="text/javascript" src="scripts/concepto.js"></script>



