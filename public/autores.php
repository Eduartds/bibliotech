<?php
require_once '../config/Database.php';
require_once '../classes/Biblioteca.php';

try {
    // Conexión a la base de datos
    $pdo = Database::getConnection();

    // Instanciar la clase Biblioteca
    $biblioteca = new Biblioteca($pdo);

    $autores = $biblioteca->obtenerTodosAutores();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Autores</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'nav_bar.php'; ?>
    <div class="container mt-4">
        <a href="agregar_autor.php" class="btn btn-primary mb-4">Agregar Autor</a>
        <h2 class="mb-3">Listado de Autores</h2>
        <?php if (!empty($autores)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($autores as $autor): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($autor['id']); ?></td>
                                <td><?php echo htmlspecialchars($autor['nombre']); ?></td>
                                <td>
                                    <a href="editar_autor.php?id=<?php echo $autor['id']; ?>" class="btn btn-sm btn-warning me-2">Editar</a>
                                    <a href="eliminar_autor.php?id=<?php echo $autor['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este autor?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No hay autores que coincidan con la búsqueda.</div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (opcional, solo si necesitas componentes interactivos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
