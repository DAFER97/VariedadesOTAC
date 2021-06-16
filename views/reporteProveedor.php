<?php
date_default_timezone_set("America/Tegucigalpa");
	include 'views/plantillaProveedor.php';
	require 'conexion.php';
	
	$query = "SELECT * FROM tbl_proveedores ";
	$resultado = $mysqli->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(10,6,'ID',1,0,'C',1);
	$pdf->Cell(41,6,'PROVEEDOR',1,0,'C',1);
	$pdf->Cell(35,6,'CONTACTO',1,0,'C',1);
	$pdf->Cell(35,6,'TELEFONO',1,0,'C',1);
	$pdf->Cell(35,6,'DIRECCION',1,0,'C',1);
	$pdf->Cell(35,6,'CREACION',1,0,'C',1);
	

	$pdf->Ln(6);
	$pdf->SetFont('Arial','',6);
	
	while($row = $resultado->fetch_assoc())
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(10,6,$row['id_proveedor'],1,0,'C',1);
		$pdf->Cell(41,6,utf8_decode($row['proveedor']),1,0,'C',1);
		$pdf->Cell(35,6,utf8_decode($row['contacto']),1,0,'C',1);
		$pdf->Cell(35,6,utf8_decode($row['telefono']),1,0,'C',1);
		$pdf->Cell(35,6,utf8_decode($row['direccion']),1,0,'C',1);
		$pdf->Cell(35,6,utf8_decode($row['fecha_creacion']),1,0,'C',1);
		
		$pdf->Ln(6);
	}
	$pdf->Output();
?>