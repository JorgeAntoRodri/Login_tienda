<?php
include 'db.php';
session_start();

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];

    // Consultar el producto desde la base de datos
    $result = $conn->query("SELECT * FROM productos WHERE id = $producto_id");
    $producto = $result->fetch_assoc();

    if ($producto) {
        // Verificar si el producto ya está en el carrito
        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]['cantidad'] += 1;
        } else {
            $_SESSION['carrito'][$producto_id] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => 1,
                'imagen' => $producto['imagen'],
            ];
        }
    }
}

// Actualizar cantidad del producto en el carrito
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_SESSION['carrito'][$id])) {
        if ($_GET['action'] == 'add') {
            $_SESSION['carrito'][$id]['cantidad'] += 1;
        } elseif ($_GET['action'] == 'remove' && $_SESSION['carrito'][$id]['cantidad'] > 1) {
            $_SESSION['carrito'][$id]['cantidad'] -= 1;
        }
    }
    header("Location: carrito.php");
    exit();
}

// Eliminar producto del carrito
if (isset($_GET['eliminar'])) {
    $producto_id = $_GET['eliminar'];
    unset($_SESSION['carrito'][$producto_id]);
    header("Location: carrito.php");
    exit();
}

// Vaciar el carrito
if (isset($_GET['vaciar'])) {
    $_SESSION['carrito'] = [];
    header("Location: carrito.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        img {
            width: 50px;
            height: auto;
        }

        .total {
            font-weight: bold;
        }

        .boton {
            padding: 8px 12px;
            margin: 5px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .boton:hover {
            background-color: #0056b3;
        }

        .vaciar-carrito {
            background-color: red;
        }

        .vaciar-carrito:hover {
            background-color: darkred;
        }

        .incrementar, .decrementar {
            padding: 5px 8px;
            margin: 2px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .decrementar {
            background-color: #dc3545;
        }

        .incrementar:hover, .decrementar:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Carrito de Compras</h2>

<?php if (!empty($_SESSION['carrito'])): ?>
    <table>
        <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Acción</th>
        </tr>
        <?php $total = 0; ?>
        <?php foreach ($_SESSION['carrito'] as $id => $producto): ?>
            <?php $subtotal = $producto['precio'] * $producto['cantidad']; ?>
            <tr>
                <td><img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>"></td>
                <td><?php echo $producto['nombre']; ?></td>
                <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                <td>
                    <a href="carrito.php?action=remove&id=<?php echo $id; ?>" class="decrementar">-</a>
                    <?php echo $producto['cantidad']; ?>
                    <a href="carrito.php?action=add&id=<?php echo $id; ?>" class="incrementar">+</a>
                </td>
                <td>$<?php echo number_format($subtotal, 2); ?></td>
                <td>
                    <a href="carrito.php?eliminar=<?php echo $id; ?>" class="boton">Eliminar</a>
                </td>
            </tr>
            <?php $total += $subtotal; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" class="total">Total:</td>
            <td colspan="2" class="total">$<?php echo number_format($total, 2); ?></td>
        </tr>
    </table>

    <div style="text-align: center;">
        <a href="carrito.php?vaciar=true" class="boton vaciar-carrito">Vaciar Carrito</a>
        <a href="index.php" class="boton">Volver a la Tienda</a>
        <a href="generar_baucher.php" class="boton">Generar PDF</a>
        <a href="enviar_ticket.php" class="boton">Enviar Ticket al Correo</a>
    </div>

<?php else: ?>
    <p style="text-align: center;">El carrito está vacío.</p>
    <div style="text-align: center;">
        <a href="index.php" class="boton">Volver a la Tienda</a>
    </div>
<?php endif; ?>

</body>
</html>
