<?php
include 'db.php';

$query = "SELECT MONTH(fecha) AS mes, SUM(total) AS total FROM ventas GROUP BY mes";
$result = $conn->query($query);

$meses = [];
$totales = [];

while ($row = $result->fetch_assoc()) {
    $meses[] = DateTime::createFromFormat('!m', $row['mes'])->format('F');
    $totales[] = (float)$row['total'];
}

echo json_encode(['meses' => $meses, 'totales' => $totales]);
?>
