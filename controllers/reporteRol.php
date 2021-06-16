<?php
	include 'views/plantillaRol.php';
	require 'conexion.php';
	
	$query = "SELECT * FROM tbl_ms_roles ";
	$resultado = $mysqli->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(15,6,'ID',1,0,'C',1);
	$pdf->Cell(20,6,'ROL',1,0,'C',1);
	$pdf->Cell(20,6,'DESCRIPCION',1,0,'C',1);
	$pdf->Cell(20,6,'CREACION',1,0,'C',1);
	$pdf->Cell(20,6,'CREADO POR',1,0,'C',1);
	$pdf->Cell(20,6,'MODIFICACION',1,0,'C',1);
	$pdf->Cell(20,6,'MODIFICADO POR',1,0,'C',1);

	$pdf->Ln(6);
	$pdf->SetFont('Arial','',6);
	
	while($row = $resultado->fetch_assoc())
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(15,6,$row['id_rol'],1,0,'C',1);
		$pdf->Cell(20,6,utf8_decode($row['rol']),1,0,'C',1);
		$pdf->Cell(20,6,utf8_decode($row['descripcion']),1,0,'C',1);
		$pdf->Cell(20,6,utf8_decode($row['fecha_creacion']),1,0,'C',1);
		$pdf->Cell(20,6,utf8_decode($row['creado_por']),1,0,'C',1);
		$pdf->Cell(20,6,utf8_decode($row['fecha_modificacion']),1,0,'C',1);
		$pdf->Cell(20,6,utf8_decode($row['modificado_por']),1,0,'C',1);

		$pdf->Ln(6);
	}
	$pdf->Output();
?>