<?php

date_default_timezone_set("America/Tegucigalpa");
	include 'views/plantillaPermisos.php';
	require 'conexion.php';
	
	$query = "SELECT p.id_permiso, r.rol, r.descripcion, o.objeto, p.permiso_consultar, p.permiso_actualizacion, p.permiso_eliminacion, p.permiso_insercion  FROM tbl_ms_permisos p inner join tbl_ms_roles r
    on p.TBL_MS_ROLES_id_rol = r.id_rol inner join tbl_ms_objetos o on p.TBL_MS_OBJETOS_id_objeto = o.id_objeto";
	$resultado = $mysqli->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(10,6,'ID',1,0,'C',1);
	$pdf->Cell(25,6,'ROL',1,0,'C',1);
	$pdf->Cell(25,6,'DESCRIPCION',1,0,'C',1);
	$pdf->Cell(25,6,'OBJETO',1,0,'C',1);
	$pdf->Cell(25,6,'ACTUALIZAR',1,0,'C',1);
	$pdf->Cell(25,6,'ELIMINAR',1,0,'C',1);
	$pdf->Cell(25,6,'CONSULTAR',1,0,'C',1);
	$pdf->Cell(25,6,'INSERTAR',1,0,'C',1);
	
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',6);
	
	while($row = $resultado->fetch_assoc())
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(10,6,$row['id_permiso'],1,0,'C',1);
		$pdf->Cell(25,6,utf8_decode($row['rol']),1,0,'C',1);
		$pdf->Cell(25,6,utf8_decode($row['descripcion']),1,0,'C',1);
		$pdf->Cell(25,6,utf8_decode($row['objeto']),1,0,'C',1);
		$pdf->Cell(25,6,utf8_decode($row['permiso_actualizacion']),1,0,'C',1);
		$pdf->Cell(25,6,utf8_decode($row['permiso_eliminacion']),1,0,'C',1);
		$pdf->Cell(25,6,utf8_decode($row['permiso_consultar']),1,0,'C',1);
		$pdf->Cell(25,6,utf8_decode($row['permiso_insercion']),1,0,'C',1);
		$pdf->Ln(6);
	}
	$pdf->Output();
?>