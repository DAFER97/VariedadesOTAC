<?php
$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=36;
$id_usuario = $_SESSION['admin']['id_usuario'];
$Accion="EDITAR CLIENTES";
$Descripción="INGRESO A EDICION DE CLIENTES POR ADMINISTRACION";
$Auth->InsertarBitacoraSis($id_usuario,$No_Pantalla,$Accion,$Descripción);

if (!isset($_SESSION['admin'])) {
	header("location:" . base_url);
}
require 'shared/header.php';
//require 'models/Admin.php';

$id = $_GET['id'];
$Admin =  new Admin();
$result = $Admin->ObtenerCliente($id);
$r = mysqli_fetch_assoc($result);

?>
<title>Editar Cliente</title>
<!-- Page content -->


	<!-- Page header -->
	<div class="full-box page-header">
		<h3 class="text-left">
			<i class="fas fa-plus fa-fw"></i> &nbsp; EDITAR CLIENTE
		</h3>
	</div>
	<!-- Content -->
	<div class="container-fluid">
		<form method="POST" action="<?php echo base_url ?>admin/Actualizarcliente&id=<?= $r['id_cliente'] ?>" class="form-neon" autocomplete="off">
			<fieldset>
				<legend><i class="far fa-address-card"></i> &nbsp; Información del Cliente</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="nombre_cliente" class="bmd-label-floating">NOMBRE CLIENTE</label>
								<input type="text" required value="<?= $r['nombre_cliente'] ?>"  required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="nombre_cliente" id="nombre_producto" maxlength="40">
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="DNI" class="bmd-label-floating">DNI O CODIGO DEL CLIENTE</label>
								<input class="form-control" onkeypress="return SoloNumeros(event);" pattern=".{1,99}" required value="<?= $r['DNI'] ?>" name="DNI" id="DNI"  minlength="1" maxlength="13">
							</div>
						</div>
						<div class="col-12 col-md-4">
                            <div class="form-group">
                            <label for="telefono_cliente" class="bmd-label-floating">Telefono del Cliente</label>
                                <input required value="<?= $r['telefono_cliente'] ?>"class="form-control" name="telefono_cliente" id="telefono_cliente"  minlength="8"  onkeypress="return SoloNumeros(event);" pattern=".{3,99}" maxlength="8">
                            </div>
                    </div>
                    <div class="col-12 col-md-4">
                            <div class="form-group">
                            <label for="direccion_cliente" class="bmd-label-floating">Dirección del Cliente</label>
                                <input required value="<?= $r['direccion_cliente'] ?>" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="direccion_cliente" id="direccion_cliente"  minlength="3" maxlength="15">
                            </div>
                    </div>
					</div>
				</div>
			</fieldset>
			<br>
			
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