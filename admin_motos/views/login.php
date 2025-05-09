<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    // Buscar usuario en la base de datos
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($contrasena, $user['contrasena'])) {
        // Iniciar sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['rol'] = $user['rol'];
        $_SESSION['correo'] = $user['correo'];

        // Redirigir según el rol
        if ($user['rol'] === 'administrador') {
            header("Location: admin_dashboard.php");
            exit();
        } elseif ($user['rol'] === 'usuario') {
            header("Location: user_dashboard.php");
            exit();
        } else {
            $error = "Rol no válido.";
        }
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | JSR RIDER</title>
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
        <h2 class="text-center">Iniciar sesión</h2>
        <form method="POST">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="contrasena" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo de acceso</label>
                <select name="rol" class="form-control" required>
                    <option value="usuario">Usuario</option>
                    <option value="administrador">Administrador</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <div class="mt-3">
            <a href="register.php" class="btn btn-success w-100">Registrarse</a>
        </div>
    </div>
</body>
</html>
