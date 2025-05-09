<?php
require 'phpqrcode/qrlib.php'; // Asegúrate de que la ruta sea correcta

// Recibir parámetros del producto
$nombre = $_GET['nombre'] ?? '';
$marca = $_GET['marca'] ?? '';
$precio = $_GET['precio'] ?? '';
$car1 = $_GET['car1'] ?? '';
$car2 = $_GET['car2'] ?? '';
$car3 = $_GET['car3'] ?? '';

// Texto del QR
$contenido = "Producto: $nombre\nMarca: $marca\nPrecio: $precio\nCaracteristicas:\n- $car1\n- $car2\n- $car3";

// Generar QR directamente al navegador
QRcode::png($contenido);
?>
