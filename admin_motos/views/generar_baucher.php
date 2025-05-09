<?php
include 'db.php';
require 'fpdf/fpdf.php';
session_start();

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "El carrito está vacío.";
    exit;
}

// Actualizar el stock en la base de datos
foreach ($_SESSION['carrito'] as $id => $producto) {
    $cantidad = $producto['cantidad'];
    $conn->query("UPDATE productos SET stock = stock - $cantidad WHERE id = $id");
}

// Guardar la venta en la base de datos
$usuario_id = $_SESSION['user_id']; // ID del usuario logueado
$total = 0;

foreach ($_SESSION['carrito'] as $producto) {
    $subtotal = $producto['precio'] * $producto['cantidad'];
    $total += $subtotal;
}

$stmt = $conn->prepare("INSERT INTO ventas (usuario_id, total) VALUES (?, ?)");
$stmt->bind_param("id", $usuario_id, $total);
$stmt->execute();
$venta_id = $stmt->insert_id;
$stmt->close();

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Baucher de Compra', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Fecha: ' . date('d/m/Y H:i:s'), 0, 1);
$pdf->Cell(0, 10, 'Cliente: ' . (isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Jorge'), 0, 1);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Producto', 1);
$pdf->Cell(30, 10, 'Precio', 1);
$pdf->Cell(30, 10, 'Cantidad', 1);
$pdf->Cell(30, 10, 'Subtotal', 1);
$pdf->Cell(60, 10, 'Imagen', 1);
$pdf->Ln();

foreach ($_SESSION['carrito'] as $producto) {
    $subtotal = $producto['precio'] * $producto['cantidad'];

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 30, $producto['nombre'], 1);
    $pdf->Cell(30, 30, '$' . number_format($producto['precio'], 2), 1);
    $pdf->Cell(30, 30, $producto['cantidad'], 1);
    $pdf->Cell(30, 30, '$' . number_format($subtotal, 2), 1);

    // Imagen del producto
    $imagen = $producto['imagen'];
    if (file_exists($imagen)) {
        $pdf->Cell(60, 30, $pdf->Image($imagen, $pdf->GetX() + 5, $pdf->GetY() + 5, 20), 1);
    } else {
        $pdf->Cell(60, 30, 'No disponible', 1);
    }
    $pdf->Ln();
}

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(100, 10, 'Total de la compra: $' . number_format($total, 2), 0, 1);

$pdf->Output('D', 'baucher_compra.pdf');

// Limpiar el carrito después de la compra
$_SESSION['carrito'] = [];
?>
