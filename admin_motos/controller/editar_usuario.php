<?php
session_start();
include 'db.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Obtener el usuario a editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
}

// Actualizar usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];

    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nombre, $email, $rol, $id);

    if ($stmt->execute()) {
        header("Location: admin_usuarios.php");
    } else {
        $error = "Error al actualizar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario | JSR RIDER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Usuario</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= $usuario['nombre'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $usuario['email'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="rol" class="form-control">
                    <option value="usuario" <?= $usuario['rol'] === 'usuario' ? 'selected' : '' ?>>Usuario</option>
                    <option value="administrador" <?= $usuario['rol'] === 'administrador' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
        </form>

        <a href="admin_usuarios.php" class="btn btn-secondary mt-3">Volver</a>
    </div>
</body>
</html>
