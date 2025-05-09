<?php
include 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM usuarios WHERE id = $id");
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    if (!empty($_POST['contrasena'])) {
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
        $sql = "UPDATE usuarios SET nombre='$nombre', correo='$correo', contrasena='$contrasena' WHERE id=$id";
    } else {
        $sql = "UPDATE usuarios SET nombre='$nombre', correo='$correo' WHERE id=$id";
    }

    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
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
    <style>
        body {
            background-color: #1b1b1b;
            color: white;
        }
        .container {
            margin-top: 50px;
            max-width: 500px;
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
        <h2 class="text-center">Editar Usuario</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= $user['nombre'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control" value="<?= $user['correo'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nueva Contraseña (opcional)</label>
                <input type="password" name="contrasena" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100">Actualizar</button>
        </form>
        <a href="index.php" class="btn btn-secondary w-100 mt-2">Volver</a>
    </div>
</body>
</html>
