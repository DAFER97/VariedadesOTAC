<?php
date_default_timezone_set("America/Tegucigalpa");
	include 'views/plantillaBitacora.php';
	require 'conexion.php';
	
	
$query = "SELECT b.id_bitacora, b.fecha, u.usuario, o.objeto, b.accion, b.descripcion, b.fecha_creacion  FROM tbl_ms_bitacora b inner join tbl_ms_usuario u
    on b.TBL_MS_USUARIO_id_usuario = u.id_usuario inner join tbl_ms_objetos o on b.TBL_MS_OBJETOS_id_objeto = o.id_objeto";

	$resultado = $mysqli->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(15,6,'ID',1,0,'C',1);
	$pdf->Cell(30,6,'FECHA',1,0,'C',1);
	$pdf->Cell(30,6,'PANTALLA',1,0,'C',1);
	$pdf->Cell(30,6,'ACCION',1,0,'C',1);
	$pdf->Cell(30,6,'USUARIO',1,0,'C',1);
	$pdf->Cell(60,6,'DESCRIPCION',1,0,'C',1);

	$pdf->Ln(6);
	$pdf->SetFont('Arial','',7);
	
	while($row = $resultado->fetch_assoc())
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(15,6,$row['id_bitacora'],1,0,'C',1);
		$pdf->Cell(30,6,utf8_decode($row['fecha']),1,0,'C',1);
		$pdf->Cell(30,6,utf8_decode($row['objeto']),1,0,'C',1);
		$pdf->Cell(30,6,utf8_decode($row['accion']),1,0,'C',1);
		$pdf->Cell(30,6,utf8_decode($row['usuario']),1,0,'C',1);
		$pdf->Cell(60,6,utf8_decode($row['descripcion']),1,0,'C',1);
		

		$pdf->Ln(6);
	}
	$pdf->Ln(3);
	$pdf->Output();
?>