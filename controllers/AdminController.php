<?php
require_once 'models/Admin.php';
require_once 'models/Auth.php';

class AdminController
{

    public function salir()
    {
        if (isset($_SESSION['admin'])) {
            $_SESSION['admin'] = null;
            unset($_SESSION['admin']);
            header("location:" . base_url);
        }
        header("location:" . base_url);
    }

    public function header()
    {
        require_once 'views/admin/shared/header.php';
    }

    public function footer()
    {
        require_once 'views/admin/shared/footer.php';
    }

    public function principal()
    {
        require_once 'views/admin/principal.php';
    }
    public function usuarios()
    {
        require_once 'views/admin/usuariosList.php';
    }

    public function usuariosnew()
    {
        require_once 'views/admin/usuariosNew.php';
    }

    public function usuariosUpdate()
    {
        require_once 'views/admin/usuariosUpdate.php';
    }

    public function BitacoraList()
    {
        require_once 'views/admin/BitacoraList.php';
    }

    // PERMISOS
    
    public function permisos()
    {
        require_once 'views/admin/permisos.php';
    }
    // ROLES
    public function roles()
    {
        require_once 'views/admin/roles.php';
    }
    // MENUS
    public function objetos()
    {
        require_once 'views/admin/objetos.php';
    }

    public function Ventas()
    {
        require_once 'views/ventas.php';
    }

    public function VentasNew()
    {
        require_once 'views/nueva_venta.php';
    }


    public function Clientes()
    {
        require_once 'views/admin/clientes.php';
    }

    public function clientesnew()
    {
        require_once 'views/admin/clientesNew.php';
    }

    public function clientesupdate()
    {
        require_once 'views/admin/clientesUpdate.php'; 
    }

   public function Productos()
    {
        require_once 'views/admin/listaproductos.php';
    }

    public function productosnew()
    {
        require_once 'views/admin/productosNew.php';
    }

    public function productosUpdate()
    {
        require_once 'views/admin/productosUpdate.php'; 
    }

    public function Categoria()
    {
        require_once 'views/admin/categoria.php';
    }
    public function proveedores()
    {
        require_once 'views/admin/proveedorList.php';
    }
    public function proveedoresnew()
    {
        require_once 'views/admin/proveedoresnew.php';
    }
    
    public function reporteClientes()
    {
        require_once 'views/reporteClientes.php';
    }

    public function reporteClientes2()
    {
        require_once 'views/reporteClientes2.php';
    }
    public function reporteBitacora()
    {
        require_once 'views/reporteBitacora.php';
    }
    public function reporteUsuario()
    {
        require_once 'views/reporteUsuario.php';
    }
    public function reporteRol()
    {
        require_once 'views/reporteRol.php';
    }
    public function reporteObjeto()
    {
        require_once 'views/reporteObjeto.php';
    } 
    public function reporteProveedor()
    {
        require_once 'views/reporteProveedor.php';
    }
    public function reporteVenta()
    {
        require_once 'views/reporteVenta.php';
    }

    public function Inventario()
    {
        require_once 'views/admin/Inventario.php';
    }

     public function Inventariolista()
    {
        require_once 'views/admin/Inventariolista.php';
    }

    public function compras()
    {
        require_once 'views/admin/compras.php';
    }

    public function compraslist()
    {
        require_once 'views/admin/compraslist.php';
    }



public function reporteProducto()
    {
        require_once 'views/reporteProducto.php';
    }
    public function reportePermisos()
    {
        require_once 'views/reportePermisos.php';
    }

    
    public function Backup()
    {
        require_once 'views/Backup.php';
    }


public function generarBackup()
    {
        require_once 'views/generarBackup.php';
    }

public function generarRestore()
    {
        require_once 'views/generarRestore.php';
    }

    public function restore()
    {
        require_once 'views/restore.php';
    }


    public function mostrarCliente()
    {
        $id = $_GET['id'];
        $Admin =  new Admin();
        $result = $Admin->ObtenerCliente($id);
    }

    public function mostrarproveedor()
    {
        $id=$_GET['id'];
        $Admin= new Admin();
        $result = $Admin->Obtenerproveedor($id);
    }
    public function crearproveedor()
    {
       if (isset($_POST['crear'])) {
           $proveedor=$_POST['proveedor'];
           $contacto=$_POST['contacto'];
           $telefono=$_POST['telefono'];
           $direccion=$_POST['direccion'];
           $Admin= new Admin();
           $auth= new Auth();
           
           $result=$Admin->crearproveedor($proveedor,$contacto,$telefono,$direccion);
           $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],7,'creo','registro proveedor');
           if ($result) {
                    echo "<script> alert('¡Agregado con éxito!'); </script>";
                    echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/proveedores'; </script>";
                } else {
                    echo "<script> alert('¡Ocurrio un error!'); </script>";
                    echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/proveedoresnew'; </script>";
            }

       }
    }


