<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Usuario | JSR RIDER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Bienvenido, <?= $_SESSION['nombre'] ?></h1>
        <p class="text-center">Aquí puedes ver los productos de la tienda.</p>
        <a href="index.php" class="btn btn-warning">Ir a la tienda</a>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>
</body>
</html>
