<?php
/** @var mysqli $conexion */
ob_start();

require('../fpdf/fpdf.php');
include('../includes/conexion.php');

$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);

$pdf->Cell(
190,
10,
'REPORTE DE CLIENTES - SOFT-FIT',
0,
1,
'C'
);

$pdf->Ln(10);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(10,10,'ID',1);
$pdf->Cell(50,10,'Nombre',1);
$pdf->Cell(30,10,'DNI',1);
$pdf->Cell(35,10,'Telefono',1);
$pdf->Cell(65,10,'Correo',1);

$pdf->Ln();

$pdf->SetFont('Arial','',10);

$clientes = mysqli_query(
$conexion,
"SELECT * FROM clientes"
);

while($c = mysqli_fetch_assoc($clientes)){

$nombre = mb_convert_encoding($c['nombre'], 'ISO-8859-1', 'UTF-8');
$correo = mb_convert_encoding($c['correo'], 'ISO-8859-1', 'UTF-8');

    $pdf->Cell(10,10,$c['id'],1);
    $pdf->Cell(50,10,$nombre,1);
    $pdf->Cell(30,10,$c['dni'],1);
    $pdf->Cell(35,10,$c['telefono'],1);
    $pdf->Cell(65,10,$correo,1);

    $pdf->Ln();
}

ob_end_clean();

$pdf->Output('I','reporte_clientes.pdf');

?>