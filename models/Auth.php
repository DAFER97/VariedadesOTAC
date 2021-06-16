<?php
class Auth
{
    private $db;
    public function __construct()
    {
        $this->db= Database::connect();
    }
//--------------------------------- FUNCIONES GENERALES INICIO ----------------------------------
/*
    public function Encriptar($Encriptada)
    {
            $ciphering = "AES-128-CTR"; 
            $iv_length = openssl_cipher_iv_length($ciphering); 
            $options = 0; 
            $encryption_iv = '1234567891011121'; 
            $encryption_key = "Variedadesotac"; 
            
            $encryption = openssl_encrypt($Encriptada, $ciphering, 
                        $encryption_key, $options, $encryption_iv); 
            return ($encryption);
              
    }

    public function Desencriptar($Desencriptada)
    {       $ciphering = "AES-128-CTR"; 
            $options = 0; 
            $decryption_iv = '1234567891011121'; 
            $decryption_key = "Variedadesotac"; 
        
            $decryption=openssl_decrypt ($Desencriptada, $ciphering,  
             $decryption_key, $options, $decryption_iv); 
           return ($decryption);  
    }
*/

/*
if ($_POST['action'] == 'addCliente') {
  $DNI = $_POST['DNI'];
  $nombre_cliente = $_POST['nombre_cliente'];
  $telefono_cliente = $_POST['telefono_cliente'];
  $direccion_cliente = $_POST['direccion_cliente'];
  $usuario_id = $_SESSION['idUser'];

  $query_insert = mysqli_query($conexion, "INSERT INTO cliente(DNI, nombre_cliente, telefono_cliente, direccion_cliente, usuario_id) VALUES ('$DNI','$nombre_cliente','$telefono_cliente','$direccion_cliente','$usuario_id')");
  if ($query_insert) {
    $codCliente = mysqli_insert_id($conexion);
    $msg = $codCliente;
  }else {
    $msg = 'error';
  }
  mysqli_close($conexion);
  echo $msg;
  exit;
}
*/


    public function proveedor($inputproveedor)
{
    $sql="SELECT id_proveedor from tbl_proveedores where proveedor = '$inputproveedor'";
    $stmt = $this->db->query($sql);
    if (mysqli_num_rows($stmt)>0) 
    {
     return $stmt; 
    }
    return false;
}
    public function ActivarUsuarioCorreo($Correo_url)
    {
        $sql="UPDATE tbl_ms_usuario SET id_estado_usuario ='1' 
        WHERE correo_usuario = '$Correo_url'";
        $stmt = $this->db->query($sql);
    }


    public function InsertarVenta($No_Pantalla,$Accion,$Descripción)
    {
        $sql="INSERT INTO `tbl_ventas` (`id_venta`, `   desc_venta`, `  fecha_venta`, ` cantidad_venta`, `  isv`, `descuento`) 
        VALUES (now(), '1', '$No_Pantalla', '$Accion', '$Descripción', NULL, now(), NULL , NULL); ";
        $stmt = $this->db->query($sql);
    }
    public function ActivarUsuarioPregunta($Usuario)
    {
        $sql="UPDATE tbl_ms_usuario SET id_estado_usuario = '1'
        WHERE usuario = '$Usuario'";
        $stmt = $this->db->query($sql);
    }

    public function InsertarBitacora($No_Pantalla,$Accion,$Descripción)
    {
        $sql="INSERT INTO `tbl_ms_bitacora` (`fecha`, `TBL_MS_USUARIO_id_usuario`, `TBL_MS_OBJETOS_id_objeto`, `accion`, `descripcion`, `creado_por`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`) 
        VALUES (now(), '1', '$No_Pantalla', '$Accion', '$Descripción', NULL, now(), NULL , NULL); ";
        $stmt = $this->db->query($sql);
    }
    
    public function InsertarBitacoraSis($id_usuario,$No_Pantalla,$Accion,$Descripción)
    {
        $sql="INSERT INTO `tbl_ms_bitacora` (`fecha`, `TBL_MS_USUARIO_id_usuario`, `TBL_MS_OBJETOS_id_objeto`, `accion`, `descripcion`, `creado_por`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`) 
        VALUES (now(), '$id_usuario', '$No_Pantalla', '$Accion', '$Descripción', NULL, now(), NULL , NULL); ";
        $stmt = $this->db->query($sql);
    }


//--------------------------------- FUNCIONES GENERALES FINAL ----------------------------------

//--------------------------------- FUNCIONES PARA EL CORREO INICIO ----------------------------------
    public function Get_correo($InputUsuario)
    {
        $sql="SELECT correo_usuario from tbl_ms_usuario where usuario ='$InputUsuario'";
        $stmt = $this->db->query($sql);
        $stmt= mysqli_fetch_assoc($stmt);
        $stmt = $stmt['correo_usuario'];
        return $stmt;
    }


