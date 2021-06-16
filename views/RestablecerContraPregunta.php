<?php
$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=6;
$Accion="Ingreso";
$Descripción="Ingreso a restablecer contraseña por pregunta";
$Auth->InsertarBitacora($No_Pantalla,$Accion,$Descripción);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Sistema Variedades OTAC</title>
<!-----------------------Documentos necesarios para dar estilo y formato------------------------------->
<link rel="stylesheet" type="text/css" href="../public/css/bootstrap/bootstrap.min.css"/>
<script src="../public/js/demo-rtl.js"></script>
<link rel="stylesheet" type="text/css" href="../public/css/libs/font-awesome.css"/>
<link rel="stylesheet" type="text/css" href="../public/css/libs/nanoscroller.css"/>
<link rel="stylesheet" type="text/css" href="../public/css/compiled/theme_styles.css"/>
<link type="image/x-icon" href="favicon.png" rel="shortcut icon"/>
<script src="../public/js/jquery.js"></script>
<script src="../public/js/bootstrap.js"></script>
<script src="../public/js/jquery.nanoscroller.min.js"></script>
<!-----------------------Documentos necesarios para dar estilo y formato------------------------------->
</head>
 <body>

 <div class="container">
<div class="row">
<div class="col-xs-12">
<div id="login-box">
<div id="login-box-holder">
<div class="row">
<div class="col-xs-12">

<div id="login-box-inner">
    <h3 align="center">Restablecer contraseña</h3>
<form role="form" method="post" action="<?php echo base_url . "Auth/ValidarRestablecer" ?>">
<br>
<h6><b>Ingrese la contraseña</b></h6>
<div class="input-group">
<span  class="input-group-addon"><i class="fa fa-eye" onclick="ShowPass1()" style="color:black;"></i></span>
<input class="form-control" pattern="^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{5,10}$" minlength="5" maxlength="10" type="password" id="Contranueva" name="Contranueva" placeholder=""required>
</div>

<br>
<h6><b>Repita la contraseña</b></h6>
<div class="input-group">
<span  class="input-group-addon"><i class="fa fa-eye" onclick="ShowPass2()" style="color:black;"></i></span>
<input type="password" class="form-control" pattern="^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{5,10}$" minlength="5" maxlength="10" id="Confirnueva" name="Confirnueva" placeholder="" required>
</div>
<span id='message'></span>
<br>
<h6>Su contraseña debe seguir las siguientes indicaciones: <br>
● Debe contener de 5 a 10 caracteres. <br>
● Debe contener mayusculas y minusculas.<br>
● Debe contener números.<br>
● Debe utilizar caracteres especiales.
</h6>


<div id="remember-me-wrapper">
<div class="row">
<div class="col-xs-6">
<div class="checkbox-nice">

</div>
</div>

</div>
</div>
<div class="row">
<div class="col-xs-12">
<button type="submit" class="btn btn-success col-xs-12" name="btnrestablecerpregun">Actualizar contraseña</button>
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
        $('#Contranueva,#Confirnueva').on('keypress', function(e) {
            if (e.which == 32)
            {
                return false;
            }
        });
    });

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