<?php
session_start();
include 'db.php';

// Verifica si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Obtener todos los usuarios de la base de datos
$stmt = $conn->prepare("SELECT * FROM usuarios ORDER BY rol DESC");
$stmt->execute();
$usuarios = $stmt->get_result();

// Eliminar usuario si se recibe una solicitud de eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin_usuarios.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios | JSR RIDER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Administrar Usuarios</h1>

        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                    <tr>
                        <td><?= $usuario['id'] ?></td>
                        <td><?= $usuario['nombre'] ?></td>
                        <td><?= $usuario['email'] ?></td>
                        <td><?= ucfirst($usuario['rol']) ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="admin_usuarios.php?eliminar=<?= $usuario['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="index.php" class="btn btn-secondary">Volver al inicio</a>
    </div>
</body>
</html>