    public function ActualizarToken($ValorToken, $fecha_inicial,$fecha_final,$InputUsuario)
    {
        $sql="UPDATE tbl_ms_usuario SET token ='$ValorToken', fecha_inicial = '$fecha_inicial', fecha_final='$fecha_final'
        WHERE usuario = '$InputUsuario'";
        $stmt = $this->db->query($sql);
    }
    public function ParamHost()
    {
        $sql="SELECT valor FROM `tbl_ms_parametros` WHERE id_parametro = 1";
        $stmt = $this->db->query($sql);
        $stmt= mysqli_fetch_assoc($stmt);
        $stmt = $stmt['valor'];
        return $stmt;
    }
    public function ParamUsuario()
    {
        $sql="SELECT valor FROM `tbl_ms_parametros` WHERE id_parametro = 2";
        $stmt = $this->db->query($sql);
        $stmt= mysqli_fetch_assoc($stmt);
        $stmt = $stmt['valor'];
        return $stmt;
    }
    public function ParamContra()
    {
        $sql="SELECT valor FROM `tbl_ms_parametros` WHERE id_parametro = 3";
        $stmt = $this->db->query($sql);
        $stmt= mysqli_fetch_assoc($stmt);
        $stmt = $stmt['valor'];
        return $stmt;
    }
    public function ParamSMTP()
    {
        $sql="SELECT valor FROM `tbl_ms_parametros` WHERE id_parametro = 4";
        $stmt = $this->db->query($sql);
        $stmt= mysqli_fetch_assoc($stmt);
        $stmt = $stmt['valor'];
        return $stmt;
    }
    public function ParamPuerto()
    {
        $sql="SELECT valor FROM `tbl_ms_parametros` WHERE id_parametro = 5";
        $stmt = $this->db->query($sql);
        $stmt= mysqli_fetch_assoc($stmt);
        $stmt = $stmt['valor'];
        return $stmt;
    }
    public function ParamNombre()
    {
        $sql="SELECT valor FROM `tbl_ms_parametros` WHERE id_parametro = 6";
        $stmt = $this->db->query($sql);
        $stmt= mysqli_fetch_assoc($stmt);
        $stmt = $stmt['valor'];
        return $stmt;
    }
    public function ParamToken()
    {
        $sql="SELECT valor FROM `tbl_ms_parametros` WHERE id_parametro = 7";
        $stmt = $this->db->query($sql);
        $stmt= mysqli_fetch_assoc($stmt);
        $stmt = $stmt['valor'];
        return $stmt;
    }

//--------------------------------- FUNCIONES PARA EL CORREO FINAL ----------------------------------

//--------------------------------- FUNCIONES PARA RESTABLECER CONTRASEÑA INICIO ----------------------------------
public function TokenBD($Correo_url)
{
    $sql="SELECT token FROM `tbl_ms_usuario` WHERE correo_usuario = '$Correo_url'";
    $stmt = $this->db->query($sql);
    $stmt= mysqli_fetch_assoc($stmt);
    $stmt = $stmt['token'];
    return $stmt;
}

public function VencimientoToken($Correo_url)
{
    $sql="SELECT fecha_final FROM `tbl_ms_usuario` WHERE correo_usuario = '$Correo_url'";
    $stmt = $this->db->query($sql);
    $stmt= mysqli_fetch_assoc($stmt);
    $stmt = $stmt['fecha_final'];
    return $stmt;
}


public function TokenUtilizado($Correo_url)
{
    $sql="UPDATE tbl_ms_usuario SET token ='Token reclamado'
    WHERE correo_usuario = '$Correo_url'";
    $stmt = $this->db->query($sql);
    return $stmt;
}

public function CambioContra($Confirnueva, $Correo_url)
{
    $sql="UPDATE tbl_ms_usuario SET contrasena ='$Confirnueva'
    WHERE correo_usuario = '$Correo_url'";
    $stmt = $this->db->query($sql);
}

public function ContractualCorreo($Correo_url)
{
    $sql="SELECT contrasena FROM `tbl_ms_usuario` where correo_usuario='$Correo_url'";
    $stmt = $this->db->query($sql);
    $stmt= mysqli_fetch_assoc($stmt);
    $stmt = $stmt['contrasena'];
    return $stmt;
   
}
//--------------------------------- FUNCIONES PARA RESTABLECER CONTRASEÑA FINAL -----------------------------------
//--------------------------------- FUNCIONES PARA RESTABLECER POR PREGUNTAS DE SEGURIDAD INICIO -----------------------------------
public function SelectPregunta()
{
    $sql="SELECT * FROM `tbl_ms_preguntas` where estado=1";
    $stmt = $this->db->query($sql);
    return $stmt;
}
public function TodosUsuarios($inputusuario)
{
    $sql="SELECT usuario FROM `tbl_ms_usuario` where usuario='$inputusuario'";
    $stmt = $this->db->query($sql);
    if (mysqli_num_rows($stmt)>0) 
    {
     return $stmt; 
    }
    return false;
   
}

public function IDUsuarioPre($inputusuario)
{
    $sql="SELECT id_usuario from tbl_ms_usuario  where usuario = '$inputusuario'";
    $stmt = $this->db->query($sql);
    $stmt= mysqli_fetch_assoc($stmt);
    $stmt = $stmt['id_usuario'];
    return $stmt;
}

public function RespuestaUsuario($selectpregunta,$Id_usuario)
{
    $sql="SELECT respuesta FROM `tbl_ms_preguntas_usuario` WHERE id_usuario = '$Id_usuario' and id_pregunta = '$selectpregunta'";
    $stmt = $this->db->query($sql);
    $stmt= mysqli_fetch_assoc($stmt);
    $stmt = $stmt['respuesta'];
    return $stmt;
}

public function ContractualPregun($Usuario)
{
    $sql="SELECT contrasena FROM `tbl_ms_usuario` where usuario='$Usuario'";
    $stmt = $this->db->query($sql);
    $stmt= mysqli_fetch_assoc($stmt);
    $stmt = $stmt['contrasena'];
    return $stmt;
   
}
public function CambioContraPre($Confirnueva, $Usuario)
{
    $sql="UPDATE tbl_ms_usuario SET contrasena ='$Confirnueva'
    WHERE usuario = upper('$Usuario')";
    $stmt = $this->db->query($sql);
}
//--------------------------------- FUNCIONES PARA RESTABLECER POR PREGUNTAS DE SEGURIDAD FINAL -------------------

//--------------------------------- FUNCIONES PARA RESPONDER PREGUNTAS DE SEGURIDAD INICIO -------------------
public function InsertarPregunta($selectpregunta,$id_usuario,$inputrespuesta)
{
    $sql="INSERT  INTO tbl_ms_preguntas_usuario(id_pregunta,id_usuario,respuesta,creado_por,fecha_creacion,fecha_modificacion,modificado_por) 
    VALUES('$selectpregunta', '$id_usuario','$inputrespuesta','$id_usuario','SELECT now()','SELECT now()','$id_usuario')";
    $stmt = $this->db->query($sql);
}

public function Id_usuario($Usuario)
{
    $sql="SELECT id_usuario from tbl_ms_usuario  WHERE usuario = '$Usuario'";
    $stmt = $this->db->query($sql);
    $stmt= mysqli_fetch_assoc($stmt);
    $stmt = $stmt['id_usuario'];
    return $stmt;
}

public function ActualizarEstado($id_usuario)
{
    $sql="UPDATE tbl_ms_usuario SET primer_ingreso='1' WHERE id_usuario='$id_usuario'";
    $stmt = $this->db->query($sql);
}
//--------------------------------- FUNCIONES PARA RESPONDER PREGUNTAS DE SEGURIDAD FINAL -------------------

//--------------------------------- FUNCIONES VALIDA LOGIN-----------------------------------
public function validalogin($correo, $pass)
{
    $sql="call splogin('$correo','$pass')";
    $stmt = $this->db->query($sql);
    return $stmt;
}


public function RegistroUsuarios($usuario,$pass,$nombre,$apellido,$genero,$correo){
    $sql="call spTbl_ms_UsuariosInsertar('$usuario',2,'$pass','$nombre', '$apellido','$genero','$correo',1,'Autoregistro', 'Autoregistro');";
    $stmt = $this->db->query($sql);
    return $stmt;
}


//--------------------------------- FUNCIONES PARA AUTOREGISTRO INICIO -----------------------------------
public function ValidacionExistenteU($usuario)
{
    $sql="SELECT usuario FROM `tbl_ms_usuario` where usuario='$usuario'";
    $stmt = $this->db->query($sql);
    $stmt= mysqli_fetch_assoc($stmt);
    $stmt = $stmt['usuario'];
    return $stmt;
}

public function ValidacionExistenteC($correo)
{
    $sql="SELECT correo_usuario FROM `tbl_ms_usuario` where correo_usuario='$correo'";
    $stmt = $this->db->query($sql);
    $stmt= mysqli_fetch_assoc($stmt);
    $stmt = $stmt['correo_usuario'];
    return $stmt;
}


public function Productos($inputproducto)
{
    $sql="SELECT nombre_producto FROM `tbl_productos` where nombre_producto='$inputproducto'";
    $stmt = $this->db->query($sql);
    if (mysqli_num_rows($stmt)>0) 
    {
     return $stmt; 
    }
    return false;
   
}

public function Clientes($inputcliente)
{
    $sql="SELECT nombre_cliente FROM `tbl_clientes` where nombre_cliente='$inputcliente'";
    $stmt = $this->db->query($sql);
    if (mysqli_num_rows($stmt)>0) 
    {
     return $stmt; 
    }
    return false;
   
}
//--------------------------------- FUNCIONES PARA AUTOREGISTRO FINAL -----------------------------------

}
?>