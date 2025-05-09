<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda de Accesorios JSR RIDER</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        h2 {
            margin: 0;
        }

        .contenedor {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 20px auto;
            max-width: 1200px;
        }

        .producto {
            display: inline-block;
            width: 250px;
            margin: 15px;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .producto:hover {
            transform: scale(1.05);
        }

        .producto img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .producto h3 {
            margin: 10px 0;
            font-size: 18px;
        }

        .producto p {
            margin: 5px 0;
            font-size: 16px;
        }

        .boton-comprar {
            background-color: #007bff;
            color: white;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .boton-comprar:hover {
            background-color: #0056b3;
        }

        .volver-inicio {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .volver-inicio:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<header>
    <h2>Tienda de Accesorios JSR RIDER</h2>
</header>

<div class="contenedor">
    <?php
    // Consulta para obtener los productos de la base de datos
    $result = $conn->query("SELECT * FROM productos");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="producto">';
            echo '<img src="' . $row['imagen'] . '" alt="' . $row['nombre'] . '">';
            echo '<h3>' . $row['nombre'] . '</h3>';
            echo '<p>Precio: $' . number_format($row['precio'], 2) . '</p>';
            echo '<p>Stock: ' . $row['stock'] . '</p>';
            echo '<form action="carrito.php" method="POST">';
            echo '<input type="hidden" name="producto_id" value="' . $row['id'] . '">';
            echo '<button type="submit" class="boton-comprar">Agregar al Carrito</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "<p style='text-align: center;'>No hay productos disponibles.</p>";
    }
    ?>
</div>

<div style="text-align: center;">
    <a href="index.php" class="volver-inicio">Volver al Inicio</a>
</div>

</body>
</html>
