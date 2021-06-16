<?php
 error_reporting(E_ALL);
    ini_set('display_errors', '1');

 
	include_once('../config/db.php');
	include_once('../fpdf/fpdf.php'); 

$db = Database::connect();

 


		  $p = $_GET['id'];
		  $sql = "SELECT * FROM tbl_clientes WHERE id_cliente = '$p' ";
		  $result  = mysqli_query($db,$sql);
 		  $row     = mysqli_fetch_assoc($result);


class PDF extends FPDF {

	 function Footer(){
         $fecha_actual = new DateTime();
        $fec = $fecha_actual->format("Y-m-d H:i:s");
        //$usu=mb_strimwidth($_SESSION["user_name"], 0, 19, "");
        $this->SetY(-15);
        $this->SetFont('Courier','I',8);
        $this->Cell(80,5,utf8_decode('OTAC'),0,0,'L');
        //$this->Cell(30,5,'Usuario: '.$usu,0,0,'L');
        $this->Cell(40,5,'Fecha: '.$fec,0,0,'L');
        $this->Cell(40,5,utf8_decode('PÃ¡gina: '.$this->PageNo()).'/{nb}',0,0,'R');

    }

    function Header(){
    	 $this->Image('../img/otac.jpg', 15, 10 , 45 );
			$this->SetFont('times','B',15);
			$this->Cell(30);
			$this->Cell(120,10, 'VARIEDADES OTAC',0,0,'C');
			$this->Ln(5);

			$this->SetFont('times','B',10);
			$this->Cell(30);
			$this->Cell(120,10, 'Barrio el coyol, Santa Lucia FM',0,0,'C');
			$this->Ln(5);

			$this->SetFont('times','B',10);
			$this->Cell(30);
			$this->Cell(120,10, 'Telefono: 9730-1206',0,0,'C');
			$this->Ln(5);

			$this->SetFont('times','B',10);
			$this->Cell(30);
			$this->Cell(120,10,date('F j, Y, g:i a'),0,0,'C');
			$this->Ln(10);

			$this->SetFont('times','B',14);
			$this->Cell(30);
			$this->Cell(120,10, 'Reporte de clientes',0,0,'C');
			$this->Ln(30);
    }

}


    $pdf = new PDF();
    $pdf->AddPage('p', 'a4'); //Vertical, Carta
    $pdf->SetFont('Arial','B',9);
    $pdf->AliasNbPages();

 
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(15,6,'ID',1,0,'C',1);
	$pdf->Cell(33,6,'DNI',1,0,'C',1);
	$pdf->Cell(33,6,'NOMBRE',1,0,'C',1);
	$pdf->Cell(36,6,'TELEFONO',1,0,'C',1);
	$pdf->Cell(36,6,'DIRECCION',1,0,'C',1);
	$pdf->Cell(36,6,'FECHA CREACION',1,0,'C',1);

	$pdf->Ln(6);
	$pdf->SetFont('Arial','',8);
	
	 
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(15,6,$row['id_cliente'],1,0,'C',1);
		$pdf->Cell(33,6,utf8_decode($row['DNI']),1,0,'C',1);
		$pdf->Cell(33,6,utf8_decode($row['nombre_cliente']),1,0,'C',1);
		$pdf->Cell(36,6,utf8_decode($row['telefono_cliente']),1,0,'C',1);
		$pdf->Cell(36,6,utf8_decode($row['direccion_cliente']),1,0,'C',1);
		$pdf->Cell(36,6,utf8_decode($row['fecha_creacion']),1,0,'C',1);

		 
	 
	$pdf->Output();
?>