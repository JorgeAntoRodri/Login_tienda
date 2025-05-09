<?php
session_start();
include 'db.php';
require 'phpqrcode/qrlib.php'; // Asegúrate de tener esta biblioteca instalada

$usuario_logueado = isset($_SESSION['usuario']);
$es_admin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | JSR RIDER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #343a40; }
        .navbar-brand, .nav-link { color: white !important; }
        .banner {
            background-image: url('images/banner_moto.jpg');
            background-size: cover;
            background-position: center;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            text-shadow: 2px 2px 5px black;
        }
        .container { margin-top: 20px; }
        .qr-img { max-width: 100px; margin-top: 10px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">JSR RIDER</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="tienda.php">Tienda</a>
                </li>
                <?php if ($usuario_logueado): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="banner">Bienvenido a JSR RIDER</div>

<div class="container">
    <h2 class="text-center mt-4">Explora nuestros productos</h2>
    <p class="text-center">Encuentra los mejores cascos y accesorios para tu motocicleta.</p>

    <div class="text-center mt-4">
        <a href="tienda.php" class="btn btn-success">Ir a la Tienda</a>
        <?php if ($es_admin): ?>
            <a href="agregar_producto.php" class="btn btn-primary">Agregar Producto</a>
            <a href="admin_usuarios.php" class="btn btn-warning">Administrar Usuarios</a>
            <a href="grafica_ventas.php" class="btn btn-primary">Ver Gráficas de Ventas</a>
        <?php endif; ?>
    </div>

    <div class="row mt-5">
        <?php
        $stmt = $conn->prepare("SELECT * FROM productos ORDER BY RAND() LIMIT 3");
        $stmt->execute();
        $productos = $stmt->get_result();

        while ($producto = $productos->fetch_assoc()):
            $qr_dir = 'temp_qr/';
            if (!file_exists($qr_dir)) mkdir($qr_dir);
            $qr_filename = $qr_dir . 'qr_' . $producto['id'] . '.png';

            $qr_contenido = "Producto: {$producto['nombre']}\nPrecio: \${$producto['precio']}\nDescripcion: {$producto['descripcion']}";
            QRcode::png($qr_contenido, $qr_filename, QR_ECLEVEL_L, 3);
        ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="images/<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                        <p class="card-text"><?= $producto['descripcion'] ?></p>
                        <p class="card-text"><strong>Precio:</strong> $<?= $producto['precio'] ?></p>
                        <a href="producto.php?id=<?= $producto['id'] ?>" class="btn btn-primary">Ver detalles</a>
                        <img src="<?= $qr_filename ?>" class="qr-img" alt="QR <?= $producto['nombre'] ?>">
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