public function proveedorUpdate()
    {
        require_once 'views/admin/proveedoresUpdate.php';
    }

 public function Actualizarproveedor()
    {
        $Admin =  new Admin();
        $auth = new Auth();
        if (isset($_POST['actualizar'])) {
            $id = $_GET['id'];
            $proveedor= $_POST['proveedor'];
            $contacto = $_POST['contacto'];
            $telefono = $_POST['telefono'];
            $direccion=$_POST['direccion'];
            $result = $Admin->Editarproveedor($id, $proveedor, $contacto, $telefono,$direccion);
            $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],28,'Actualizo','Actualizo Proveedor');   
            if ($result) {  
                echo "<script> alert('¡Editado correctamente!'); </script>";
                echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/proveedores'; </script>";
            } else {
                echo "<script> alert('¡No se pudo editar!'); </script>";
                echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/proveedores'; </script>";
            }
        }
    }

    public function eliminarProveedor()
  {
      $Admin =  new Admin();
      $auth = new Auth();
      $id = $_GET['id'];
      $result = $Admin->EliminarProveedores($id);   
      $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],28,'Elimina','Elimino Producto');    
      if ($result) {
          echo "<script> alert('¡Eliminado con éxito!'); </script>";
          echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/proveedores'; </script>";
      } else {
          echo "<script> alert('¡Ocurrio un error!'); </script>";
          echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/proveedores'; </script>";
      }
  }

    public function crearcliente()
    {
        if (isset($_POST['crear'])) {

            $nombre_cliente = $_POST['nombre_cliente'];
            $DNI = $_POST['DNI'];
            $telefono_cliente = $_POST['telefono_cliente'];
            $direccion_cliente = $_POST['direccion_cliente'];
            $fecha_creacion = $_POST['fecha_creacion'];
            $Admin = new Admin();
            $auth = new Auth();
                $result = $Admin->Crearcliente($nombre_cliente, $DNI, $telefono_cliente, $direccion_cliente, $fecha_creacion);
                $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],28,'creo','creo cliente');
                if ($result) {
                    echo "<script> alert('¡Agregado con éxito!'); </script>";
                    echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/Clientes'; </script>";
                } else {
                    echo "<script> alert('¡Ocurrio un error!'); </script>";
                    echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/clientesnew'; </script>";
            }
        }
    }


    public function mostrarProducto()
    {
        $id = $_GET['id'];
        $Admin =  new Admin();
        $result = $Admin->ObtenerProducto($id);
    }

     public function crearproducto()
    {
        if (isset($_POST['crear'])) {

            $nombre_producto = $_POST['nombre_producto'];
            $desc_producto = $_POST['desc_producto'];
            $precio_venta = $_POST['precio_venta'];
            $cantidad_max = $_POST['cantidad_max'];
            $cantidad_min = $_POST['cantidad_min'];
            $stock = $_POST['stock'];
            $fecha_registro = $_POST['fecha_registro'];

            $producto = $_POST['proveedor_'];
            $categoria = $_POST['Categoria_'];
            


            $Admin = new Admin();
            $auth = new Auth();

                $result = $Admin->Crearproducto($nombre_producto, $desc_producto, $precio_venta, $cantidad_max, $cantidad_min, $stock,$fecha_registro, $producto, $categoria, $_SESSION['admin']['id_usuario']);
                $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],28,'creo','creo producto');

                if ($result) {
                    echo "<script> alert('¡Agregado con éxito!'); </script>";
                    echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/productos'; </script>";
                } else {
                    echo "<script> alert('¡Ocurrio un error!'); </script>";
                    echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/productosnew'; </script>";
            }
        }
    }


    public function eliminarCategoria()
    {
        $Admin =  new Admin();
        $auth = new Auth();
        $id = $_GET['id'];
        $result = $Admin->EliminarCategorias($id);   
        $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],28,'Elimina','Elimino Categoria');    
        if ($result) {
            echo "<script> alert('¡Eliminado con éxito!'); </script>";
            echo "<script>  window.location.href = 'Categoria&objeto=44'; </script>";
        } else {
            echo "<script> alert('¡Ocurrio un error!'); </script>";
            echo "<script>  window.location.href = 'Categoria&objeto=44'; </script>";
        }
    }

    public function eliminarProducto()
    {
        $Admin =  new Admin();
        $auth = new Auth();
        $id = $_GET['id'];
        $result = $Admin->EliminarProductos($id);   
        $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],28,'Elimina','Elimino Producto');    
        if ($result) {
            echo "<script> alert('¡Eliminado con éxito!'); </script>";
            echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/productos'; </script>";
        } else {
            echo "<script> alert('¡Ocurrio un error!'); </script>";
            echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/productos'; </script>";
        }
    }


    public function eliminarCliente()
    {
        $Admin =  new Admin();
        $auth = new Auth();
        $id = $_GET['id'];
        $result = $Admin->EliminarClientes($id);   
        $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],28,'Elimina','Elimino Cliente');    
        if ($result) {
            echo "<script> alert('¡Eliminado con éxito!'); </script>";
            echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/clientes'; </script>";
        } else {
            echo "<script> alert('¡Ocurrio un error!'); </script>";
            echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/clientes'; </script>";
        }
    }


    public function Actualizarproducto()
    {
        $Admin =  new Admin();
        $auth = new Auth();
        if (isset($_POST['actualizar'])) {
            $id = $_GET['id'];
            $nombre_producto = $_POST['nombre_producto'];
            $desc_producto = $_POST['desc_producto'];
            $precio_venta = $_POST['precio_venta'];


            $cantidadActual = $_POST['cantidadActual'];
            $tipokardex = $_POST['tipokardex'];
            $cantidad = $_POST['cantidad'];


            $result = $Admin->EditarProducto($id, $nombre_producto, $desc_producto, $precio_venta, $tipokardex, $cantidad, $_SESSION['admin']['id_usuario'],$cantidadActual);
            $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],28,'Actualizo','Actualizo Producto');   
            if ($result) {  
                echo "<script> alert('¡Editado correctamente!'); </script>";
                echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/productos'; </script>";
            } else {
                echo "<script> alert('¡No se pudo editar!'); </script>";
                echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/productos'; </script>";
            }
        }
    }

