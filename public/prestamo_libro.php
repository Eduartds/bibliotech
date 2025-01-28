<?php
require_once '../config/Database.php';
require_once '../classes/Biblioteca.php';
try {
    // Conexión a la base de datos
    $pdo = Database::getConnection();

    // Instanciar la clase Biblioteca
    $biblioteca = new Biblioteca($pdo);

    // Obtener la lista de libros disponibles
    $librosDisponibles = $biblioteca->obtenerLibrosDisponibles();

    // Verificar si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $libroId = $_POST['libro_id'];
        $fechaPrestamo = $_POST['fecha_prestamo'];
        $fechaDevolucion = $_POST['fecha_devolucion'];

        // Registrar el préstamo
        $biblioteca->registrarPrestamo($libroId, $fechaPrestamo, $fechaDevolucion);

        // Cambiar el estado del libro a prestado
        $biblioteca->actualizarEstadoLibro($libroId, 'prestado');

        // Redirigir a la página de inicio después de registrar el préstamo
        header("Location: index.php");
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
    <title>Registrar Préstamo de Libro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Establecer la fecha de préstamo automáticamente a la fecha actual
        window.onload = function() {
            var currentDate = new Date().toISOString().split('T')[0];
            document.getElementById('fecha_prestamo').value = currentDate;

            // Asegurarse de que la fecha de devolución no pueda ser anterior a la fecha actual
            document.getElementById('fecha_devolucion').setAttribute('min', currentDate);
        };
    </script>
</head>
<body class="bg-light">
<?php include 'nav_bar.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4">Registrar Préstamo de Libro</h1>

        <!-- Formulario para registrar préstamo -->
        <form action="prestamo_libro.php" method="POST" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="libro_id" class="form-label">Seleccionar Libro:</label>
                <small class="text-success">Se muestran solo los libros disponibles</small>
                <select class="form-select" name="libro_id" id="libro_id" required>
                    <?php foreach ($librosDisponibles as $libro): ?>
                        <option value="<?php echo $libro['id']; ?>"><?php echo $libro['titulo']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_prestamo" class="form-label">Fecha de Préstamo:</label>
                <small class="text-warning">El sistema asigna automáticamente la fecha actual como fecha de préstamo.</small>
                <input type="date" class="form-control" name="fecha_prestamo" id="fecha_prestamo" required readonly>
            </div>

            <div class="mb-4">
                <label for="fecha_devolucion" class="form-label">Fecha de Devolución:</label>
                <input type="date" class="form-control" name="fecha_devolucion" id="fecha_devolucion" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Registrar Préstamo</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
