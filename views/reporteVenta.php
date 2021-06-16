<?php
date_default_timezone_set("America/Tegucigalpa");
	include 'views/plantillaVenta.php';
	require 'conexion.php';
	
	$query = "SELECT
            tbl_ventas.fecha_venta, 
            tbl_ventas.total_venta, 
            tbl_ventas.id_venta, 
            tbl_clientes.DNI, 
            tbl_clientes.nombre_cliente
        FROM
         tbl_ventas
         INNER JOIN tbl_clientes ON tbl_ventas.id_cliente = tbl_clientes.id_cliente";

	$resultado = $mysqli->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(30,6,'ID DE VENTA',1,0,'C',1);
	$pdf->Cell(40,6,'FECHA',1,0,'C',1);
	$pdf->Cell(40,6,'CANTIDAD VENDIDA',1,0,'C',1);
	$pdf->Cell(40,6,'CLIENTE',1,0,'C',1);
	$pdf->Cell(40,6,'IDENTIDAD',1,0,'C',1);


	$pdf->Ln(6);
	$pdf->SetFont('Arial','',6);
	
	while($row = $resultado->fetch_assoc())
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(30,6,$row['id_venta'],1,0,'C',1);
		$pdf->Cell(40,6,utf8_decode($row['fecha_venta']),1,0,'C',1);
		$pdf->Cell(40,6,utf8_decode($row['total_venta']),1,0,'C',1);
		$pdf->Cell(40,6,utf8_decode($row['nombre_cliente']),1,0,'C',1);
		$pdf->Cell(40,6,utf8_decode($row['DNI']),1,0,'C',1);
		
		$pdf->Ln(6);
	}
	$pdf->Output();
?>