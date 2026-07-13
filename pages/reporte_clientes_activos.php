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
'REPORTE DE CLIENTES ACTIVOS - SOFT-FIT',
0,
1,
'C'
);

$pdf->Ln(10);

/* ENCABEZADOS */

$pdf->SetFont('Arial','B',10);

$pdf->Cell(20,10,'ID',1);
$pdf->Cell(70,10,'Cliente',1);
$pdf->Cell(50,10,'Plan',1);
$pdf->Cell(50,10,'Inicio',1);
$pdf->Cell(50,10,'Fin',1);
$pdf->Cell(30,10,'Estado',1);

$pdf->Ln();

/* CONSULTA */

$consulta = mysqli_query($conexion,

"SELECT
clientes.nombre,
membresias.*,
planes_membresia.plan

FROM membresias

INNER JOIN clientes
ON membresias.cliente_id = clientes.id

INNER JOIN planes_membresia
ON membresias.plan_id = planes_membresia.id

WHERE membresias.estado='Activa'

ORDER BY clientes.nombre ASC");

$pdf->SetFont('Arial','',10);

while($c = mysqli_fetch_assoc($consulta)){

    $pdf->Cell(20,10,$c['id'],1);
    $pdf->Cell(70,10,utf8_decode($c['nombre']),1);
    $pdf->Cell(50,10,utf8_decode($c['plan']),1);
    $pdf->Cell(50,10,$c['fecha_inicio'],1);
    $pdf->Cell(50,10,$c['fecha_fin'],1);
    $pdf->Cell(30,10,$c['estado'],1);

    $pdf->Ln();
}

$pdf->Output();

?>