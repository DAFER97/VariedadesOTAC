
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

<span style="color:#1FBF92;"> <h3> <center> Preguntas de seguridad como método de recuperación de cuenta </center></h3> </span>
<div id="login-box-inner">
<?php
$db = Database::connect();
$query = $db->query("SELECT * FROM `tbl_ms_preguntas` where estado='1'");
//var_dump($query);  
?>
<form role="form" method="POST" action="<?php echo base_url . "Auth/PreguntaSeguridad" ?>">

<br>
<div class="select-group">
<select class="form-control" id="selectpregunta" name="selectpregunta" required>
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
<input type="button" class="btn btn-success "  value="Regresar" onClick="window.location.href = 'http://localhost/variedades-OTAC/';">
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

 </script>
       
</body>
</html>