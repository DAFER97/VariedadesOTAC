<?php
$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=2;
$Accion="Ingreso";
$Descripción="Ingreso a recuperación por correo";
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
<script src="../public/js/jquery.js"></script>
<script src="../public/js/bootstrap.js"></script>
<script src="../public/js/jquery.nanoscroller.min.js"></script>
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

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
    <h3 align="center">Recuperar contraseña</h3>
<form role="form" method="post" action="<?php echo base_url . "Auth/VerificarCorreo" ?>">
<label>Ingrese su usuario:</label>
<div class="input-group">
<span class="input-group-addon"><i class="fa fa-user"></i></span>
<input class="form-control" maxlength="15" type="text" id="InputUsuario" onkeyup="javascript:this.value=this.value.toUpperCase();" name="InputUsuario" required>
</div>


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
<button type="submit" class="btn btn-success col-xs-12" id="btncorreo" name="btncorreo">Enviar</button>
<center><input type="button" class="btn btn-success "  value="Regresar" onClick="history.go(-1);">
</div></center>
</div>
</form>
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
<script>
$(function() 
{
        $('#InputCorreo').on('keypress', function(e) {
            if (e.which == 32)
            {
                return false;
            }
        });
    });
 </script>

       
</body>
</html>
