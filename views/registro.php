<?php
$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=4;
$Accion="Ingreso";
$Descripción="Ingreso a Autoregistro";
$Auth->InsertarBitacora($No_Pantalla,$Accion,$Descripción);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Variedades-OTAC</title>

    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap/bootstrap.min.css" />
    <script src="public/js/demo-rtl.js"></script>
    <link rel="stylesheet" type="text/css" href="../public/css/libs/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="../public/css/libs/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="../public/css/compiled/theme_styles.css" />

</head>

<body id="login-page" >
    <div class="container" >
        <div class="row" >
            <div class="col-xs-12" >
                <div id="login-box" >
                    <div id="login-box-holder" >
                        <div class="row">
                            <div class="col-xs-12">
                                <header id="login-header">
                                </header>
                                <div id="login-box-inner" >
                                    <h3 align="center">Autoregistro</h3>

                                    
                                    <form role="form" method="POST" action="<?php echo base_url . "Auth/RegisUsuarios" ?>">



                                        <br>
                                            <h6><b>Usuario:</b></h6>
                                    <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            
                                            <input class="form-control"  type="text" onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-z A-Z]/g,'');" placeholder="" minlength="3" maxlength="15" name="usuario" id="usuario" required>
                                        </div>
                                        <br>
                                            <h6><b>Nombre:</b></h6>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            <input class="form-control"  type="text" onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" placeholder="" name="nombre" id="nombre" maxlength="100" required>
                                        </div>
                                        <br>
                                            <h6><b>Apellido:</b></h6>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i>
</span>
                                            <input type="text"  class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-zA-Z\s]/g,'');" placeholder="" name="apellido" id="apellido" maxlength="100" required>
                                        </div>
                                        <br>
                                            <h6><b>Correo electronico:</b></h6>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                            <input type="email" class="form-control" placeholder="" name="correo" id="correo" maxlength="45" required>
                                        </div>
                                        <br>
                                            <h6><b>Contraseña:</b></h6>
                                        <div class="input-group">
                                        <span  class="input-group-addon"><i class="fa fa-eye" onclick="ShowPass1()" style="color:black;"></i></span>
                                            <input type="password" class="form-control" placeholder="" id="Contranueva" maxlength="100" name="password1" minlength="8" required>
                                        </div>
                                        <br>
                                            <h6><b>Repita contraseña:</b></h6>
                                        <div class="input-group">
                                        <span  class="input-group-addon"><i class="fa fa-eye" onclick="ShowPass2()" style="color:black;"></i></span>
                                            <input type="password" class="form-control" placeholder="" id="Confirnueva" maxlength="100" minlength="8" name="password2" required>
                                        </div>
                                        <br>
                                        <div class="select-group">
                                        <select class="form-control" id="selectgenero" name="selectgenero">
                                        <option value="N/A">Seleccione género:</option>
                                        <option value="F">F</option>
                                        <option value="M">M</option>
                                        </select>
                                        </div>
                                        <br>
                                        <h6>Su contraseña debe seguir las siguientes indicaciones: <br>
                                        ● Debe contener de 5 a 10 caracteres. <br>
                                        ● Debe contener mayusculas y minusculas.<br>
                                        ● Debe contener números.<br>
                                        ● Debe utilizar caracteres especiales.
                                        </h6>          
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button type="submit" class="btn btn-success col-xs-12" name="registro">Registrar</button>

                                                <center>            
                                                <b>¿Ya tienes cuenta?</b>
                                                <a href="<?= base_url ?>">
                                                    <b><em>Inicia sesión</em></b>
                                                </a>
                                              </center>
                                            </div>
                                            <span id="message"></span>
                                            <br>
                                            <br>
                                            <?php if (isset($_SESSION['exito'])) : ?>
                                              <strong class="alert-success text-center"><?=$_SESSION['exito'] ?></strong>
                                             <?php endif;
                                              unset($_SESSION['exito']);?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="login-box-footer">
                        <div class="row">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <script src="../public/js/demo-skin-changer.js"></script>
    <script src="../public/js/jquery.js"></script>
    <script src="../public/js/bootstrap.js"></script>
    <script src="../public/js/jquery.nanoscroller.min.js"></script>
    <script src="../public/js/demo.js"></script>
    <script src="../public/js/scripts.js"></script>

</body>
<!-- Mirrored from www.ravijaiswal.com/Afro-v.1.1/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 19 Mar 2017 03:30:10 GMT -->
</html>

<script>

    $('#Contranueva, #Confirnueva').on('keyup', function () {
    if ($('#Contranueva').val() == $('#Confirnueva').val()) {
        $('#message').html('Verificación de contraseña correcto').css('color', 'green');
    } else 
        $('#message').html('Las contraseñas nuevas no son iguales').css('color', 'red');
});

$(function() 
{
        $('#usuario,#correo,#Contranueva,#Confirnueva').on('keypress', function(e) {
            if (e.which == 32)
            {
                return false;
            }
        });
    });
document.getElementById("nombre").addEventListener("keydown", teclear);
document.getElementById("apellido").addEventListener("keydown", teclear);
var flag = false;
var teclaAnterior = "";

function teclear(event) 
{
  teclaAnterior = teclaAnterior + " " + event.keyCode;
  var arregloTA = teclaAnterior.split(" ");
  if (event.keyCode == 32 && arregloTA[arregloTA.length - 2] == 32) 
  {
    event.preventDefault();
  }
}
function ShowPass1() {
  var x = document.getElementById('Contranueva');
  if (x.type === "password") {
      
    x.type = "text";
  } else {
    x.type = "password";
  }
} 
function ShowPass2() {
  var x = document.getElementById('Confirnueva');
  if (x.type === "password") {
      
    x.type = "text";
  } else {
    x.type = "password";
  }
} 
    </script>
