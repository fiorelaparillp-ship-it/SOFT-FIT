<?php
/** @var mysqli $conexion */
require('../fpdf/fpdf.php');
include('../includes/conexion.php');

$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);

$pdf->Cell(
190,
10,
'REPORTE DE VENTAS - SOFT-FIT',
0,
1,
'C'
);

$pdf->Ln(10);

/* ENCABEZADOS */

$pdf->SetFont('Arial','B',11);

$pdf->Cell(15,10,'ID',1);
$pdf->Cell(60,10,'Cliente',1);
$pdf->Cell(35,10,'Total',1);
$pdf->Cell(50,10,'Fecha',1);
$pdf->Cell(30,10,'Metodo',1);

$pdf->Ln();

/* DATOS */

$pdf->SetFont('Arial','',10);

$ventas = mysqli_query($conexion,

"SELECT

ventas.*,
clientes.nombre

FROM ventas

LEFT JOIN clientes
ON ventas.cliente_id = clientes.id

ORDER BY ventas.id DESC");

while($v = mysqli_fetch_assoc($ventas)){

    $cliente = $v['nombre'];

    if($cliente==""){
        $cliente = "Sin cliente";
    }

    $pdf->Cell(15,10,$v['id'],1);
    $pdf->Cell(60,10,utf8_decode($cliente),1);
    $pdf->Cell(35,10,'S/'.$v['total'],1);
    $pdf->Cell(50,10,$v['fecha'],1);
    $pdf->Cell(30,10,$v['metodo_pago'],1);

    $pdf->Ln();
}

$pdf->Output();

?>