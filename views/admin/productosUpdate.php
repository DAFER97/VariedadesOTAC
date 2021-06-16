<?php
$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=36;
$id_usuario = $_SESSION['admin']['id_usuario'];
$Accion="EDITAR PRODUCTO";
$Descripción="INGRESO DE EDICION DE PRODUCTOS POR ADMINISTRACION ";
$Auth->InsertarBitacoraSis($id_usuario,$No_Pantalla,$Accion,$Descripción);

if (!isset($_SESSION['admin'])) {
	header("location:" . base_url);
}
require 'shared/header.php';
//require 'models/Admin.php';

$id = $_GET['id'];
$Admin =  new Admin();
$result = $Admin->ObtenerProducto($id);
$r = mysqli_fetch_assoc($result);

?>
<title>Editar Producto</title>
<!-- Page content -->
<section class="full-box page-content">
	<nav class="full-box navbar-info">
		<a href="#" class="float-left show-nav-lateral">
			<i class="fas fa-exchange-alt"></i>
		</a>
		<a href="user-update.html">
			<i class="fas fa-user-cog"></i>
		</a>
		<a href="#" class="btn-exit-system">
			<i class="fas fa-power-off"></i>
		</a>
	</nav>

	<!-- Page header -->
	<div class="full-box page-header">
		<h3 class="text-left">
			<i class="fas fa-plus fa-fw"></i> &nbsp; EDITAR PRODUCTO
		</h3>
	</div>
	<!-- Content -->
	<div class="container-fluid">
		<form method="POST" action="<?php echo base_url ?>admin/ActualizarProducto&id=<?= $r['id_producto'] ?>" class="form-neon" autocomplete="off">
			<fieldset>
				<legend><i class="far fa-address-card"></i> &nbsp; Información del Producto</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="usuario_nombre" class="bmd-label-floating">NOMBRE PRODUCTO</label>
								<input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" required value="<?= $r['nombre_producto'] ?>" class="form-control" name="nombre_producto" id="nombre_producto" maxlength="35">
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="usuario_apellido" class="bmd-label-floating">DESCRIPCION DEL PRODUCTO</label>
								<input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');"required value="<?= $r['desc_producto'] ?>" class="form-control" name="desc_producto" id="desc_producto" maxlength="35">
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="usuario_apellido" class="bmd-label-floating">PRECIO VENTA</label>
								<input type="text" required value="<?= $r['precio_venta'] ?>" class="form-control" onkeypress="return SoloNumeros(event);" pattern=".{3,99}" requiredname="precio_venta" id="precio_venta" maxlength="35">
							</div>
						</div> 
					</div>
				</div>
			</fieldset>

			<br>
			<fieldset>
				<legend><i class="fas fa-user-lock"></i> &nbsp; Actualizar Inventario</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Proveedor</label>
                                <select name="tipokardex" class="form-control" id="exampleFormControlSelect1">
                                    <option value="0">Seleccionar</option>
                                    <option value="1">ENTRADA</option>
                                    <option value="2">SALIDA</option>
                                </select>
                              </div>
                        </div>



						<div class="col-12 col-md-2">
							<div class="form-group">
								<label for="usuario_email" class="bmd-label-floating">Cantidad</label>
								<input type="text"  value="0" required class="form-control" name="cantidad" id="cantidad_min" maxlength="70">
							</div>
						</div>
						 
					</div>
				</div>
			</fieldset>



			<br>
			<fieldset>
				<legend><i class="fas fa-user-lock"></i> &nbsp; Cantidades de Producto</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-2">
							<div class="form-group">
								<label for="usuario_usuario" class="bmd-label-floating">Cantidad Maxima</label>
								<input type="text"  disabled="true" value="<?= $r['cantidad_max'] ?>" class="form-control" name="cantidad_max" id="cantidad_max" maxlength="15">
							</div>
						</div>
						<div class="col-12 col-md-2">
							<div class="form-group">
								<label for="usuario_email" class="bmd-label-floating">Cantidad Minima</label>
								<input type="text" disabled="true" value="<?= $r['cantidad_min'] ?>" required class="form-control" name="cantidad_min" id="cantidad_min" maxlength="70">
							</div>
						</div>
						<div class="col-12 col-md-2">
							<div class="form-group">
								<label for="usuario_clave_1" class="bmd-label-floating">Stock</label>
								<input name="cantidadActual" type="text" readonly required value="<?= $r['stock'] ?>" class="form-control" name="stock" id="stock" maxlength="200">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_clave_2" class="bmd-label-floating">Fecha Registro</label>
								<input type="text" disabled="true" value="<?= $r['fecha_registro'] ?>" required class="form-control" name="fecha_registro" id="fecha_registro" maxlength="200">
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<br>
			<p class="text-center" style="margin-top: 20px;">
				<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR FORMULARIO</button>
				&nbsp; &nbsp;
				<button type="submit" name="actualizar" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
			</p>
		</form>
	</div>
</section>
</main>
<script>
            function SoloNumeros(evt)
            {
            if(window.event){
            keynum = evt.keyCode;
            }
            else{
            keynum = evt.which;
            }

            if((keynum > 47 && keynum < 58) || keynum == 8 || keynum== 13)
            {
            return true;
            }
            else
            {
            alert("Ingresar solo numeros");
            return false;
            }
            }
</script>

<?php require 'shared/footer.php'; ?>