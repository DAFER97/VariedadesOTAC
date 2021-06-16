<?php

    date_default_timezone_set("America/Tegucigalpa");
	include 'views/plantillaProducto.php';
	require 'conexion.php';
	
	$query = "SELECT * FROM tbl_productos";
	$resultado = $mysqli->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(10,6,'ID',1,0,'C',1);
	$pdf->Cell(41,6,'NOMBRE',1,0,'C',1);
	$pdf->Cell(28,6,'DESCRIPCION',1,0,'C',1);
	$pdf->Cell(22,6,'PRECIO',1,0,'C',1);
	$pdf->Cell(22,6,'CANT MAXIMA',1,0,'C',1);
	$pdf->Cell(22,6,'CANT MIN',1,0,'C',1);
	$pdf->Cell(22,6,'STOCK',1,0,'C',1);
	$pdf->Cell(22,6,'FECHA',1,0,'C',1);

	$pdf->Ln(6);
	$pdf->SetFont('Arial','',6);
	
	while($row = $resultado->fetch_assoc())
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(10,6,$row['id_producto'],1,0,'C',1);
		$pdf->Cell(41,6,utf8_decode($row['nombre_producto']),1,0,'C',1);
		$pdf->Cell(28,6,utf8_decode($row['desc_producto']),1,0,'C',1);
		$pdf->Cell(22,6,utf8_decode($row['precio_venta']),1,0,'C',1);
		$pdf->Cell(22,6,utf8_decode($row['cantidad_max']),1,0,'C',1);
		$pdf->Cell(22,6,utf8_decode($row['cantidad_min']),1,0,'C',1);
		$pdf->Cell(22,6,utf8_decode($row['stock']),1,0,'C',1);
		$pdf->Cell(22,6,utf8_decode($row['fecha_registro']),1,0,'C',1);
		
		$pdf->Ln(6);
	}
	$pdf->Output();
?>