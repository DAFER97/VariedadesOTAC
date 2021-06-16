<?php

if (!isset($_SESSION['admin'])) {
    header("location:" . base_url);
}

require 'shared/header.php';
require_once 'models/Admin.php';
require_once 'models/Auth.php';
$Auth = new Auth();
$No_Pantalla=32;
$id_usuario = $_SESSION['admin']['id_usuario'];
$Accion="INGRESO";
$Descripción="INGRESO A CREACION DE PROVEEDORES POR ADMINISTRACION";
$Auth->InsertarBitacoraSis($id_usuario,$No_Pantalla,$Accion,$Descripción); ?>
<title>Nuevo proveedor</title>
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
            <i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PROVEEDOR
        </h3>
    </div>
    <div class="container-fluid">
        <ul class="full-box list-unstyled page-nav-tabs">
            <li>
                <a href="proveedores"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PROVEEDORES</a>
            </li>
        </ul>
    </div>
    <!-- Content -->
    <div class="container-fluid">
        <form method="POST" action="<?php echo base_url . "admin/crearproveedor" ?>" class="form-neon" autocomplete="off">
            <fieldset>
                <legend><i class="far fa-address-card"></i> &nbsp; Información del proveedor</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="usuario_nombre" class="bmd-label-floating">PROVEEDOR</label>
                                <input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="proveedor" id="proveedor"  minlength="2" maxlength="30">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="usuario_apellido" class="bmd-label-floating">CONTACTO O REFERENCIA</label>
                                <input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="contacto" id="contacto" minlength="2" maxlength="25">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="usuario_nombre" class="bmd-label-floating">TELEFONO</label>
                                <input class="form-control" onkeypress="return SoloNumeros(event);" pattern=".{3,99}" required  name="telefono" id="telefono"  minlength="8" maxlength="8">
                       </div>
                    </div>
                    <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="usuario_apellido" class="bmd-label-floating">DIRECCIÓN</label>
                                <input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="direccion" id="direccion" minlength="2" maxlength="30">
                            </div>
                        </div>
                </div>
            </fieldset>
        <p class="text-center" style="margin-top: 20px;">
                <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR FORMULARIO</button>
                &nbsp; &nbsp;
                <button type="submit" name="crear" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
                <br>
                <?php if (isset($_SESSION['msg'])) : ?>
                    <strong class="alert-danger text-center"><?= $_SESSION['msg'] ?></strong>
                <?php endif;
                unset($_SESSION['msg']); ?>

</p >
              
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

            
                
 
</script>
<?php require 'shared/footer.php'; ?>