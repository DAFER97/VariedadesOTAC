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

 $insercion   = $row[3]  ;
 $eliminacion =  $row[4]  ;
 $actualizacion = $row[5]  ;
 $consultar  = $row[6]  ;
//NUEVOOO PARA LOS PERMISOS

$Auth = new Auth();
$No_Pantalla=8;
$id_usuario = $_SESSION['admin']['id_usuario'];
$Accion="INGRESO";
$Descripción="INGRESO AL MODULO DE OBJETOS POR ADMINISTRACION";
$Auth->InsertarBitacoraSis($id_usuario,$No_Pantalla,$Accion,$Descripción);


    if(!isset($_SESSION['admin'])){
        header("location:" . base_url);
	}
     require 'shared/header.php';
?>


<?php if($consultar != 0  ):  ?>
<div id="permisos" data-insercion=<?=$insercion?> data-eliminacion= <?=$eliminacion?>  data-actualizacion=<?=$actualizacion?> data-consultar=<?=$consultar?>></div>
<?php endif ; ?>

	<title>Lista usuarios</title>
    <section class="full-box page-content">
		
			<!-- Page header -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE MENUS
				</h3>
			</div>
<a href='reporteObjeto' class="btn btn-danger btn_new_cliente"><i class="fa fa-file-pdf-o"></i> Reporte</a>
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
            <input type="text" name="id" id="id" hidden class="form-control hidden" placeholder="" aria-describedby="helpId">

            <!-- Grupo: Usuario -->
            <div class="from-group">
              <label>Menu</label>
              <input type="text" name="menu" id="menu" class="form-control mr-2 mb-2"required="true" onkeypress="return soloLetrasNumeros(event)" onkeyup="return MaysPrimera(this);">
            </div>
            <!-- Grupo: Usuario -->
            <div class="from-group">
              <label>Descripcion</label>
              <input type="text" name="descripcion" id="descripcion" class="form-control mr-2 mb-2" onkeypress="return soloDireccion(event)" onkeyup="return MaysPrimera(this);">
            </div>
            <!-- Tipo de objeto -->
            <div class="from-group">
              <label>Tipo de objeto</label>
              <input type="text" name="tipo_objeto" id="tipo_objeto" class="form-control mr-2 mb-2"  required="true">
            </div>
            <!-- Grupo: Usuario -->
            <div class="from-group">
              <label>Icono</label>
              <input type="text" name="icono" id="icono" class="form-control mr-2 mb-2"  required="true">
            </div>
            <!-- Grupo: Usuario -->
            <div class="from-group">
              <label>Url</label>
              <input type="text" name="url" id="url" class="form-control mr-2 mb-2" required="true">
            </div><br>
            <label>Estado:</label>
            <select name="estado" id="estado" class="form-control" require="true" required>
              <option value="" hidden="true">--Seleccione el estado del Menu--</option>
              <option value="activo">Activo</option>
              <option value="Desactivo">Desactivo</option>
            </select>
            <br>
            <!-- Grupo: Usuario -->
            <div class="from-group">
                         <label>Menu Padre: </label>
                        <!-- <?php
                        $sql = "SELECT * FROM tbl_ms_objetos where idPadre = 0";
                        $mysqli = database::connect();

                        $roles = mysqli_query($mysqli, $sql);

                        ?> -->
                        <select name="menupadre" id="menupadre" class="form-control mr-2" required>
                            <option value="" hidden="true">--Seleccione el menu padre--</option>
                            <option value="0">Ninguno</option>
                            <?php while ($rol = $roles->fetch_object()) : ?>
                                <option value="<?= $rol->id_objeto ?>">
                                    <?= $rol->objeto ?>
                                </option>
                            <?php endwhile; ?>
                        </select> 
                    </div>
               <div class="form-group">
                    <label for="fec_registro" id="label6">Fecha de Registro:</label>
                  <input type="text" name="fec_registro" value="<?php echo date("yy-M-d h:ia"); ?>" id="fec_registro" class="form-control mr-2" placeholder="Fecha Registro" disabled="true">
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

<?php  if($consultar) : ?>                  
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"></h3>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabla" class="table table-bordered table-striped">
        
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
    <?php  else : ?>

    <h1 class="text-center">No tienes permisos para ingresar a este menu</h1>;

    <?php endif; ?>	
	
<?php require 'shared/footer.php'; ?>
<!-- <script type="text/javascript" src="scripts/concepto.js"></script> -->
<script src="<?= base_url ?>assets/objetos.js"></script>


