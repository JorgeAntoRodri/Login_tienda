<?php
session_start();

// Verificar si el usuario ha iniciado sesión y tiene el rol de administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    // Si no tiene el rol de administrador, redirigir a la página de login
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del usuario a editar
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $usuario = $stmt->get_result()->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Actualizar los datos del usuario
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $rol = $_POST['rol'];

        $updateStmt = $conn->prepare("UPDATE usuarios SET nombre = ?, correo = ?, rol = ? WHERE id = ?");
        $updateStmt->bind_param("sssi", $nombre, $correo, $rol, $id);

        if ($updateStmt->execute()) {
            header("Location: edit_users.php");
        } else {
            $error = "Error al actualizar el usuario.";
        }
    }
} else {
    header("Location: edit_users.php");
    exit();
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
                <label class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control" value="<?= $usuario['correo'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="rol" class="form-control" required>
                    <option value="usuario" <?= $usuario['rol'] === 'usuario' ? 'selected' : '' ?>>Usuario</option>
                    <option value="administrador" <?= $usuario['rol'] === 'administrador' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Actualizar Usuario</button>
        </form>

        <a href="edit_users.php" class="btn btn-secondary mt-3">Volver a la lista de usuarios</a>
    </div>
</body>
</html>
