<?php
/** @var mysqli $conexion */
include("../includes/conexion.php");

require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    function Footer()
    {
        $this->SetY(-15);

        $this->SetDrawColor(88,28,135);

        $this->Line(10,$this->GetY(),287,$this->GetY());

        $this->SetFont('Arial','I',8);

        $this->SetTextColor(120,120,120);

        $this->Cell(
            0,
            10,
            'SOFT-FIT | Pagina '.$this->PageNo().' de {nb}',
            0,
            0,
            'C'
        );
    }
}

$pdf = new PDF('L','mm','A4');

$pdf->AliasNbPages();

$pdf->AddPage();

/* Encabezado */

$pdf->SetFillColor(108,52,131);

$pdf->Rect(0,0,297,25,'F');

$pdf->Image('../img/logo1.png',10,1,40);

$pdf->SetTextColor(255,255,255);

$pdf->SetFont('Arial','B',18);

$pdf->Cell(0,10,'SOFT-FIT',0,1,'C');

$pdf->SetFont('Arial','',11);

$pdf->Cell(0,0,utf8_decode('Reporte Resumen Diario'),0,1,'C');

$pdf->Ln(15);

$pdf->SetTextColor(0,0,0);

$pdf->SetFont('Arial','',10);

$pdf->Cell(0,6,'Fecha de emision: '.date('d/m/Y H:i'),0,1,'L');

$pdf->Ln(6);
/* CONSULTAR REPORTE DIARIO */

$consulta = mysqli_query($conexion, "

SELECT *

FROM reporte_ventas_diarias

ORDER BY fecha DESC

");
$pdf->SetFillColor(88,0,135);

$pdf->SetTextColor(255,255,255);

$pdf->SetFont('Arial','B',9);

$pdf->Cell(25,10,'Fecha',1,0,'C',true);

$pdf->Cell(20,10,'Membresias.',1,0,'C',true);

$pdf->Cell(25,10,'Clientes Diarios',1,0,'C',true);

$pdf->Cell(22,10,'Suplementos.',1,0,'C',true);

$pdf->Cell(22,10,'Creatina.',1,0,'C',true);

$pdf->Cell(22,10,'Bebidas',1,0,'C',true);

$pdf->Cell(22,10,'Snacks',1,0,'C',true);

$pdf->Cell(25,10,'Accesor.',1,0,'C',true);

$pdf->Cell(28,10,'Equip.',1,0,'C',true);

$pdf->Cell(35,10,'Total Dia',1,1,'C',true);
$pdf->SetFont('Arial','',9);

$pdf->SetTextColor(0,0,0);

while($fila = mysqli_fetch_assoc($consulta)){

    $totalDia =
        $fila['total_membresias']
        + $fila['total_clientes_diarios']
        + $fila['total_suplementos']
        + $fila['total_creatinas']
        + $fila['total_bebidas']
        + $fila['total_snacks']
        + $fila['total_accesorios']
        + $fila['total_equipamiento'];

    $pdf->Cell(
        25,
        8,
        date("d/m/Y",strtotime($fila['fecha'])),
        1,
        0,
        'C'
    );

    $pdf->Cell(20,8,$fila['membresias'],1,0,'C');

    $pdf->Cell(25,8,$fila['clientes_diarios'],1,0,'C');

    $pdf->Cell(22,8,$fila['suplementos'],1,0,'C');

    $pdf->Cell(22,8,$fila['creatinas'],1,0,'C');

    $pdf->Cell(22,8,$fila['bebidas'],1,0,'C');

    $pdf->Cell(22,8,$fila['snacks'],1,0,'C');

    $pdf->Cell(25,8,$fila['accesorios'],1,0,'C');

    $pdf->Cell(28,8,$fila['equipamiento'],1,0,'C');

    $pdf->Cell(
        35,
        8,
        "S/ ".number_format($totalDia,2),
        1,
        1,
        'C'
    );

}
$pdf->Output(
    'I',
    'Resumen_Diario_SOFTFIT.pdf'
);