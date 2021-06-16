<?php
$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=9;
$id_usuario = $_SESSION['admin']['id_usuario'];
$Accion="INGRESO";
$Descripción="INGRESO A EDICION DE USUARIOS POR ADMINISTRACION";
$Auth->InsertarBitacoraSis($id_usuario,$No_Pantalla,$Accion,$Descripción);

if (!isset($_SESSION['admin'])) {
	header("location:" . base_url);
}
require 'shared/header.php';
//require 'models/Admin.php';

$id = $_GET['id'];
$Admin =  new Admin();
$result = $Admin->ObtenerUsuario($id);
$r = mysqli_fetch_assoc($result);

?>
<title>Editar usuario</title>
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
			<i class="fas fa-plus fa-fw"></i> &nbsp; EDITAR USUARIO
		</h3>
	</div>
	<div class="container-fluid">
		<ul class="full-box list-unstyled page-nav-tabs">
			<li>
				<a href="usuarios"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
			</li>
		</ul>
	</div>
	<!-- Content -->
	<div class="container-fluid">
		<form method="POST" action="<?php echo base_url ?>admin/actualizaUsuario&id=<?= $r['id_usuario'] ?>" class="form-neon" autocomplete="off">
			<fieldset>
				<legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
								<input type="text" required value="<?= $r['nombre_usuario'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="nombre" id="usuario_nombre" maxlength="35">
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
								<input type="text" required value="<?= $r['apellido_usuario'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="apellido" id="usuario_apellido" maxlength="35">
							</div>
						</div>
						&nbsp;
						<div class="col-12 col-md-4">
							<select class="form-control" name="sexo">
								<option value="<?= $r['genero_usuario'] ?>" selected="<?= $r['genero_usuario'] ?>"><?= $r['genero_usuario'] ? $r['genero_usuario'] : 'Seleccione el sexo' ?> </option>
								<option value="M">M</option>
								<option value="F">F</option>
							</select>
						</div>
					</div>
				</div>
			</fieldset>
			<br>
			<fieldset>
				<legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_usuario" class="bmd-label-floating">Usuario</label>
								<input type="text" value="<?= $r['usuario'] ?>" required pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usuario" id="usuario_usuario" maxlength="35">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_email" class="bmd-label-floating">Email</label>
								<input type="email" value="<?= $r['correo_usuario'] ?>" required class="form-control" name="correo" id="correo" maxlength="70">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_clave_1" class="bmd-label-floating">Contraseña</label>
								<input type="password" disabled="true" required value="<?= $r['contrasena'] ?>" class="form-control" name="pass" id="usuario_clave_1" maxlength="200">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_clave_2" class="bmd-label-floating">Repetir contraseña</label>
								<input type="password" disabled="true" value="<?= $r['contrasena'] ?>" required class="form-control" name="pass1" id="usuario_clave_2" maxlength="200">
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<br>
			<fieldset>
				<legend><i class="fas fa-medal"></i> &nbsp; Nivel de privilegio</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								
									
									<div class="form-group">
										<select class="form-control" name="rol">
											<?php
											 $admin = new Admin();
											 $roles = $admin->roles();
											foreach ($roles as $rr) { ?>
												<option value="<?= $rr['id_rol'] ?>" <?= $rr['id_rol'] == $r['TBL_MS_ROLES_id_rol']  ? 'selected' : ''?>>
												     <?=  $rr['rol'] ?>
												</option>
											<?php } ?>
										</select>
									</div>

							</div>
							<legend><i class="fas fa-medal"></i> &nbsp; Estado del Usuario</legend>
							<div class="form-group">
								<select class="form-control" name="estado">
								<option value="<?= $r['id_estado_usuario'] ?>" selected="<?= $r['id_estado_usuario'] ?>"><?= $r['id_estado_usuario'] == 1 ? 'Activo' : 'Desactiavado' ?> </option>
								<option  value="1">Activo</option>
								<option value="2" >Desactivado</option>
							</select>
                            </div>
						</div>
					</div>
				</div>
			</fieldset>
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
</script>

<?php require 'shared/footer.php'; ?>