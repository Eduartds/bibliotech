<?php
class Categoria
{
    private $pdo;

    public function __construct($dbConnection)
    {
        $this->pdo = $dbConnection;
    }

    public function agregarCategoria($nombre)
    {
        try {
            $sql = "INSERT INTO categorias (nombre) VALUES (:nombre)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Error al agregar categoría: " . $e->getMessage());
        }
    }

    public function editarCategoria($id, $nombre)
    {
        try {
            $sql = "UPDATE categorias SET nombre = :nombre WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al editar categoría: " . $e->getMessage());
        }
    }

    public function eliminarCategoria($id)
    {
        try {
            $sql = "DELETE FROM categorias WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar categoría: " . $e->getMessage());
        }
    }

    // Obtener todas las categorías
    public function obtenerTodos()
    {
        try {
            $sql = "SELECT * FROM categorias";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener categorías: " . $e->getMessage());
        }
    }

    // Obtener una categoría por ID
    public function obtenerPorId($id)
    {
        try {
            $sql = "SELECT * FROM categorias WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener categoría: " . $e->getMessage());
        }
    }
}
