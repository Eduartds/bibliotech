<?php
require_once '../config/Database.php';
require_once '../classes/Biblioteca.php';

try {
    // Conexión a la base de datos
    $pdo = Database::getConnection();

    // Instanciar la clase Biblioteca
    $biblioteca = new Biblioteca($pdo);

    $titulo = isset($_GET['titulo']) ? $_GET['titulo'] : null;
    $autor = isset($_GET['autor']) ? $_GET['autor'] : null;
    $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;

    $libros = $biblioteca->buscarLibros($titulo, $autor, $categoria);

    // Obtener todos los libros
    // $libros = $biblioteca->obtenerTodosLibros();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Biblioteca</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'nav_bar.php'; ?>
    <div class="container mt-4">

        <a href="agregar_libro.php" class="btn btn-primary mb-4">Agregar Libro</a>

        <h2 class="mb-3">Listado de Libros</h2>
        <form action="index.php" method="GET">
            <div class="row mb-3">
                <div class="col">
                    <input type="text" name="titulo" class="form-control" placeholder="Buscar por título" value="<?php echo isset($_GET['titulo']) ? $_GET['titulo'] : ''; ?>">
                </div>
                <div class="col">
                    <input type="text" name="autor" class="form-control" placeholder="Buscar por autor" value="<?php echo isset($_GET['autor']) ? $_GET['autor'] : ''; ?>">
                </div>
                <div class="col">
                    <input type="text" name="categoria" class="form-control" placeholder="Buscar por categoría" value="<?php echo isset($_GET['categoria']) ? $_GET['categoria'] : ''; ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Ver todos</button>
                </div>
            </div>
        </form>


        <?php if (!empty($libros)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($libros as $libro): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($libro['id']); ?></td>
                                <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                                <td><?php echo htmlspecialchars($libro['categoria']); ?></td>
                                <td><?php echo htmlspecialchars($libro['estado']); ?></td>
                                <td>
                                    <a href="editar_libro.php?id=<?php echo $libro['id']; ?>" class="btn btn-sm btn-warning me-2">Editar</a>
                                    <a href="eliminar_libro.php?id=<?php echo $libro['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este libro?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No hay libros que coincidan con la búsqueda.</div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (opcional, solo si necesitas componentes interactivos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>