<?php

class AjaxPermisosController {
     
     public function getPermisos()
     {
         error_reporting(0);
         header('Content-type: application/json; charset = utf-8');
 
         $mysqli = Database::connect();
 
         if (!$mysqli->connect_errno) {
             $mysqli->set_charset('utf8');

             $arreglo = array();
            
            $statement = ('call spTbl_ms_Permisos_Mostrar()');
            $resultado = mysqli_query($mysqli, $statement);
           
             if(!$resultado== ""){
                while ($data = mysqli_fetch_assoc($resultado)) {
                    $arreglo['data'][] = $data;
            }
             }
          
            echo json_encode($arreglo);
         } else {
             $respuesta = [
                 'error' => true
             ];
         }
 
     }
    //  INSERTAR PERMISO
    public function InsPermisos()
    {
        error_reporting(0);
        header('Content-type: application/json; charset = utf-8');

        $rol       = $_POST['rol'];
        $objeto    = $_POST['objeto'];
        $insert = isset($_POST['agregar']) ? 1 : 0;
        $eliminar = isset($_POST['eliminar']) ? 1 : 0;
        $actualizar = isset($_POST['actualizar']) ? 1 : 0;
        $mostrar = isset($_POST['mostrar']) ? 1 : 0;
        $creado = $_SESSION['admin']['usuario'];
        
        if(!empty($rol) && !empty($objeto)){
            $mysqli = Database::connect();

            if ($mysqli->connect_errno) {
                $respuesta = [
                    'error' => true,
                    'mensaje' => 'fallo la conexion'
                ];
            }else{
                 $sql = "select TBL_MS_ROLES_id_rol from tbl_ms_permisos where TBL_MS_ROLES_id_rol = ' $rol ' and TBL_MS_OBJETOS_id_objeto = '$objeto'";
              
            //    $sql = " INSERT INTO `db_variedadesotaci`.`tbl_ms_permisos` ( `TBL_MS_ROLES_id_rol`, `TBL_MS_OBJETOS_id_objeto`, `permiso_insercion`, `permiso_eliminacion`, `permiso_actualizacion`, `permiso_consultar`, `creado_por`, `fecha_creacion`) 
            //     VALUES ('$rol', '$objeto', '$insert', '$eliminar', '$actualizar', '$mostrar', '$creado', '2021-10-10')";
                $result = mysqli_query($mysqli,$sql);
                $contar = mysqli_num_rows($result);
                if ($contar == 0) {
                    $sql1 = "call spTbl_ms_Permisos_Insertar('$rol','$objeto','$insert','$eliminar','$actualizar','$mostrar','$creado')";
                    $result1 = mysqli_query($mysqli,$sql1);

                    $respuesta = [
                        'error' => false,
                        'mensaje' => 'agregado correctamente'

                    ];
                   
                }else{
                    


                    // ESTA ONDA HACIA QUE ME FALLARA LA PETICION PERO ME INSERTARA !!
                    //  
                    //  

                    // $Auth = new Auth();
                    //     $No_Pantalla=1;
                    //     $Accion="Insertar";
                    //     $Descripción="Insertó un nuevo permiso";
                    //     $Auth->InsertarBitacora($No_Pantalla,$Accion,$Descripción);
                    $respuesta = [
                        'error' => true,
                        'mensaje' => 'No se puede insetar un rol con su respectivo permiso que ya existe' 
                    ];

                   
                }
            }
        } else {
            $respuesta = [
                'error' => true,
                'mensaje' => 'Por favor rellene los campos '

            ];
        }


        echo json_encode($respuesta);
    }

    public function eliPermiso()
    {
        utils::isAdmin();
        error_reporting(0);
        header('Content-type: application/json; charset utf-8');

        $id = intval($_GET['id']);
        //$cod_usuario = $_SESSION['admin']['cod_usuario'];
        //$menu = $_SESSION['menu'];
        $mysqli = Database::connect();

        if ($mysqli->connect_errno) {
            $respuesta = [
                'error' => true,
                'mensaje' => 'fallo a conexion'
            ];
        } else {

             $sql = "call spTbl_ms_Permisos_Eliminar('$id')";

            // $sql = "DELETE FROM `db_variedadesotaci`.`tbl_ms_permisos` WHERE  `id_permiso`='$id'";
            $result = mysqli_query($mysqli, $sql);

            if ($mysqli->affected_rows <= 0) {
                $respuesta = [
                    'error' => true,
                    'mensaje' => 'no se pudo borrar' . $mysqli->error
                ];
            } else {
                $respuesta  = [
                    'error' => false,
                    'mensaje' => 'borrado correctamente '
                ];
            }
        }

        echo json_encode($respuesta);
    }

    public function updPermisos()
    {
        error_reporting(0);
        header('Content-type: application/json; charset = utf-8');

        $id        = $_POST['id'];
        $rol       = $_POST['rol'];
        $objeto    = $_POST['objeto'];
        $insert = isset($_POST['agregar']) ? 1 : 0;
        $eliminar = isset($_POST['eliminar']) ? 1 : 0;
        $actualizar = isset($_POST['actualizar']) ? 1 : 0;
        $mostrar = isset($_POST['mostrar']) ? 1 : 0;
        $modificado = $_SESSION['admin']['usuario'];
            $mysqli = database::connect();
            if ($mysqli->connect_errno) {
                $respuesta = [
                    'error' => true,
                    'mensaje' => 'fallo la conexion'
                ];
            } else {

          

                $sql = "call spTbl_ms_Permisos_Actualizar('$insert','$eliminar','$actualizar','$mostrar','$modificado','$id')";
                $result = mysqli_query($mysqli,$sql);
                if ($result->affected_rows == 1) {
                    $respuesta = [
                        'error' => true,
                        'mensaje' => 'no se ha podido actualizar, no puede tener valores duplicados',
                    ];
                } else {

                    $respuesta = [
                        'error'   => false,
                        'mensaje' => 'Actualizado correctamente'
                    ];
                }
            }
        

        echo json_encode($respuesta);
    }
}
