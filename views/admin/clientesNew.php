<?php

if (!isset($_SESSION['admin'])) {
    header("location:" . base_url);
}

require 'shared/header.php';
require_once 'models/Admin.php';
require_once 'models/Auth.php';
$Auth = new Auth();
$No_Pantalla=38;
$id_usuario = $_SESSION['admin']['id_usuario'];
$Accion="INGRESO";
$Descripción="INGRESO A CREACION DE CLIENTES POR ADMINISTRACION";
$Auth->InsertarBitacoraSis($id_usuario,$No_Pantalla,$Accion,$Descripción); ?>
<title>Clientes</title>
<!-- Page content -->


    <!-- Page header -->
   <div class="full-box page-header">
                <h3 class="text-left">
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; NUEVO CLIENTE
                </h3>
            </div>
        </ul>
    </div>
    <div class="container-fluid">
        <ul class="full-box list-unstyled page-nav-tabs">
            <li>
                <a href="clientes"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CLIENTES</a>
            </li>
        </ul>
    </div>
    <!-- Content -->
    <div class="container-fluid">
        <form method="POST" action="<?php echo base_url . "admin/Crearcliente" ?>" class="form-neon" autocomplete="off">
            <fieldset>
                <legend><i class="far fa-address-card"></i> &nbsp; Información del Cliente</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                        <label for="nombre_cliente" class="bmd-label-floating">NOMBRE DEL CLIENTE</label>
                                <input class="form-control" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" name="nombre_cliente" id="nombre_cliente"  minlength="2" maxlength="35">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                            <label for="DNI" class="bmd-label-floating">DNI O CODIGO DEL CLIENTE</label>
                                <input class="form-control" onkeypress="return SoloNumeros(event);" pattern=".{1,99}" required name="DNI" id="DNI"  minlength="1" maxlength="13">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                            <label for="telefono_cliente" class="bmd-label-floating">TELEFONO DEL CLIENTE</label>
                                <input class="form-control" onkeypress="return SoloNumeros(event);" pattern=".{3,99}" required  name="telefono_cliente" id="telefono_cliente"  minlength="8" maxlength="8">
                            </div>
                    </div>
                    <div class="col-12 col-md-4">
                            <div class="form-group">
                            <label for="direccion_cliente" class="bmd-label-floating">DIRECCION DEL CLIENTE</label>
                                <input class="form-control" name="direccion_cliente" id="direccion_cliente" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" minlength="10" maxlength="20">
                            </div>
                    </div>
                </div>
            </fieldset>
            <br>
            
                      
            <p class="text-center" style="margin-top: 20px;">
                <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR FORMULARIO</button>
                &nbsp; &nbsp;
                <button type="submit" name="crear" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
                <br>
                <?php if (isset($_SESSION['msg'])) : ?>
                    <strong class="alert-danger text-center"><?= $_SESSION['msg'] ?></strong>
                <?php endif;
                unset($_SESSION['msg']); ?>
            </p>
        </form>
    
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