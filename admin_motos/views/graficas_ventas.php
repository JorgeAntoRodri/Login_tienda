<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}
include 'db.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gráfica de Ventas | JSR RIDER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #1b1b1b;
            color: white;
        }
        .container {
            margin-top: 50px;
            text-align: center;
        }
        canvas {
            background-color: white;
        }
        .btn {
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Gráfica de Ventas Mensuales</h2>
        <div style="width: 70%; margin: auto; padding: 20px;">
            <canvas id="ventasChart"></canvas>
        </div>
        <a href="admin_dashboard.php" class="btn btn-warning">Regresar al Dashboard</a>
    </div>

    <script>
        async function cargarDatos() {
            const response = await fetch('obtener_datos_ventas.php');
            const data = await response.json();

            const ctx = document.getElementById('ventasChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.meses,
                    datasets: [{
                        label: 'Ventas Mensuales',
                        data: data.totales,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        cargarDatos();
    </script>
</body>
</html>
