
<?php
$db = Database::connect();
require_once 'models/Auth.php';

$Auth = new Auth();
$No_Pantalla=3;
$Accion="Ingreso";
$Descripción="Ingreso a recuperación por pregunta";
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
  <br>
  <br>
<?php
$db = Database::connect();
$query = $db->query("SELECT * FROM `tbl_ms_preguntas` where estado='1'");
//var_dump($query);  
?>

<br>
<form role="form" method="POST" action="<?php echo base_url . "Auth/VerificarPregunta" ?>">
<div class="input-group">
<span class="input-group-addon"><i class="fa fa-user"></i></span>
<input class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();this.value=this.value.replace(/[^a-z A-Z]/g,'');" id="inputusuario" name="inputusuario" type="text" placeholder="Ingrese su nombre de usuario" required maxlength="15">
</div>
<br>
<div class="select-group">
<select class="form-control" id="selectpregunta" name="selectpregunta">
<?php
                 
while ($valores = mysqli_fetch_array($query)) {
                        
  echo '<option value="'.$valores['id_pregunta'].'">'.$valores['pregunta'].'</option>';
}
?>
</select>
</div>                          
<br>

<div class="input-group">
<span class="input-group-addon"><i class="fa fa-question"></i></span>
<input type="text" class="form-control"  onkeyup="javascript:this.value=this.value.toUpperCase();" id="inputrespuesta" name="inputrespuesta"  placeholder="Ingrese su respuesta" required maxlength="30">
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
<button type="submit" id="btnrespuesta" name="btnrespuesta" class="btn btn-success col-xs-12">Ingresar respuesta</button>

<center><input type="button"  style="margin-left:0px" class="btn btn-danger col-xs-5"  value="Cancelar" onClick="window.location.href = 'http://localhost/variedades-OTAC/';">
<input type="button"  style="margin-left:48px"class="btn btn-warning col-xs-5"  value="Regresar" onClick="history.go(-1);">

</div></center>
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

<script>
  document.getElementById("inputrespuesta").addEventListener("keydown", teclear);

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

$(function() 
{
        $('#inputusuario').on('keypress', function(e) {
            if (e.which == 32)
            {
                return false;
            }
        });
    });


 </script>
       
</body>
</html>