<?php
require_once '../config/Database.php';
require_once '../classes/Biblioteca.php';

try {
    // Conexión a la base de datos
    $pdo = Database::getConnection();

    // Instanciar la clase Biblioteca
    $biblioteca = new Biblioteca($pdo);

    // Verificar si se pasa un ID de libro en la URL
    if (isset($_GET['id'])) {
        $categoriaId = $_GET['id'];

        // Eliminar libro de la base de datos
        $biblioteca->eliminarCategoria($categoriaId);

        // Redirigir a la página principal después de eliminar
        header("Location: categorias.php");
        exit();
    } else {
        // Si no se pasa un ID, redirigir a la página principal
        header("Location: categorias.php");
        exit();
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}