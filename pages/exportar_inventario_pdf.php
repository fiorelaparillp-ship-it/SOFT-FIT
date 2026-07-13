<?php
/** @var mysqli $conexion */
include("../includes/conexion.php");

require('../fpdf/fpdf.php');
class PDF extends FPDF
{
    function Footer()
    {
        // Posición a 15 mm del final
        $this->SetY(-15);
        $this->SetDrawColor(
88,
28,
135
);

$this->Line(
10,
$this->GetY(),
287,
$this->GetY()
);

        // Fuente
        $this->SetFont('Arial','I',8);

        // Color gris
        $this->SetTextColor(120,120,120);

        // Pie de página
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
$buscar =
$_GET['buscar'] ?? '';

$categoria =
$_GET['categoria'] ?? '';
$estado =
$_GET['estado'] ?? '';
$nombreCategoria = 'Todas';

if($categoria != ''){

    $cat = mysqli_fetch_assoc(
    mysqli_query(
    $conexion,
    "
    SELECT nombre
    FROM categorias
    WHERE id='$categoria'
    "
    )
    );

    $nombreCategoria = $cat['nombre'];

}
$estadoTexto = 'Todos';

if($estado == 'normal'){

    $estadoTexto = 'Normal';

}

if($estado == 'critico'){

    $estadoTexto = 'Critico';

}

if($estado == 'agotado'){

    $estadoTexto = 'Agotado';

}

$estado =
$_GET['estado'] ?? '';

$where = "WHERE 1=1";

if($buscar != ''){

    $where .= "
    AND productos.nombre
    LIKE '%$buscar%'
    ";

}

if($categoria != ''){

    $where .= "
    AND categorias.id = '$categoria'
    ";

}

if($estado == 'critico'){

    $where .= "
    AND productos.stock <= 5
    AND productos.stock > 0
    ";

}

if($estado == 'agotado'){

    $where .= "
    AND productos.stock = 0
    ";

}

if($estado == 'normal'){

    $where .= "
    AND productos.stock > 5
    ";

}

$sql = mysqli_query(
$conexion,
"
SELECT
productos.*,
categorias.nombre AS categoria
FROM productos
LEFT JOIN categorias
ON productos.categoria_id = categorias.id
$where
ORDER BY productos.nombre ASC
"
);

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
// Franja morada
$pdf->SetFillColor(
108,
52,
131
);

$pdf->Rect(
0,
0,
297,
25,
'F'
);

// Logo
$pdf->Image(
'../img/logo1.png',
10,
1,
40
);
// Texto blanco
$pdf->SetTextColor(
255,
255,
255
);

$pdf->SetFont(
'Arial',
'B',
18
);

$pdf->Cell(
0,
10,
'SOFT-FIT',
0,
1,
'C'
);

$pdf->SetFont(
'Arial',
'',
11
);

$pdf->Cell(
0,
0,
utf8_decode('Reporte de Inventario'),
0,
1,
'C'
);


// Volver a negro
$pdf->SetTextColor(
0,
0,
0
);

$pdf->Ln(15);
$pdf->SetFont(
'Arial',
'',
10
);

$pdf->Cell(0,6,'Fecha de emision: '.date('d/m/Y H:i'),0,1,'L');

$pdf->Ln(2);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(0,6,'Filtros aplicados:',0,1,'L');

$pdf->SetFont('Arial','',10);

$pdf->Cell(0,6,'Busqueda: '.($buscar != '' ? $buscar : 'Todas'),0,1,'L');

$pdf->Cell(0,6,'Categoria: '.$nombreCategoria,0,1,'L');

$pdf->Cell(0,6,'Estado: '.$estadoTexto,0,1,'L');

$pdf->SetTextColor(
0,
0,
0
);
$pdf->Ln(5);





$pdf->Ln(3);

$pdf->SetFillColor(88,28,135);
$pdf->SetTextColor(255,255,255);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(60,10,'Producto',1,0,'C',true);
$pdf->Cell(45,10,'Categoria',1,0,'C',true);
$pdf->Cell(25,10,'Stock',1,0,'C',true);
$pdf->Cell(35,10,'Precio',1,0,'C',true);
$pdf->Cell(35,10,'Valor Total',1,1,'C',true);

$pdf->SetTextColor(0,0,0);

$totalProductos = 0;
$totalInventario = 0;

$pdf->SetFont('Arial','',10);

while($fila = mysqli_fetch_assoc($sql)){

    $valor =
    $fila['stock'] *
    $fila['precio'];
    $totalProductos++;

$totalInventario += $valor;

    $pdf->Cell(
    60,
    8,
    utf8_decode($fila['nombre']),
    1
    );

    $pdf->Cell(
    45,
    8,
    utf8_decode($fila['categoria']),
    1
    );

   $pdf->Cell(
25,
8,
$fila['stock'],
1,
0,
'C'
);

   $pdf->Cell(
35,
8,
'S/ '.number_format(
$fila['precio'],
2
),
1,
0,
'C'
);

    $pdf->Cell(
35,
8,
'S/. '.number_format(
$valor,
2
),
1,
0,
'C'
);

    $pdf->Ln();

}
$pdf->Ln(10);

$pdf->SetFillColor(240,240,240);

$pdf->SetFont(
'Arial',
'B',
11
);

$pdf->Cell(
60,
8,
'Productos exportados:',
1,
0,
'L',
true
);

$pdf->Cell(
40,
8,
$totalProductos,
1,
1,
'C'
);

$pdf->Cell(
60,
8,
'Valor total inventario:',
1,
0,
'L',
true
);

$pdf->Cell(
40,
8,
'S/ '.number_format(
$totalInventario,
2
),
1,
1,
'C'
);

$pdf->Output(
'I',
'Inventario_SOFTFIT.pdf'
);