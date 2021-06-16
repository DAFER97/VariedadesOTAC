<?php
class ajaxObjetosController
{

    public function getObjetos()
    {
        error_reporting(0);
        header('Content-type: application/json; charset = utf-8');

        $mysqli = Database::connect();

        if (!$mysqli->connect_errno) {
            $mysqli->set_charset('utf8');

            $statement = "call spTbl_ms_Objetos_Mostrar()";
            $resultado = mysqli_query($mysqli, $statement);
            while ($data = mysqli_fetch_assoc($resultado)) {
                $arreglo['data'][] = $data;
            }

            echo json_encode($arreglo);
        }
    }

    public function delObjetos()
    {
        utils::isAdmin();

        $id = $_GET['id'];
        // BITACORA
        // date_default_timezone_set("America/Tegucigalpa");
        // $fecha = date("yy-M-d h:ia");
        // $usuario = $_SESSION['admin']['cod_usuario'];
        // $menu = $_SESSION['menu'];

        $mysqli = Database::connect();

        if ($mysqli->connect_errno) {
            $respuesta = [
                'error' => true,
                'mensaje' => 'fallo a conexion'
            ];
        } else {

            $mysqli->set_charset('utf8');
            $statement = $mysqli->prepare('DELETE FROM tbl_ms_objetos where id_objeto = ?');
            $statement->bind_param('i', $id);
            $statement->execute();
            // INSERTAR EN BITACORA
            // $Auth = new Auth();
            // $No_Pantalla = 9;
            // $Accion = "Eliminar";
            // $Descripción = "Eliminó un menu del sistema";
            // $Auth->InsertarBitacora($No_Pantalla, $Accion, $Descripción);

            if ($mysqli->affected_rows <= 0) {
                $respuesta = [
                    'error' => true,
                    'mensaje' => 'no se puedo borrar'
                ];
            } else {
                $respuesta  = [
                    'error' => false,
                    'mensaje' => 'Menu eliminado'
                ];
            }
        }


        echo json_encode($respuesta);
    }

    public function updObjetos()
    {

        error_reporting(0);
        header('Content-type: application/json; charset = utf-8');

        $id       = $_POST['id'];
        $menus    = $_POST['menu'];
        $descripcion = $_POST['descripcion'];
        $tipo_objeto = $_POST['tipo_objeto'];
        $icon = $_POST['icono'];
        $url = $_POST['url'];
        $estado = $_POST['estado'];
        $idpadre = isset($_POST['menupadre']) ? $_POST['menupadre'] : 0;
        $creado = $_SESSION['admin']['usuario'];
        
        //BITACORA
        // date_default_timezone_set("America/Tegucigalpa");
        // $fecha = date("yy-M-d h:ia");
        // $usuario = $_SESSION['admin']['cod_usuario'];
        // $menu = $_SESSION['menu'];
        //fin

        
        if (!empty($id) && !empty($menus) && !empty($descripcion) && !empty($tipo_objeto) 
        && !empty($icon) && !empty($url) && !empty($estado) && !empty($idpadre) && !empty($creado) ) {

            $mysqli = Database::connect();

            if ($mysqli->connect_errno) {
                $respuesta = [
                    'error' => true,
                    'mensaje' => 'fallo la conexion'
                ];
            } else {

                $sql = "SELECT objeto FROM tbl_ms_objetos WHERE objeto   = '$menus";
                $result = mysqli_query($mysqli, $sql);
                $contar = mysqli_num_rows($result);
                if ($menus== $menus) {
                    // $sql = "UPDATE tblimagenes SET nombre_rol= '$hotel', imagen = '$imagen', direccion = '$direccion', latitud = '$latitud', longitud = '$longitud' WHERE cod_hotel = '$id'";
                    $sql = "call spTbl_ms_Objetos_Actualizar('$id','$menus','$descripcion','$tipo_objeto','$idpadre','$icon','$url','$estado','$creado')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($mysqli->affected_rows <= 0) {
                        $respuesta = [
                            'error' => true,
                            'mensaje' => 'Error al querer actualizar'
                        ];
                    } else {
                         // INSERTAR EN BITACORA
                            // $Auth = new Auth();
                            // $No_Pantalla = 9;
                            // $Accion = "Actualizar";
                            // $Descripción = "Actualizo un menu del sistema";
                            // $Auth->InsertarBitacora($No_Pantalla, $Accion, $Descripción);
                        $respuesta = [
                            'error'   => false,
                            'mensaje' => 'actualizado correctamente'
                        ];
                    }
                } else {
                    $respuesta = [
                        'mensaje' => 'Este menu ya existe, actualizar con otro nombre',
                        'error' => true
                    ];
                }
            }
        } else {
            $respuesta = [
                'error' => true,
                'mensaje' => 'Por favor rellenar los campos' . ' ' .   $id . ' '  . $menus . ' '. $descripcion .' '. $tipo_objeto .' '. $icon .' '. $url .' '. $estado .' '. $idpadre  
            ];
        }

        echo json_encode($respuesta);
    }


    public function insObjetos()
    {
        error_reporting(0);
        header('Content-type: application/json; charset = utf-8');
        date_default_timezone_set("America/Tegucigalpa");
        $id       = $_POST['id'];
        $menus    = $_POST['menu'];
        $descripcion = $_POST['descripcion'];
        $tipo_objeto = $_POST['tipo_objeto'];
        $icon = $_POST['icono'];
        $url = $_POST['url'];
        $estado = $_POST['estado'];
        $idpadre = isset($_POST['menupadre']) ? $_POST['menupadre'] : 0;
        $creado = $_SESSION['admin']['usuario'];
        
        //BITACORA
        // $fecha = date("yy-M-d h:ia");
        // $usuario = $_SESSION['admin']['cod_usuario'];
        // $menu = $_SESSION['menu'];
        //fin
       if (!empty($menus)) {
            $mysqli = database::connect();
            if ($mysqli->connect_errno) {
                $respuesta = [
                    'error' => true,
                    'mensaje' => 'fallo la conexion'
                ];
            } else {
                $sql = "SELECT * FROM tbl_ms_roles WHERE  rol = '$menus'";
                $result = mysqli_query($mysqli, $sql);
                $contar = mysqli_num_rows($result);
                if ($contar == 0) {

                    $sql = "CALL spTbl_ms_Objetos_Insertar('$menus','$descripcion','$tipo_objeto','$idpadre','$icon','$url','$estado','$creado')";
                    $result = mysqli_query($mysqli, $sql);

                    if ($result) {
                         // INSERTAR EN BITACORA
                        // $Auth = new Auth();
                        // $No_Pantalla = 9;
                        // $Accion = "Insertar";
                        // $Descripción = "Insertó un menu al sistema";
                        // $Auth->InsertarBitacora($No_Pantalla, $Accion, $Descripción);
                        $respuesta = [
                            'error'   => false,
                            'mensaje' => 'Menu agregado correctamente'
                        ];
                    } else {
                        $respuesta = [
                            'error'   => true,
                            'mensaje' => 'Hubo un error al agregar el Menu' . $mysqli->error
                        ];
                    }
                } else {
                    $respuesta = [
                        'error' => true,
                        'mensaje' => 'El Menu ya existe '
                    ];
                }
            }
        } else {
            $respuesta = [
                'error' => true,
                'mensaje' => 'Por favor rellenar los campos ' . $menus
            ];
        }

        echo json_encode($respuesta);
    }
}