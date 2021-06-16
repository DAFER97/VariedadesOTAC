<?php
date_default_timezone_set("America/Tegucigalpa");
	include 'views/plantillaUsuario.php';
	require 'conexion.php';
	
	

    $query = "SELECT * FROM tbl_ms_usuario";
	$resultado = $mysqli->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(15,6,'ID',1,0,'C',1);
	$pdf->Cell(25,6,'USUARIO',1,0,'C',1);
	$pdf->Cell(27,6,'NOMBRE',1,0,'C',1);
	$pdf->Cell(27,6,'APELLIDO',1,0,'C',1);
	$pdf->Cell(48,6,'CORREO',1,0,'C',1);
	$pdf->Cell(25,6,'CREADO POR',1,0,'C',1);
	$pdf->Cell(25,6,'CREACION',1,0,'C',1);

	$pdf->Ln(6);
	$pdf->SetFont('Arial','',7);
	
	while($row = $resultado->fetch_assoc())
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(15,6,$row['id_usuario'],1,0,'C',1);
		$pdf->Cell(25,6,utf8_decode($row['usuario']),1,0,'C',1);
		$pdf->Cell(27,6,utf8_decode($row['nombre_usuario']),1,0,'C',1);
		$pdf->Cell(27,6,utf8_decode($row['apellido_usuario']),1,0,'C',1);
		$pdf->Cell(48,6,utf8_decode($row['correo_usuario']),1,0,'C',1);
		$pdf->Cell(25,6,utf8_decode($row['creado_por']),1,0,'C',1);
		$pdf->Cell(25,6,utf8_decode($row['fecha_creacion']),1,0,'C',1);
		

		$pdf->Ln(6);
	}
	$pdf->Ln(3);
	$pdf->Output();
?>