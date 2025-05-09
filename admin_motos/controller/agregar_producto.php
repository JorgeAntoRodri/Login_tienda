<?php
include 'db.php';  // Conexión a la base de datos
session_start();

// Verificar si el usuario tiene rol de administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'administrador') {
    echo "Acceso denegado. Solo los administradores pueden agregar productos.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $fecha_registro = date('Y-m-d');  // Fecha actual

    // Verificar si se ha subido una imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombreArchivo = basename($_FILES['imagen']['name']);
        $rutaImagen = 'images/' . $nombreArchivo;

        // Crear la carpeta "images" si no existe
        if (!is_dir('images')) {
            mkdir('images', 0777, true);
        }

        // Mover la imagen a la carpeta "images/"
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            // Insertar el producto en la base de datos con la URL de la imagen
            $stmt = $conn->prepare("INSERT INTO productos (nombre, precio, stock, fecha_registro, imagen) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sdiss", $nombre, $precio, $stock, $fecha_registro, $rutaImagen);

            if ($stmt->execute()) {
                echo "<p style='color: green;'>Producto agregado exitosamente.</p>";
            } else {
                echo "<p style='color: red;'>Error al agregar el producto: " . $stmt->error . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Error al subir la imagen.</p>";
        }
    } else {
        echo "<p style='color: red;'>No se ha seleccionado ninguna imagen.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        form {
            background-color: #fff;
            padding: 20px;
            margin: 50px auto;
            width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 8px;
            margin: 6px 0 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Agregar Nuevo Producto</h2>

<form action="agregar_producto.php" method="POST" enctype="multipart/form-data">
    <label>Nombre del Producto:</label>
    <input type="text" name="nombre" required>

    <label>Precio:</label>
    <input type="number" name="precio" step="0.01" required>

    <label>Stock:</label>
    <input type="number" name="stock" required>

    <label>Imagen del Producto:</label>
    <input type="file" name="imagen" accept="images/*" required>

    <button type="submit">Agregar Producto</button>
</form>

<a href="index.php">Volver al Inicio</a>

</body>
</html>
