<?php
require_once '../config/Database.php';
require_once '../classes/Biblioteca.php';

try {
    // Conexión a la base de datos
    $pdo = Database::getConnection();

    // Instanciar la clase Biblioteca
    $biblioteca = new Biblioteca($pdo);

    // Obtener autores y categorías para el formulario
    $autores = $biblioteca->obtenerTodosAutores();
    $categorias = $biblioteca->obtenerTodasCategorias();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = $_POST['titulo'];
        $autorId = $_POST['autor_id'];
        $categoriaId = $_POST['categoria_id'];
        $estado = $_POST['estado'];

        // Validación básica de los campos
        if (empty($titulo) || empty($autorId) || empty($categoriaId)) {
            $error = "Todos los campos son requeridos.";
        } else {
            // Agregar libro a la base de datos
            $libroId = $biblioteca->agregarLibro($titulo, $autorId, $categoriaId, $estado);
            $success = "Libro agregado con éxito. ID: $libroId";

            // Redirigir a la página principal después de agregar el libro
            header("Location: index.php");
            exit(); // Asegura que el script no continúe después de la redirecció<n></n>
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
    <title>Agregar Libro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<?php include 'nav_bar.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Libro</h1>

        <!-- Mensajes de estado -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger mb-4"><?php echo $error; ?></div>
        <?php elseif (isset($success)): ?>
            <div class="alert alert-success mb-4"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Formulario -->
        <form action="agregar_libro.php" method="POST" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>

            <div class="mb-3">
                <label for="autor_id" class="form-label">Autor:</label>
                <select class="form-select" id="autor_id" name="autor_id" required>
                    <option value="">Seleccionar autor</option>
                    <?php foreach ($autores as $a): ?>
                        <option value="<?php echo $a['id']; ?>"><?php echo htmlspecialchars($a['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="categoria_id" class="form-label">Categoría:</label>
                <select class="form-select" id="categoria_id" name="categoria_id" required>
                    <option value="">Seleccionar categoría</option>
                    <?php foreach ($categorias as $c): ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="estado" class="form-label">Estado:</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="disponible">Disponible</option>
                    <option value="prestado">Prestado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Agregar Libro</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>