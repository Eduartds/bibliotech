<?php
require_once '../config/Database.php';
require_once '../classes/Biblioteca.php';

try {
    $pdo = Database::getConnection();
    $biblioteca = new Biblioteca($pdo);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];

        if (!empty($nombre)) {
            $biblioteca->agregarAutor($nombre);
            header('Location: autores.php'); // Redirigir a la lista de autores
            exit();
        } else {
            $error = "El nombre del autor es obligatorio.";
        }
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Autor</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'nav_bar.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Autor</h1>

        <!-- Mensajes de estado -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger mb-4"><?php echo $error; ?></div>
        <?php elseif (isset($success)): ?>
            <div class="alert alert-success mb-4"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Formulario -->
        <form action="agregar_autor.php" method="POST" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Autor:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Agregar Autor</button>
        </form>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>