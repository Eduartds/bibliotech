<?php

class Libro {
    private $pdo; // Conexión a la base de datos

    public function __construct($dbConnection) {
        $this->pdo = $dbConnection;
    }

    // Método para agregar un libro
    public function agregar($titulo, $autorId, $categoriaId, $estado = 'disponible') {

        if (empty($titulo) || empty($autorId) || empty($categoriaId)) {
            throw new Exception("Todos los campos son obligatorios.");
        }
        try {
            $sql = "INSERT INTO libros (titulo, autor_id, categoria_id, estado) 
                    VALUES (:titulo, :autor_id, :categoria_id, :estado)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':titulo' => $titulo,
                ':autor_id' => $autorId,
                ':categoria_id' => $categoriaId,
                ':estado' => $estado
            ]);
            return $this->pdo->lastInsertId(); // Retorna el ID del libro agregado
        } catch (PDOException $e) {
            throw new Exception("Error al agregar el libro: " . $e->getMessage());
        }
    }

    // Método para editar un libro
    public function editar($id, $titulo, $autorId, $categoriaId, $estado) {
        try {
            $sql = "UPDATE libros SET titulo = :titulo, autor_id = :autor_id, categoria_id = :categoria_id, estado = :estado WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);//bindParam() se usa para enlazar valores a parámetros de consulta, en este caso, los marcadores de posición :titulo, :autor_id, :categoria_id, :estado y :id
            $stmt->bindParam(':autor_id', $autorId);
            $stmt->bindParam(':categoria_id', $categoriaId);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al editar el libro: " . $e->getMessage());
        }
    }

    // Método para eliminar un libro
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM libros WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar el libro: " . $e->getMessage());
        }
    }

    // Método para obtener todos los libros
    public function obtenerTodos() {
        try {
            $sql = "SELECT libros.*, autores.nombre AS autor, categorias.nombre AS categoria
                    FROM libros
                    JOIN autores ON libros.autor_id = autores.id
                    JOIN categorias ON libros.categoria_id = categorias.id";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener libros: " . $e->getMessage());
        }
    }
    public function obtenerPorId($id) {
        try {
            $sql = "SELECT * FROM libros WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado : null; // Retorna los datos del libro o null si no se encuentra
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el libro: " . $e->getMessage());
        }
    }
    public function actualizarEstado($id, $estado) {
        try {
            $sql = "UPDATE libros SET estado = :estado WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar el estado del libro: " . $e->getMessage());
        }
    }
    public function obtenerDisponibles() {
        try {
            $sql = "SELECT * FROM libros WHERE estado = 'disponible'";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener libros disponibles: " . $e->getMessage());
        }
    }

    // Método para buscar libros por título, autor o categoría
    public function buscarLibros($titulo = null, $autor = null, $categoria = null) {
        $sql = "SELECT libros.*, autores.nombre AS autor, categorias.nombre AS categoria
                FROM libros
                JOIN autores ON libros.autor_id = autores.id
                JOIN categorias ON libros.categoria_id = categorias.id
                WHERE 1=1"; // Condición inicial para facilitar la adición de más filtros

        // Filtrar por título
        if ($titulo) {
            $sql .= " AND libros.titulo LIKE :titulo";
        }
        // Filtrar por autor
        if ($autor) {
            $sql .= " AND autores.nombre LIKE :autor";
        }
        // Filtrar por categoría
        if ($categoria) {
            $sql .= " AND categorias.nombre LIKE :categoria";
        }

        try {
            $stmt = $this->pdo->prepare($sql);

            // Vincular parámetros
            if ($titulo) {
                $stmt->bindValue(':titulo', "%$titulo%");
            }
            if ($autor) {
                $stmt->bindValue(':autor', "%$autor%");
            }
            if ($categoria) {
                $stmt->bindValue(':categoria', "%$categoria%");
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al buscar libros: " . $e->getMessage());
        }
    }
    
}

?>
