<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'biblioteca';
    private $username = 'root';
    private $password = '';
    private static $instance = null;

    private function __construct() {}

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    "mysql:host=localhost;dbname=biblioteca;charset=utf8", 
                    'root', 
                    ''
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>
