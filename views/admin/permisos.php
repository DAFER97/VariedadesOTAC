<?php 

$db = Database::connect();
require_once 'models/Auth.php';
require_once 'models/Admin.php';



$permiso = new Admin();


$_SESSION['objeto'] = $_GET['objeto'];
$resul = $permiso->permisos($_SESSION['objeto']); //permisos 
$menu = $_GET['objeto'] ;
$rol  = $_SESSION['admin']['TBL_MS_ROLES_id_rol'];

 $sql    ="SELECT *FROM tbl_ms_permisos WHERE TBL_MS_OBJETOS_id_objeto ='$menu'  AND TBL_MS_ROLES_id_rol ='$rol' ";
 $result  = mysqli_query($db,$sql);
 $row    = mysqli_fetch_row($result);


  $insercion  = $row[3]   ;
  $eliminacion =  $row[4]  ;
  $actualizacion = $row[5]  ;
  $consultar  = $row[6]  ;

 //INSERTO 

//NUEVOOO PARA LOS PERMISOS


$admin =new Admin();
$Accion = "INGRESO";
$Descripción = "INGRESO DEL MODULO DE PERMISOS";
$_SESSION['menu'] = $_GET['objeto'];
$admin->bitacora($_SESSION['menu'],$Accion,$Descripción);


    if(!isset($_SESSION['admin'])){
        header("location:" . base_url);
	}
     require 'shared/header.php';
?>  

<?php if($consultar != 0) :?>

<div id="permisos" data-insercion=<?=$insercion?> data-eliminacion= <?=$eliminacion?>  data-actualizacion=<?=$actualizacion?> data-consultar=<?=$consultar?>></div>

<?php endif; ?>

	<title>Lista usuarios</title>
    <section class="full-box page-content">
		
			<!-- Page header -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PERMISOS
				</h3>
        <a href='reportePermisos' class="btn btn-danger btn_new_cliente"><i class="fa fa-file-pdf-o"></i> Reporte</a>
			</div>

		<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Modal -->
  <div id="modalCRUD" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Contenido del modal -->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p class="text-center" id="titulo">

          </p>
          <hr>
          <form id="form">


            <?php
            $sql = "SELECT * FROM tbl_ms_roles";
            $mysqli = database::connect();
            $roles = mysqli_query($mysqli, $sql);
            ?>
            <select name="rol" id="rol" class="form-control mr-2" required>
              <option value="" hidden="true">--Seleccione el Rol del Usuario--</option>
              <?php while ($rol = $roles->fetch_object()) : ?>
                <option value="<?= $rol->id_rol ?>">
                  <?= $rol->rol ?>
                </option>
              <?php endwhile; ?>
            </select>
            <br>
            <?php
            $sql = "SELECT * FROM tbl_ms_objetos";
            $mysqli = database::connect();
            $objeto = mysqli_query($mysqli, $sql);
            ?>
            <select name="objeto" id="objeto" class="form-control mr-2" required>
              <option value="" hidden="true">--Seleccione el Menu--</option>
              <?php while ($obj = $objeto->fetch_object()) : ?>
                <option value="<?= $obj->id_objeto ?>">
                  <?= $obj->objeto ?>
                </option>
              <?php endwhile; ?>
            </select>
            <br>
            <h4>Permisos</h4>

            <input type="text" name="id" id="id" hidden class="form-control hidden" placeholder="" aria-describedby="helpId">

            <div class="form-check">
              <input type="checkbox" class="form-check-input" name="agregar" id="agregar">
              <label class="form-check-label" for="agregar">Insertar</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" name="eliminar" id="eliminar">
              <label class="form-check-label" for="eliminar">Eliminar</label>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" name="actualizar" id="actualizar">
              <label class="form-check-label" for="actualizar">Editar</label>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" name="mostrar" id="mostrar">
              <label class="form-check-label" for="mostrar">Mostrar</label>
            </div>

          </form>

        </div>
        <div class="modal-footer">

          <button type="submit" class="btn btn-success" id='btnGuardar'></button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">

      <?php if($consultar) : ?>
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"></h3>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabla" class="table table-bordered table-striped">
                <thead class="text-center">
                    <tr>
                      <th>Codigo</th>
                      <th>Rol</th>
                      <th>Menu</th>
                      <th>Permiso_Insertar</th>
                      <th>Permiso_Eliminar</th>
                      <th>Permiso_Actualizar</th>
                      <th>Permiso_Mostrar</th>
                      <th>Creado por </th>
                      <th>Fecha creación</th>
                      <th>Modificado por</th>
                      <th>Fecha modificación</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
	</main>
	
<?php else : ?>
  <h1 class="text-center">No tienes permisos para ingresar a este menu</h1>;
<?php endif ;?>
<?php require 'shared/footer.php'; ?>
<!-- <script type="text/javascript" src="scripts/concepto.js"></script> -->
<script src="<?= base_url ?>assets/permisos.js"></script>




