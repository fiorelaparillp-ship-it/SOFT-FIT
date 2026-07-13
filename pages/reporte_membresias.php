<?php
/** @var mysqli $conexion */
require('../fpdf/fpdf.php');
include('../includes/conexion.php');

$pdf = new FPDF('L'); // Horizontal

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);

$pdf->Cell(
0,
10,
'REPORTE DE MEMBRESIAS - SOFT-FIT',
0,
1,
'C'
);

$pdf->Ln(10);

/* ENCABEZADOS */

$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,10,'ID',1);
$pdf->Cell(60,10,'Cliente',1);
$pdf->Cell(40,10,'Plan',1);
$pdf->Cell(35,10,'Inicio',1);
$pdf->Cell(35,10,'Fin',1);
$pdf->Cell(35,10,'Estado',1);

$pdf->Ln();

/* DATOS */

$pdf->SetFont('Arial','',10);

$consulta = mysqli_query($conexion,


"SELECT
membresias.*,
clientes.nombre,
planes_membresia.plan AS plan

FROM membresias

INNER JOIN clientes
ON membresias.cliente_id = clientes.id

INNER JOIN planes_membresia
ON membresias.plan_id = planes_membresia.id

ORDER BY membresias.id DESC");
if(!$consulta){
    die(mysqli_error($conexion));
}

while($m = mysqli_fetch_assoc($consulta)){

    $cliente = utf8_decode($m['nombre']);
    $plan = utf8_decode($m['plan']);

    $pdf->Cell(15,10,$m['id'],1);
    $pdf->Cell(60,10,$cliente,1);
    $pdf->Cell(40,10,$plan,1);
    $pdf->Cell(35,10,$m['fecha_inicio'],1);
    $pdf->Cell(35,10,$m['fecha_fin'],1);
    $pdf->Cell(35,10,$m['estado'],1);

    $pdf->Ln();
}

$pdf->Output();

?>