<?php
class Admin
{
  private $db;
  public function __construct()
  {
    $this->db = Database::connect();
  }

   public function ObtenerVentas()
  {
    $sql = "SELECT
            tbl_ventas.fecha_venta, 
            tbl_ventas.total_venta, 
            tbl_ventas.id_venta, 
            tbl_clientes.DNI, 
            tbl_clientes.nombre_cliente
        FROM
         tbl_ventas
         INNER JOIN tbl_clientes ON tbl_ventas.id_cliente = tbl_clientes.id_cliente";
    $stmt = $this->db->query($sql);
    return $stmt;
  }


  public function ObtenerUsuarios()
  {
    $sql = "select * from tbl_ms_usuario";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  public function ObtenerUsuario($id)
  {
    $sql = "select * from tbl_ms_usuario where id_usuario = '$id'";
    $stmt = $this->db->query($sql);
    return $stmt;
  }
  public function ObtenerClientes()
  {
    $sql = "select * from tbl_clientes";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  public function ObtenerCliente($id)
  {
    $sql = "select * from tbl_clientes where id_cliente = '$id'";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

   public function Crearcliente($nombre_cliente, $DNI, $telefono_cliente, $direccion_cliente)
  { 
    $sql = "INSERT INTO `tbl_clientes`(`nombre_cliente`, `DNI`, `telefono_cliente`, `direccion_cliente`) 
    VALUES ('$nombre_cliente','$DNI','$telefono_cliente','$direccion_cliente')";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  public function CrearUsuarios($usuario, $pass, $nombre, $apellido, $genero, $correo, $rol, $creado,$estado)
  {
    $sql = "call spTbl_ms_UsuariosInsertaraA('$usuario','$estado','$pass','$nombre', '$apellido','$genero','$correo','$rol','$creado')";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  public function ActualizarUsuarios($id, $usuario, $nombre, $apellido, $genero, $correo, $rol, $modificadopor,$estado)
  {
    $sql = "update tbl_ms_usuario set usuario = '$usuario',id_estado_usuario = '$estado',nombre_usuario = '$nombre',apellido_usuario = '$apellido'
     ,genero_usuario = '$genero',correo_usuario= UPPER('$correo') ,TBL_MS_ROLES_id_rol = $rol , fecha_modificacion = sysdate(),modificado_por = '$modificadopor'
     where id_usuario = '$id'";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  public function EliminarUsuarios($id)
  {
    $sql = "call spTbl_ms_UsuariosEliminar($id)";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

   public function EliminarClientes($id)
  {
    $sql = "call spTbl_ms_ClientesEliminar($id)";
    $stmt = $this->db->query($sql);
    return $stmt;
  }


  public function roles(){
    $sql = "select * from tbl_ms_roles";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  public function ListarBitacora()
  {
    $sql = "SELECT b.id_bitacora, b.fecha, u.usuario,o.objeto, b.accion, b.descripcion, b.fecha_creacion  FROM tbl_ms_bitacora b inner join tbl_ms_usuario u
    on b.TBL_MS_USUARIO_id_usuario = u.id_usuario inner join tbl_ms_objetos o on b.TBL_MS_OBJETOS_id_objeto = o.id_objeto ORDER BY b.id_bitacora DESC";
    $stmt = $this->db->query($sql);
    return $stmt;
  }


 

  public function getmenus(){
    $sql = "select * from tbl_ms_objetos";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  public function getmenu($cod){

		$rol = $_SESSION['admin']['TBL_MS_ROLES_id_rol'];
		$preg = "SELECT * FROM tbl_ms_objetos t 
    inner join tbl_ms_permisos t2 
    ON t.id_objeto = t2.TBL_MS_OBJETOS_id_objeto 
    where t2.TBL_MS_ROLES_id_rol = '$rol' and t2.permiso_consultar = 1 and idPadre = '$cod'";
	  $stmt = $this->db->query($preg);
		return $stmt;

	}
  public function permisos($cod)
  {

    // CARGAR 'id_rol'
    $rol = $_SESSION['admin']['TBL_MS_ROLES_id_rol'];
		
		$sql = "SELECT *FROM tbl_ms_permisos tp
    WHERE tp.TBL_MS_ROLES_id_rol = '$rol' AND tp.permiso_consultar = 1 AND tp.TBL_MS_OBJETOS_id_objeto = '$cod'";
    $stmt = $this->db->query($sql);


		if(mysqli_num_rows($stmt)>0) return true;
		return false;
  
  

  }


  public function bitacora($objeto,$accion,$descrip){
    $user = $_SESSION['admin']['id_usuario'];
      $sql = "call spTblBitacoraInsert('$user','$objeto','$accion','$descrip')";
      $stmt = $this->db->query($sql);
		return $stmt;
  }


  public function Obtenerproveedor()
  {
    $sql= "select * from tbl_proveedores";
    $stmt =$this->db->query($sql);
    return $stmt; 
  }
  public function Obtenerproveedores($id)
  {
    $sql=" select * from tbl_proveedores where id_proveedor='$id'";
    $stmt =$this->db->query($sql);
    return $stmt; 
  }

public function Editarproveedor($id, $proveedor, $contacto, $telefono, $direccion)
{ 
  $sql = "UPDATE tbl_proveedores set proveedor = '$proveedor', contacto= '$contacto', telefono= '$telefono',  direccion= '$direccion' where id_proveedor ='$id'";
  $stmt = $this->db->query($sql);
  return $stmt;
}
public function EliminarProveedores($id)
{
  $sql = "call spTbl_ms_ProveedorEliminar($id)";
  $stmt = $this->db->query($sql);
  return $stmt;
}


  public function getproveedores()
  {
    $sql=" select * from tbl_proveedores";
    $stmt =$this->db->query($sql);
    return $stmt; 
  }




 public function crearproveedor($proveedor,$contacto,$telefono, $direccion)
  {
    $sql = "INSERT INTO `tbl_proveedores`(`proveedor`, `contacto`, `telefono`, `direccion`) VALUES ('$proveedor','$contacto','$telefono','$direccion')";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  public function ObtenerCategoria()
  {
    $sql = "SELECT * FROM tbl_categoria";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  
  public function ObtenerProductos()
  {
    $sql = "select * from tbl_productos";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  

   public function Inventariolista()
  {
    $sql = "select * from tbl_productos";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  public function ObtenerProducto($id)
  {
    $sql = "select * from tbl_productos where id_producto = '$id'";
    $stmt = $this->db->query($sql);
    return $stmt;
  }




  public function Crearproducto($nombre_producto,$desc_producto,$precio_venta, $cantidad_max,$cantidad_min,$stock,$fecha_registro,$producto, $categoria, $user) { 
    $sql = "INSERT INTO `tbl_productos`(`nombre_producto`, `desc_producto`, `precio_venta`, `cantidad_max`,`cantidad_min`,`stock`,`fecha_registro`, `id_proveedor`, `id_categoria`) 
    VALUES ('$nombre_producto','$desc_producto','$precio_venta','$cantidad_max','$cantidad_min','$stock','$fecha_registro', '$producto', '$categoria')";
    $this->db->query($sql);

    $id_producto = $this->db->insert_id;  

    $sql = "INSERT INTO `tbl_kardex`( `cantidad_kardex`, `precio`, `id_producto`, `id_tipo_kardex`, `id_usuario`) VALUES ('$stock', '$precio_venta', '$id_producto', 1, '$user');";
    $stmt = $this->db->query($sql);

    return $stmt;
  }







  public function EliminarCategorias($id)
  {
    $sql = "call spTbl_ms_CateEliminar($id)";
    $stmt = $this->db->query($sql);
    return $stmt;
  }
  

  public function EditarProducto($id,$nombre_producto,$desc_producto,$precio_venta, $tipokardex, $cantidad, $user,$cantidadActual) {

    if ($tipokardex != '0'){
       $sql = "INSERT INTO `tbl_kardex`( `cantidad_kardex`, `precio`, `id_producto`, `id_tipo_kardex`, `id_usuario`) VALUES ('$cantidad', 0, '$id', '$tipokardex', '$user');";
         $this->db->query($sql);
      if ($tipokardex == '1') {

         $cantidad_ = (intval($cantidadActual) +  intval($cantidad));
      }else{
         $cantidad_ = (intval($cantidadActual) -  intval($cantidad));
      }

       $sql = "UPDATE tbl_productos set stock = '$cantidad_' where id_producto ='$id'";
       $this->db->query($sql);

    }


    $sql = "UPDATE tbl_productos set nombre_producto = '$nombre_producto',desc_producto = '$desc_producto',precio_venta = '$precio_venta' where id_producto ='$id'";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

  public function EditarCliente($id,$nombre_cliente, $DNI, $telefono_cliente, $direccion_cliente)
  { 
    $sql = "UPDATE tbl_clientes set nombre_cliente = '$nombre_cliente',DNI = '$DNI',telefono_cliente = '$telefono_cliente', direccion_cliente = '$direccion_cliente'  where id_cliente ='$id'";
    $stmt = $this->db->query($sql);
    return $stmt;
  }

}

