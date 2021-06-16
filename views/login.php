<?php
if (isset($_SESSION['admin'])) {
	header("location:" . base_url."admin/principal");
}
$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=1;
$Accion="Ingreso";
$Descripción="Ingreso a iniciar sesión";
$Auth->InsertarBitacora($No_Pantalla,$Accion,$Descripción);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Sistema Variedades-OTAC</title>

    <link rel="stylesheet" type="text/css" href="public/css/bootstrap/bootstrap.min.css" />
    <script src="public/js/demo-rtl.js"></script>
    <link rel="stylesheet" type="text/css" href="public/css/libs/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="public/css/libs/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="public/css/compiled/theme_styles.css" />
    <link type="image/x-icon" href="favicon.png" rel="shortcut icon" />

</head>

<body id="login-page">
    <div class="container">
        <div class="row">
            <div class="col-xs-18">
                <div id="login-box">
                    <div id="login-box-holder">
                        <div class="row">
                            <div class="col-xs-18">
                                <header id="login-header">
                                    <div id="login-logo">
                                        
                                        <h6><img src= "img/otac.jpg" height="180" width="220"><h5 style="color:white;">Iniciar sesión</h5></h6>
                                        
                                    </div>
                                </header>
                                <div id="login-box-inner">
                                    <form role="form" method="POST"
                                        action="<?php echo base_url . "Auth/Validalogin" ?>">
                                        <h6 align="center"><b>USUARIO</b></h6>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input class="form-control" type="text"
                                                onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-z A-Z]/g,'');"
                                                maxlength="15" minlength="2" type="text"
                                                placeholder="" name="usuario" id="usuario"
                                                required>
                                        </div>
                                        <br>
                                        <h6 align="center"><b>CONTRASEÑA</b></h6>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-eye" onclick="ShowPass()"
                                                    style="color:black;"></i></span>
                                            <input type="password" minlength="2" maxlength="15" class="form-control"
                                                placeholder="" name="password" id="password"
                                                required>
                                        </div>


                                        <div id="remember-me-wrapper">
                                            <div class="row">
                                                <a href="<?= base_url ?>inicio/Recuperacion" id="login-forget-link">
                                                    <center><b><em>¿Olvidaste tu contraseña?</em></b></center>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button type="submit" class="btn btn-success col-xs-12"
                                                    name="login">Ingresar</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <?php if (isset($_SESSION['mensaje'])) : ?>
                                            <div class="alert alert-danger" role="alert">
                                            <?=$_SESSION['mensaje']?>
                                            </div>
                                        </div>
                                        <?php endif;
                                              unset($_SESSION['mensaje']);?>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="login-box-footer">
                    <div class="row">
                        <div class="col-xs-12">
                            <b>¿No tienes cuenta?</b>
                            <a href="<?= base_url ?>inicio/registro">
                                <b><em>Regístrate aquí</em></b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="public/js/demo-skin-changer.js"></script>
    <script src="public/js/jquery.js"></script>
    <script src="public/js/bootstrap.js"></script>
    <script src="public/js/jquery.nanoscroller.min.js"></script>
    <script src="public/js/demo.js"></script>
    <script src="public/js/scripts.js"></script>

    <script>
    $(function() {
        $('#usuario,#password').on('keypress', function(e) {
            if (e.which == 32) {
                return false;
            }
        });
    });

    function ShowPass() {
        var x = document.getElementById("password");
        if (x.type === "password") {

            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    </script>
</body>


</html>