<?php
	require 'fpdf/fpdf.php';
	
	class PDF extends FPDF
	{
		function Header()
		{
			$this->Image('img/otac.jpg', 15, 10 , 45 );
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

			$this->SetFont('times','B',18);
			$this->Cell(30);
			$this->Cell(120,10, 'Reporte de Ventas',0,0,'C');
			$this->Ln(30);
		}
		
		function Footer()
		{
			$this->SetY(-10);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
		}		
	}
?>