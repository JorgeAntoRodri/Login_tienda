<?php
session_start();

// Verificar si el usuario ha iniciado sesión y tiene el rol de administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    // Si no tiene el rol de administrador, redirigir a la página de login
    header("Location: login.php");
    exit();
}

include 'db.php';

// Consultar los usuarios desde la base de datos
$stmt = $conn->prepare("SELECT * FROM usuarios");
$stmt->execute();
$usuarios = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuarios | JSR RIDER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Usuarios</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                    <tr>
                        <td><?= $usuario['nombre'] ?></td>
                        <td><?= $usuario['correo'] ?></td>
                        <td><?= ucfirst($usuario['rol']) ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $usuario['id'] ?>" class="btn btn-primary">Editar</a>
                            <!-- Puedes agregar una opción de eliminar si lo deseas -->
                            <!-- <a href="delete_user.php?id=<?= $usuario['id'] ?>" class="btn btn-danger">Eliminar</a> -->
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="index.php" class="btn btn-secondary">Volver al inicio</a>
    </div>
</body>
</html>
