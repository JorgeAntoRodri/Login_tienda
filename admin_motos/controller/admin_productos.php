<?php
session_start();
include 'db.php';

// Verifica si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Obtener los productos
$stmt = $conn->prepare("SELECT * FROM productos ORDER BY fecha_registro DESC");
$stmt->execute();
$productos = $stmt->get_result();

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin_productos.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos | Moto Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Administrar Productos</h1>
        <a href="agregar_producto.php" class="btn btn-success mb-3">Agregar Producto</a>

        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Fecha de Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = $productos->fetch_assoc()): ?>
                    <tr>
                        <td><?= $producto['id'] ?></td>
                        <td><img src="images/<?= $producto['imagen'] ?>" width="50" height="50"></td>
                        <td><?= $producto['nombre'] ?></td>
                        <td>$<?= $producto['precio'] ?></td>
                        <td><?= $producto['stock'] ?></td>
                        <td><?= $producto['fecha_registro'] ?></td>
                        <td>
                            <a href="editar_producto.php?id=<?= $producto['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="admin_productos.php?eliminar=<?= $producto['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="index.php" class="btn btn-secondary">Volver al inicio</a>
    </div>
</body>
</html>
