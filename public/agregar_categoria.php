<?php
require_once '../config/Database.php';
require_once '../classes/Biblioteca.php';

try {
    // Conexión a la base de datos
    $pdo = Database::getConnection();

    // Instanciar la clase Biblioteca
    $biblioteca = new Biblioteca($pdo);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];

        // Validación básica del campo
        if (empty($nombre)) {
            $error = "El nombre de la categoría es requerido.";
        } else {
            // Agregar categoría a la base de datos
            $categoriaId = $biblioteca->agregarCategoria($nombre);
            $success = "Categoría agregada con éxito. ID: $categoriaId";

            // Redirigir a la página de categorías después de agregar la categoría
            header("Location: categorias.php");
            exit();
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
    <title>Agregar Categoría</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'nav_bar.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Categoría</h1>

        <!-- Mensajes de estado -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger mb-4"><?php echo $error; ?></div>
        <?php elseif (isset($success)): ?>
            <div class="alert alert-success mb-4"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Formulario -->
        <form action="agregar_categoria.php" method="POST" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Categoría:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Agregar Categoría</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>