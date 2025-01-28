<?php
class Prestamo
{
    private $pdo; // Conexión a la base de datos

    public function __construct($dbConnection) {
        $this->pdo = $dbConnection;
    }
    
    public function registrarPrestamo($libroId, $fechaPrestamo, $fechaDevolucion)
    {
        try {
            $sql = "INSERT INTO prestamos (libro_id, fecha_prestamo, fecha_devolucion, estado) 
                    VALUES (:libro_id, :fecha_prestamo, :fecha_devolucion, 'activo')";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':libro_id', $libroId);
            $stmt->bindParam(':fecha_prestamo', $fechaPrestamo);
            $stmt->bindParam(':fecha_devolucion', $fechaDevolucion);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al registrar el préstamo: " . $e->getMessage());
        }
    }
}
