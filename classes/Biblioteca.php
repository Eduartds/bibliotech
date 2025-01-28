<?php
require_once 'Libro.php';
require_once 'Autor.php';
require_once 'Categoria.php';
require_once 'Prestamo.php';

class Biblioteca {
    private $libro;
    private $autor;
    private $categoria;
    private $prestamo;
    private $pdo;

    public function __construct($pdo) {
        $this->libro = new Libro($pdo);
        $this->autor = new Autor($pdo);
        $this->categoria = new Categoria($pdo);
        $this->prestamo = new Prestamo($pdo);
        $this->pdo = $pdo;
    }

    /********************** MÉTODOS PARA LIBRO  **********************/

    // Método para agregar un libro
    public function agregarLibro($titulo, $autor_id, $categoria_id) {
        return $this->libro->agregar($titulo, $autor_id, $categoria_id);
    }

    // Método para editar un libro
    public function editarLibro($id, $titulo, $autor_id, $categoria_id, $estado) {
        return $this->libro->editar($id, $titulo, $autor_id, $categoria_id, $estado);
    }

    // Método para eliminar un libro
    public function eliminarLibro($id) {
        return $this->libro->eliminar($id);
    }

    // Método para obtener libros disponibles
    public function obtenerTodosLibros() {
        return $this->libro->obtenerTodos();
    }

    // Método para obtener un libro por ID
    public function obtenerLibroPorId($id) {
        return $this->libro->obtenerPorId($id);
    }

    // Método para actualizar el estado de un libro
    public function actualizarEstadoLibro($id, $estado) {
        return $this->libro->actualizarEstado($id, $estado);
    }

    // Método para obtener solo los libros disponibles
    public function obtenerLibrosDisponibles() {
        return $this->libro->obtenerDisponibles();
    }
    // Método para registrar un préstamo
    public function registrarPrestamo($libro_id, $fecha_prestamo, $fecha_devolucion) {
        return $this->prestamo->registrarPrestamo($libro_id, $fecha_prestamo, $fecha_devolucion);
    }

    // Método para buscar libros (solo manda a llamar el de Libro)
    public function buscarLibros($titulo = null, $autor = null, $categoria = null) {
        return $this->libro->buscarLibros($titulo, $autor, $categoria);
    }

    /********************** MÉTODOS PARA AUTOR  **********************/

    // Método para agregar un autor
    public function agregarAutor($nombre) {
        return $this->autor->agregarAutor($nombre);
    }

    // Método para editar un autor
    public function editarAutor($id, $nombre) {
        return $this->autor->editarAutor($id, $nombre);
    }

    // Método para eliminar un autor
    public function eliminarAutor($id) {
        return $this->autor->eliminarAutor($id);
    }
    // Método para obtener todos los autores
    public function obtenerTodosAutores() {
        return $this->autor->obtenerTodos();
    }

    // Método para obtener un autor por ID
    public function obtenerAutorPorId($id) {
        return $this->autor->obtenerPorId($id);
    }

    /********************** MÉTODOS PARA CATEGORÍA  **********************/

    // Método para agregar una categoría
    public function agregarCategoria($nombre) {
        return $this->categoria->agregarCategoria($nombre);
    }

    // Método para editar una categoría
    public function editarCategoria($id, $nombre) {
        return $this->categoria->editarCategoria($id, $nombre);
    }

    // Método para eliminar una categoría
    public function eliminarCategoria($id) {
        return $this->categoria->eliminarCategoria($id);
    }

    // Método para obtener todas las categorías
    public function obtenerTodasCategorias() {
        return $this->categoria->obtenerTodos();
    }

    // Método para obtener una categoría por ID
    public function obtenerCategoriaPorId($id) {
        return $this->categoria->obtenerPorId($id);
    }
}

?>
