<?php 

$db = Database::connect();
require_once 'models/Auth.php';


$admin =new Admin();
$Accion = "Ingreso";
$Descripción = "Ingreso a módulo de roles";
$_SESSION['menu'] = $_GET['objeto'];
$admin->bitacora($_SESSION['menu'],$Accion,$Descripción);

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

 //INSERTO 

if($consultar==0){
   echo '<h1>No tienes permisos para ingresar a este menu</h1>';
   die();

}


    if(!isset($_SESSION['admin'])){
        header("location:" . base_url);
	}
     require 'shared/header.php';
     require_once 'models/Admin.php'?>
<div id="permisos" data-insercion=<?=$insercion?> data-eliminacion= <?=$eliminacion?>  data-actualizacion=<?=$actualizacion?> data-consultar=<?=$consultar?>></div>
	<title>Lista de roles</title>
    <section class="full-box page-content">
		
			<!-- Page header -->
			<div class="full-box ">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ROLES

				</h3>
			</div>

	

    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
            <?php if($consultar !=0)  :?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                            <a href='reporteRol' class="btn btn-danger btn_new_cliente"><i class="fa fa-file-pdf-o"></i> Reporte</a>

                            <!-- /.card-header -->
                            <div class="card-body">


                                <!-- <hr>
                                <br> -->
                                <table id="tabla" class="table table-striped" cellspacing="0" width="100%">

                                </table>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<?php else : ?>

    <h1 class="text-center">No tienes permisos para ingresar a este menu</h1>;

<?php endif; ?>
</div>
<!-- /.content-wrapper -->
</main>

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
                    <div class="from-group">
                        <input type="text" name="id" id="id" hidden class="form-control hidden" placeholder="" aria-describedby="helpId">
                    </div>

                    <div class="from-group">
                        <label> Nombre del Rol</label>
                        <input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="nombre_rol" id="nombre_rol"  minlength="2" maxlength="20">

                    </div>
                    <div class="from-group">
                        <label> Descripción del Rol</label>
                        <input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="descripcion_rol" id="descripcion_rol"  minlength="2" maxlength="20">
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
	
	
<?php require 'shared/footer.php'; ?>
<!-- <script type="text/javascript" src="scripts/concepto.js"></script> -->
<script src="<?= base_url ?>assets/roles.js"></script>

<script>
    function espacio(id) {

        var respuesta = false;
        var flag = false;
        var teclaAnterior = "";
        $(id).keydown(function(e) {
            teclaAnterior = teclaAnterior + " " + event.keyCode;
            console.log(teclaAnterior);
            var arregloTA = teclaAnterior.split(" ");
            console.log(arregloTA);
            console.log(arregloTA[arregloTA.length - 2]);
            if (event.keyCode == 32 && arregloTA[arregloTA.length - 2] == 32) {
                e.preventDefault();

            }
        });

        return respuesta
    }
    function sinespacio(id) {

        var respuesta = false;
        var teclaAnterior = "";
        $(id).keydown(function(e) {
            if (event.keyCode == 32) {
                e.preventDefault();
            }
        });

        return respuesta
    }
    espacio('#nombre_rol');
    espacio('#descripcion_rol');
</script> 


