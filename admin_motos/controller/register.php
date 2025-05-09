<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $rol = $_POST['rol'];

    // Insertar nuevo usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, contrasena, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $contrasena, $rol);

    if ($stmt->execute()) {
        header("Location: login.php");
    } else {
        $error = "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | JSR RIDER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1b1b1b;
            color: white;
        }
        .container {
            margin-top: 100px;
            max-width: 400px;
            background: #2b2b2b;
            padding: 20px;
            border-radius: 10px;
        }
        .btn-primary {
            background: #ff4500;
            border: none;
        }
        .btn-primary:hover {
            background: #ff652f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Registro de Usuario</h2>
        <form method="POST">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="contrasena" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo de cuenta</label>
                <select name="rol" class="form-control" required>
                    <option value="usuario">Usuario</option>
                    <option value="administrador">Administrador</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
        </form>

        <div class="mt-3">
            <a href="login.php" class="btn btn-secondary w-100">Volver a Login</a>
        </div>
    </div>
</body>
</html>
