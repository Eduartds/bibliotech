<?php
class Autor
{
    private $pdo;

    public function __construct($dbConnection)
    {
        $this->pdo = $dbConnection;
    }

    public function agregarAutor($nombre)
    {
        try {
            $sql = "INSERT INTO autores (nombre) VALUES (:nombre)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Error al agregar autor: " . $e->getMessage());
        }
    }

    public function editarAutor($id, $nombre)
    {
        try {
            $sql = "UPDATE autores SET nombre = :nombre WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al editar autor: " . $e->getMessage());
        }
    }

    public function eliminarAutor($id)
    {
        try {
            $sql = "DELETE FROM autores WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar autor: " . $e->getMessage());
        }
    }

    // Obtener todos los autores
    public function obtenerTodos()
    {
        try {
            $sql = "SELECT * FROM autores";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener autores: " . $e->getMessage());
        }
    }

    // Obtener autor por ID
    public function obtenerPorId($id)
    {
        try {
            $sql = "SELECT * FROM autores WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener autor: " . $e->getMessage());
        }
    }
}
