<?php
require_once '../config/Database.php';
require_once '../classes/Biblioteca.php';

try {
    // Conexión a la base de datos
    $pdo = Database::getConnection();

    // Instanciar la clase Biblioteca
    $biblioteca = new Biblioteca($pdo);

    // Verificar si se pasó un ID de autor en la URL
    if (isset($_GET['id'])) {
        $autorId = $_GET['id'];

        // Obtener el autor con el ID proporcionado
        $autorData = $biblioteca->obtenerAutorPorId($autorId);

        // Si el autor no existe, redirigir al inicio
        if (!$autorData) {
            header("Location: index_autores.php");
            exit();
        }

        // Si el formulario es enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];

            // Validación básica del campo
            if (empty($nombre)) {
                $error = "El nombre del autor es requerido.";
            } else {
                // Actualizar autor
                $biblioteca->editarAutor($autorId, $nombre);
                $success = "Autor actualizado con éxito.";

                // Redirigir a la página de autores después de actualizar
                header("Location: autores.php");
                exit();
            }
        }
    } else {
        // Si no se pasa un ID, redirigir al inicio
        header("Location: autores.php");
        exit();
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
    <title>Editar Autor</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include 'nav_bar.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Autor</h1>

        <!-- Mensajes de estado -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger mb-4"><?php echo $error; ?></div>
        <?php elseif (isset($success)): ?>
            <div class="alert alert-success mb-4"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Formulario para editar autor -->
        <form action="editar_autor.php?id=<?php echo $autorId; ?>" method="POST" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Autor:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($autorData['nombre']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Guardar Cambios</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
