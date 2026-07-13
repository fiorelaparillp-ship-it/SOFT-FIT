<?php
/** @var mysqli $conexion */
require('../fpdf/fpdf.php');
include('../includes/conexion.php');

$pdf = new FPDF('L');

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);

$pdf->Cell(
0,
10,
'REPORTE DE ASISTENCIAS - SOFT-FIT',
0,
1,
'C'
);

$pdf->Ln(10);

/* ENCABEZADOS */

$pdf->SetFont('Arial','B',11);

$pdf->Cell(20,10,'ID',1);
$pdf->Cell(90,10,'Cliente',1);
$pdf->Cell(50,10,'Fecha',1);
$pdf->Cell(50,10,'Hora',1);

$pdf->Ln();

/* DATOS */

$pdf->SetFont('Arial','',10);

$consulta = mysqli_query($conexion,

"SELECT
asistencias.*,
clientes.nombre

FROM asistencias

INNER JOIN clientes
ON asistencias.cliente_id = clientes.id

ORDER BY asistencias.id DESC");

while($a = mysqli_fetch_assoc($consulta)){

    $cliente = utf8_decode($a['nombre']);

    $pdf->Cell(20,10,$a['id'],1);
    $pdf->Cell(90,10,$cliente,1);
    $pdf->Cell(50,10,$a['fecha'],1);
    $pdf->Cell(50,10,$a['hora'],1);

    $pdf->Ln();
}

$pdf->Output();

?>