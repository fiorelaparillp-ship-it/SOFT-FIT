<?php
/** @var mysqli $conexion */
require('../fpdf/fpdf.php');
include('../includes/conexion.php');

$inicio = $_GET['inicio'];
$fin = $_GET['fin'];

$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);

$pdf->Cell(
190,
10,
'REPORTE DE VENTAS POR FECHA - SOFT-FIT',
0,
1,
'C'
);

$pdf->Ln(5);

$pdf->SetFont('Arial','',12);

$pdf->Cell(
190,
10,
'Desde: '.$inicio.'   Hasta: '.$fin,
0,
1,
'C'
);

$pdf->Ln(5);

/* ENCABEZADOS */

$pdf->SetFont('Arial','B',10);

$pdf->Cell(20,10,'ID',1);
$pdf->Cell(60,10,'Fecha',1);
$pdf->Cell(50,10,'Metodo',1);
$pdf->Cell(40,10,'Total',1);

$pdf->Ln();

/* CONSULTA */

$ventas = mysqli_query($conexion,

"SELECT *
FROM ventas
WHERE DATE(fecha)
BETWEEN '$inicio' AND '$fin'
ORDER BY fecha DESC");

$pdf->SetFont('Arial','',10);

$totalGeneral = 0;

while($v = mysqli_fetch_assoc($ventas)){

    $pdf->Cell(20,10,$v['id'],1);
    $pdf->Cell(60,10,$v['fecha'],1);
    $pdf->Cell(50,10,$v['metodo_pago'],1);
    $pdf->Cell(40,10,'S/ '.$v['total'],1);

    $pdf->Ln();

    $totalGeneral += $v['total'];
}

/* TOTAL */

$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);

$pdf->Cell(
170,
10,
'TOTAL VENDIDO:',
1
);

$pdf->Cell(
20,
10,
'S/'.$totalGeneral,
1
);

$pdf->Output();

?>