<?php
date_default_timezone_set("America/Tegucigalpa");
	include 'views/plantillaClientes2.php';
	require 'conexion.php';

	
$query = "SELECT * FROM tbl_clientes";
$resultado = $mysqli->query($query);




  
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
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
	
	while($row = $resultado->fetch_assoc())
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(15,6,$row['id_cliente'],1,0,'C',1);
		$pdf->Cell(33,6,utf8_decode($row['DNI']),1,0,'C',1);
		$pdf->Cell(33,6,utf8_decode($row['nombre_cliente']),1,0,'C',1);
		$pdf->Cell(36,6,utf8_decode($row['telefono_cliente']),1,0,'C',1);
		$pdf->Cell(36,6,utf8_decode($row['direccion_cliente']),1,0,'C',1);
		$pdf->Cell(36,6,utf8_decode($row['fecha_creacion']),1,0,'C',1);

		$pdf->Ln(6);
	}
	$pdf->Output();
?>