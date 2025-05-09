<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador | JSR RIDER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1b1b1b;
            color: white;
        }
        .container {
            margin-top: 50px;
        }
        a {
            color: white;
            text-decoration: none;
        }
        a:hover {
            color: #ff652f;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Bienvenido Administrador, <?= $_SESSION['nombre'] ?></h1>
        <p class="text-center">Desde aquí puedes gestionar los usuarios, productos y ver estadísticas de ventas.</p>
        <div class="d-flex justify-content-center gap-3 mb-3">
            <a href="index.php" class="btn btn-warning">Ir a la tienda</a>
            <a href="grafica_ventas.php" class="btn btn-primary">Ver Gráficas de Ventas</a>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
        <div class="list-group">
            <a href="add_product.php" class="list-group-item bg-dark">Agregar Producto</a>
            <a href="edit_user.php" class="list-group-item bg-dark">Editar Usuario</a>
        </div>
    </div>
</body>
</html>
