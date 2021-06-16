<?php
date_default_timezone_set("America/Tegucigalpa");
	include 'views/plantillaObjeto.php';
	require 'conexion.php';
	
	$query = "SELECT * FROM tbl_ms_objetos ";
	$resultado = $mysqli->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(10,6,'ID',1,0,'C',1);
	$pdf->Cell(41,6,'DESCRIPCION',1,0,'C',1);
	$pdf->Cell(40,6,'OBJETO',1,0,'C',1);
	$pdf->Cell(20,6,'TIPO',1,0,'C',1);
	$pdf->Cell(20,6,'CREADO POR',1,0,'C',1);
	$pdf->Cell(20,6,'ESTADO',1,0,'C',1);
	$pdf->Cell(20,6,'CREACION',1,0,'C',1);
	$pdf->Cell(22,6,'MODIFICADO POR',1,0,'C',1);

	$pdf->Ln(6);
	$pdf->SetFont('Arial','',6);
	
	while($row = $resultado->fetch_assoc())
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(10,6,$row['id_objeto'],1,0,'C',1);
		$pdf->Cell(41,6,utf8_decode($row['descripcion']),1,0,'C',1);
		$pdf->Cell(40,6,utf8_decode($row['objeto']),1,0,'C',1);
		$pdf->Cell(20,6,utf8_decode($row['tipo_objeto']),1,0,'C',1);
		$pdf->Cell(20,6,utf8_decode($row['creado_por']),1,0,'C',1);
		$pdf->Cell(20,6,utf8_decode($row['estado']),1,0,'C',1);
		$pdf->Cell(20,6,utf8_decode($row['fecha_creacion']),1,0,'C',1);
		$pdf->Cell(22,6,utf8_decode($row['modificado_por']),1,0,'C',1);
		$pdf->Ln(6);
	}
	$pdf->Output();
?>