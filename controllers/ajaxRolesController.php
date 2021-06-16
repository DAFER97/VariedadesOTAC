<?php
class ajaxRolesController
{

    public function getRoles()
    {
        error_reporting(0);
        header('Content-type: application/json; charset = utf-8');

        $mysqli = Database::connect();

        if (!$mysqli->connect_errno) {
            $mysqli->set_charset('utf8');

            $statement = "call spTbl_ms_Roles_Mostrar()";
            $resultado = mysqli_query($mysqli, $statement);
            while ($data = mysqli_fetch_assoc($resultado)) {
                $arreglo['data'][] = $data;
            }

            echo json_encode($arreglo);
        }
    }

    public function delRoles()
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
            $statement = $mysqli->prepare('DELETE FROM tbl_ms_roles where id_rol = ?');
            $statement->bind_param('i', $id);
            $statement->execute();
           
             // EL PROCEDIMIENTO NO EXISTE EN  EL SERVIODR Y POR CONSECUENCIA NO LLEGA BIEN EL JSON
           
            // INSERTAR EN BITACORA
            // $Auth = new Auth();
            // $No_Pantalla = 9;
            // $Accion = "Eliminar";
            // $Descripción = "Eliminó un rol de usuario";
            // $Auth->InsertarBitacora($No_Pantalla, $Accion, $Descripción);

            if ($mysqli->affected_rows <= 0) {
                $respuesta = [
                    'error' => true,
                    'mensaje' => 'no se puedo borrar'
                ];
            } else {
                $respuesta  = [
                    'error' => false,
                    'mensaje' => 'Esatdo eliminado'
                ];
            }
        }


        echo json_encode($respuesta);
    }

    public function updRoles()
    {

        error_reporting(0);
        header('Content-type: application/json; charset = utf-8');

        $id              = $_POST['id'];
        $nombre_rol   = $_POST['nombre_rol'];
        $nombre_rolv  = $_POST['nombre_rol'];
        $Descripcion = $_POST['descripcion_rol'];
        $usr_registro = $_SESSION['admin']['usuario'];
        //BITACORA
        // date_default_timezone_set("America/Tegucigalpa");
        // $fecha = date("yy-M-d h:ia");
        // $usuario = $_SESSION['admin']['cod_usuario'];
        // $menu = $_SESSION['menu'];
        //fin

        if (!empty($id)&&!empty($nombre_rol)&&!empty($Descripcion)) {

            $mysqli = Database::connect();

            if ($mysqli->connect_errno) {
                $respuesta = [
                    'error' => true,
                    'mensaje' => 'fallo la conexion'
                ];
            } else {

                $sql = "SELECT rol FROM tbl_ms_roles WHERE rol   = '$nombre_rol";
                $result = mysqli_query($mysqli, $sql);
                $contar = mysqli_num_rows($result);
                if ($nombre_rol== $nombre_rolv) {
                    // $sql = "UPDATE tblimagenes SET nombre_rol= '$hotel', imagen = '$imagen', direccion = '$direccion', latitud = '$latitud', longitud = '$longitud' WHERE cod_hotel = '$id'";
                    $sql = "call spTbl_ms_Roles_Actualizar('$id','$nombre_rol','$Descripcion','$usr_registro')";


                    $result = mysqli_query($mysqli, $sql);
                    if ($mysqli->affected_rows <= 0) {
                        $respuesta = [
                            'error' => true,
                            'mensaje' => 'Error al querer actualizar' . $sql
                        ];
                    } else {
                        //BITACORA QUITADA PORQUE NO ESTA EL PROCEDIMIENTO!!

                          // INSERTAR EN BITACORA
                        //     $Auth = new Auth();
                        //     $No_Pantalla = 9;
                        //     $Accion = "Actualizar";
                        //     $Descripción = "Actualizo un rol de usuario";
                        //     $Auth->InsertarBitacora($No_Pantalla, $Accion, $Descripción);
                        $respuesta = [
                            'error'   => false,
                            'mensaje' => 'actualizado correctamente'
                        ];
                    }
                } else {
                    $respuesta = [
                        'mensaje' => 'Este rol ya existe, actualizar con otro nombre',
                        'error' => true
                    ];
                }
            }
        } else {
            $respuesta = [
                'error' => true,
                'mensaje' => 'Por favor rellenar los campos'
            ];
        }

        echo json_encode($respuesta);
    }


    public function insRoles()
    {
        error_reporting(0);
        header('Content-type: application/json; charset = utf-8');
        date_default_timezone_set("America/Tegucigalpa");
        $id          = $_POST['id'];
        $nombre_rol  = $_POST['nombre_rol'];
        $Descripcion = $_POST['descripcion_rol'];
        $usr_registro = $_SESSION['admin']['nom_usuario'] . ' ' .  $_SESSION['admin']['apell_usuario'];
        
        //BITACORA
        // $fecha = date("yy-M-d h:ia");
        // $usuario = $_SESSION['admin']['cod_usuario'];
        // $menu = $_SESSION['menu'];
        //fin
      

       if (!empty($nombre_rol)) {
            $mysqli = database::connect();
            if ($mysqli->connect_errno) {
                $respuesta = [
                    'error' => true,
                    'mensaje' => 'fallo la conexion'
                ];
            } else {
                $sql = "SELECT * FROM tbl_ms_roles WHERE  rol = '$nombre_rol'";
                $result = mysqli_query($mysqli, $sql);
                $contar = mysqli_num_rows($result);
                if ($contar == 0) {

                    // $sql = "CALL spTbl_ms_Roles_Insertar('$nombre_rol','$Descripcion',' $usr_registro')";
                    $sql = "CALL spTbl_ms_Roles_Insertar('$nombre_rol','$Descripcion','$usr_registro')";
                    //  INSERT INTO `db_inversionesotaci`.`tbl_ms_roles` (`rol`, `descripcion`, `fecha_creacion`, `creado_por`) VALUES ('Ejecutivo', 'Usuario gerente', '2021-03-13', 'kevin');
                    $result = mysqli_query($mysqli, $sql);

                    if ($result) {

                        //BITACORA QUITADA PORQUE NO ESTA EL PROCEDIMIENTO!!

                         // INSERTAR EN BITACORA
                        // $Auth = new Auth();
                        // $No_Pantalla = 9;
                        // $Accion = "Insertar";
                        // $Descripción = "Insertó un rol de usuario";
                        // $Auth->InsertarBitacora($No_Pantalla, $Accion, $Descripción);
                         $respuesta = [
                            'error'   => false,
                            'mensaje' => 'Rol agregado correctamente'
                        ];
                    } else {
                        $respuesta = [
                            'error'   => true,
                            'mensaje' => 'Hubo un error al agregar el Estado' . $mysqli->error
                        ];
                    }
                } else {
                    $respuesta = [
                        'error' => true,
                        'mensaje' => 'El rol ya existe '
                    ];
                }
            }
        } else {
            $respuesta = [
                'error' => true,
                'mensaje' => 'Por favor rellenar los campos '
            ];
        }

        echo json_encode($respuesta);
    }
}