<?php
session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'db.php';

// Obtener el correo del usuario desde la base de datos
$user_id = $_SESSION['user_id'];
$query = "SELECT correo FROM usuarios WHERE id = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();
$correo = $user['correo'];

// Crear el PDF del ticket
require 'fpdf/fpdf.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Ticket de Compra - JSR RIDER', 0, 1, 'C');
        $this->Ln(10);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Gracias por su compra!', 0, 1);

$total = 0;

foreach ($_SESSION['carrito'] as $producto) {
    $subtotal = $producto['precio'] * $producto['cantidad'];
    $pdf->Cell(0, 10, $producto['nombre'] . " x" . $producto['cantidad'] . " - $" . number_format($subtotal, 2), 0, 1);
    $total += $subtotal;
}

$pdf->Ln(10);
$pdf->Cell(0, 10, 'Total: $' . number_format($total, 2), 0, 1);

// Guardar el PDF en el servidor
$pdf->Output('F', 'ticket.pdf');

// Enviar el correo con PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP de Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'pajaroferrari@gmail.com';  // Cambia por tu correo
    $mail->Password = 'pwxikiyixmftqext';        // Cambia por tu contraseña
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Configuración del correo
    $mail->setFrom('tu_correo@gmail.com', 'JSR RIDER');
    $mail->addAddress($correo);
    $mail->Subject = 'Ticket de Compra - JSR RIDER';
    $mail->Body = 'Gracias por tu compra en JSR RIDER. Te adjuntamos tu ticket en PDF.';
    $mail->addAttachment('ticket.pdf');

    // Enviar el correo
    $mail->send();
    echo "Ticket enviado correctamente al correo: $correo";
} catch (Exception $e) {
    echo "Error al enviar el ticket: " . $mail->ErrorInfo;
}
?>
