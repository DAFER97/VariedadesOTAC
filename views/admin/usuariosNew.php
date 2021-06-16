<?php

if (!isset($_SESSION['admin'])) {
    header("location:" . base_url);
}

require 'shared/header.php';
require_once 'models/Admin.php';
require_once 'models/Auth.php';
$Auth = new Auth();
$No_Pantalla=8;
$id_usuario = $_SESSION['admin']['id_usuario'];
$Accion="INGRESO";
$Descripción="INGRESO A LA CREACION DE USUARIOS POR ADMINISTRACION";
$Auth->InsertarBitacoraSis($id_usuario,$No_Pantalla,$Accion,$Descripción); ?>
<title>Nuevo usuario</title>
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
            <i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO
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
        <form method="POST" action="<?php echo base_url . "admin/crearUsuarioss" ?>" class="form-neon" autocomplete="off">
            <fieldset>
                <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
                                <input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="nombre" id="usuario_nombre"  minlength="2" maxlength="20">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
                                <input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="apellido" id="usuario_apellido" minlength="2" maxlength="20">
                            </div>
                        </div>
                        &nbsp;
                        <div class="col-12 col-md-4">
                            <select class="form-control" name="sexo">
                                <option value="" selected="" disabled="">Seleccione el genero</option>
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
                                <input type="text" required onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" class="form-control" name="usuario" id="usuario" minlength="3" maxlength="12">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="usuario_email" class="bmd-label-floating">Email</label>
                                <input type="email" required class="form-control" name="correo" id="correo" maxlength="70">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="usuario_clave_1" class="bmd-label-floating">Contraseña</label>
                                <input type="password" required class="form-control" name="pass" id="pass" minlength="8" maxlength="12">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="usuario_clave_2" class="bmd-label-floating">Repetir contraseña</label>
                                <input type="password" required class="form-control" name="pass1" id="pass1" minlength="8" maxlength="12">
                                <span class="input-group-addon">Mostrar/Ocultar<i class="fa fa-eye" onclick="ShowPass1()" style="color:black;"></i></span>
                                <span id="message"></span>
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
                                <select class="form-control" name="rol" required>
                                    <?php
                                    $admin = new Admin();
                                    $roles = $admin->roles();
                                    foreach ($roles as $r) { ?>
                                        <option value="<?= $r['id_rol'] ?>"><?= $r['rol'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                        <legend><i class="fas fa-medal"></i> &nbsp; Estado del Usuario</legend>
                            <div class="form-group">
                                <select class="form-control" name="estado" required>
                                        <option value="1">Activo</option>
                                        <option value="2">Desactivado</option>
                                </select>
                            </div>
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
            </p>
        </form>
    </div>
</section>
</main>

<script>



    function ShowPass1() {
        var x = document.getElementById('pass');
        var y = document.getElementById('pass1');
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        if (y.type === "password") {
            y.type = "text";
        } else {
            y.type = "password";
        }
    }

    $(function() {
        $('#usuario,#pass,#pass1').on('keypress', function(e) {
            if (e.which == 32)
            {
                return false;
            }
        });
    });
</script>
<?php require 'shared/footer.php'; ?>