public function Actualizarcliente()
    {
        $Admin =  new Admin();
        $auth = new Auth();
        if (isset($_POST['actualizar'])) {
            $id = $_GET['id'];
            $nombre_cliente = $_POST['nombre_cliente'];
            $DNI = $_POST['DNI'];
            $telefono_cliente = $_POST['telefono_cliente'];
            $direccion_cliente = $_POST['direccion_cliente'];

            $result = $Admin->EditarCliente($id, $nombre_cliente, $DNI, $telefono_cliente, $direccion_cliente );
            $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],28,'Actualizo','Actualizo Cliente');   
            if ($result) {  
                echo "<script> alert('¡Editado correctamente!'); </script>";
                echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/Clientes'; </script>";
            } else {
                echo "<script> alert('¡No se pudo editar!'); </script>";
                echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/clientesnew'; </script>";
            }
        }
    }
    
    public function mostrarUsuaro()
    {
        $id = $_GET['id'];
        $Admin =  new Admin();
        $result = $Admin->ObtenerUsuario($id);
    }

    public function crearUsuarioss()
    {
        if (isset($_POST['crear'])) {

            $usuario = $_POST['usuario'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $genero = $_POST['sexo'];
            $correo = $_POST['correo'];
           $pass=$pass = $_POST['pass'];
            $pass1 = $_POST['pass1'];
            $rol = $_POST['rol'];
            $creado = $_SESSION['admin']['usuario'];
            $estado = $_POST['estado'];
            $Admin = new Admin();
            $auth = new Auth();
            if ($pass == $pass1) {
                $pass1 = md5($pass1);
                $result = $Admin->crearUsuarios($usuario, $pass1, $nombre, $apellido, $genero, $correo, $rol, $creado,$estado);
                $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],7,'creo','creo usuario');
                foreach ($result as $r) {
                    $_SESSION['msg'] = $r['mensaje'];
                    header("location:" . base_url . "/admin/usuariosnew");
                }
            }else{
                $_SESSION['msg'] = 'Las contraseñas no coinciden';
            }
        }
    }

    public function eliminarUsuario()
    {
        $Admin =  new Admin();
        $auth = new Auth();
        $id = $_GET['id'];
        $result = $Admin->EliminarUsuarios($id);   
        $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],7,'Elimina','Elimino Usuario');    
        if ($result) {
            echo "<script> alert('¡Eliminado con éxito!'); </script>";
            echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/usuarios'; </script>";
        } else {
            echo "<script> alert('¡Ocurrio un error!'); </script>";
            echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/usuarios'; </script>";
        }
    }

    public function actualizaUsuario()
    {
        $Admin =  new Admin();
        $auth = new Auth();
        if (isset($_POST['actualizar'])) {
            $id = $_GET['id'];
            $usuario = $_POST['usuario'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $genero = $_POST['sexo'];
            $correo = $_POST['correo'];
            $estado = $_POST['estado'];

            $rol = $_POST['rol'];
            $modificadopor = $_SESSION['admin']['id_usuario'];


            $result = $Admin->ActualizarUsuarios($id, $usuario, $nombre, $apellido, $genero, $correo, $rol, $modificadopor ,$estado);
            $auth->InsertarBitacoraSis($_SESSION['admin']['id_usuario'],7,'Actualizo','Actualizo Usuario');   
            if ($result) {
                
                echo "<script> alert('¡Editado correctamente!'); </script>";
                echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/usuarios'; </script>";
            } else {
                echo "<script> alert('¡No se pudo editar!'); </script>";
                echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/usuarios'; </script>";
            }
        }
    }


    public function mostrarVenta()
    {
        $id = $_GET['id'];
        $Admin =  new Admin();
        $result = $Admin->ObtenerVentas($id);
    }

    
}