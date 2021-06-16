<?php
    session_start();
	error_reporting(E_ALL);
    ini_set('display_errors', '1');



	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	date_default_timezone_set("America/Tegucigalpa");

	include_once('../config/db.php');


	
	class api {
		
		function __construct() { 
			$this->db = Database::connect();

			if (isset($_POST['action'])) {
				if ($_POST['action']== "newCategory" ) {
					$this->newCategory();
				}else if ($_POST['action']== "guardarCompra" ) {
					$this->guardarCompra();
				}else if ($_POST['action']== "ajustedeinventario" ) {
					$this->ajustedeinventario();
				}
			}



			if (isset($_GET['action'])) {
				if ($_GET['action']== "DatosCliente" ) {
					$this->DatosCliente();
				}else if ($_GET['action']== "producto" ) {
					$this->producto();
				}
			}
		}


		public function producto(){
		  $p = $_GET['codigo'];
		  $sql = "SELECT * FROM tbl_productos WHERE id_producto = '$p' ";
		  $result  = mysqli_query($this->db,$sql);
 		  $row     = mysqli_fetch_assoc($result);

 		  if ($row) {
 		  	  echo json_encode($row);
 		  }else{
 		  	echo json_encode(array('ok' => false ));
 		  }
        }


        public function DatosCliente(){
		  $DNI = $_GET['dni'];
		  $sql = "SELECT * FROM tbl_clientes WHERE DNI = '$DNI' ";
		  $result  = mysqli_query($this->db,$sql);
 		  $row     = mysqli_fetch_assoc($result);

 		  if ($row) {
 		  	  echo json_encode($row);
 		  }else{
 		  	echo json_encode(array('ok' => false ));
 		  }
        }



		public function newCategory(){
			 $name = $_POST['name'];
			 $q = "INSERT INTO `tbl_categoria`(`nombre_categoria`) VALUES ('$name')";
			 $stmt = $this->db->query($q);

			 if (!$stmt) {
			 	echo json_encode(array('ok' => false, 'err'=> $stmt ));
			 	return;
			 }

			 echo json_encode(array('ok' => true ));
		}





		public function guardarCompra(){
			  $data = json_decode($_POST['productos_row'], true );

			  $this->db->begin_transaction(); 

			  $total = count($data); 
			  $user = $_SESSION['admin']['id_usuario'];
			  $cliente = $_POST['DNI'];
			  $q = "INSERT INTO `tbl_ventas`(`total_venta`, `usuario`, `id_cliente`) VALUES ('$total', '$user','$cliente');";

			  $stmt = $this->db->query($q);
			  if (!$stmt) {
			 	echo json_encode(array('ok' => false, 'err'=> $q ));
			 	$this->db->rollBack();
			 	return;
			  }

			  $id_venta = $this->db->insert_id; 
			  for ($i=0; $i < count($data); $i++) {


			  	 $id_producto = $data[$i]['id_producto_'];
			  	 $cantidad = $data[$i]['cantidad_'];
			  	 $total = $data[$i]['total_'];
			  	 
			  	 $q = "INSERT INTO  `tbl_detalle_venta`(`id_venta`, `id_producto`, `cantidad`, `precio_total`) VALUES ('$id_venta', '$id_producto', '$cantidad', '$total');";
			  	 $stmt = $this->db->query($q);
				 
				 if (!$stmt) {
				 	echo json_encode(array('ok' => false, 'err'=> $q ));
				 	$this->db->rollBack();
				 	return;
				 }


				 $sql = "INSERT INTO `tbl_kardex`( `cantidad_kardex`, `precio`, `id_producto`, `id_tipo_kardex`, `id_usuario`) VALUES ('$cantidad', '$total', '$id_producto', '2', '$user');";
                 $stmt = $this->db->query($sql);
				 
				 if (!$stmt) {
				 	echo json_encode(array('ok' => false, 'err'=> $sql ));
				 	$this->db->rollBack();
				 	return;
				 }

				 $cantidad_ = (intval($data[$i]['stock_']) -  intval($cantidad));
				 $sql = "UPDATE tbl_productos set stock = '$cantidad_' where id_producto ='$id_producto'";
				 $stmt = $this->db->query($sql);
       			 if (!$stmt) {
				 	echo json_encode(array('ok' => false, 'err'=> $sql ));
				 	$this->db->rollBack();
				 	return;
				 }

			  } 

			 $this->db->commit();
			 echo json_encode(array('ok' => true ));


		}


public function guardarCompra2(){
     $data = json_decode($_POST['productos_row'], true );

     $this->db->begin_transaction(); 

     $total = count($data); 
     $user = $_SESSION['admin']['id_usuario'];
     $cliente = $_POST['DNI'];
     $q = "INSERT INTO tbl_ventas`(`total_venta, usuario, `id_cliente`) VALUES ('$total', '$user','$cliente');";

     $stmt = $this->db->query($q);
     if (!$stmt) {
     echo json_encode(array('ok' => false, 'err'=> $q ));
     $this->db->rollBack();
     return;
     }

     $id_venta = $this->db->insert_id; 
     for ($i=0; $i < count($data); $i++) {


       $id_producto = $data[$i]['id_producto_'];
       $cantidad = $data[$i]['cantidad_'];
       $total = $data[$i]['total_'];
       
       $q = "INSERT INTO  tbl_detalle_venta`(`id_venta, id_producto, cantidad, `precio_total`) VALUES ('$id_venta', '$id_producto', '$cantidad', '$total');";
       $stmt = $this->db->query($q);
     
     if (!$stmt) {
      echo json_encode(array('ok' => false, 'err'=> $q ));
      $this->db->rollBack();
      return;
     }


     $sql = "INSERT INTO tbl_kardex`( `cantidad_kardex, precio, id_producto, id_tipo_kardex, `id_usuario`) VALUES ('$cantidad', '$total', '$id_producto', '2', '$user');";
                 $stmt = $this->db->query($sql);
     
     if (!$stmt) {
      echo json_encode(array('ok' => false, 'err'=> $sql ));
      $this->db->rollBack();
      return;
     }

     $cantidad_ = (intval($data[$i]['stock_']) + intval($cantidad));
     $sql = "UPDATE tbl_productos set stock = '$cantidad_' where id_producto ='$id_producto'";
     $stmt = $this->db->query($sql);
           if (!$stmt) {
      echo json_encode(array('ok' => false, 'err'=> $sql ));
      $this->db->rollBack();
      return;
     }

     } 

    $this->db->commit();
    echo json_encode(array('ok' => true ));


  }
		

		function ajustedeinventario(){
			$data = json_decode($_POST['productos_row'], true );
			$this->db->begin_transaction();
			$user = $_SESSION['admin']['id_usuario'];

			for ($i=0; $i < count($data); $i++) {

				 $id_producto = $data[$i]['id_producto_'];
			  	 $cantidad = $data[$i]['cantidad_'];


				$sql = "INSERT INTO `tbl_kardex`( `cantidad_kardex`, `precio`, `id_producto`, `id_tipo_kardex`, `id_usuario`) VALUES ('$cantidad', '0', '$id_producto', '1', '$user');";
                 $stmt = $this->db->query($sql);
				 
				 if (!$stmt) {
				 	echo json_encode(array('ok' => false, 'err'=> $sql ));
				 	$this->db->rollBack();
				 	return;
				 }


				 $cantidad_ = (intval($data[$i]['stock_']) +  intval($cantidad));
				 $sql = "UPDATE tbl_productos set stock = '$cantidad_' where id_producto ='$id_producto'";
				 $stmt = $this->db->query($sql);
       			 if (!$stmt) {
				 	echo json_encode(array('ok' => false, 'err'=> $sql ));
				 	$this->db->rollBack();
				 	return;
				 }
			}

			$this->db->commit();
			 echo json_encode(array('ok' => true ));



		}








 

		  





	}

 $v = new api();
 





