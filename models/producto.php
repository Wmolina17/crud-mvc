<?php
require_once __DIR__ . '/../config/database.php';

class Producto {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getConnection();
    }
    
    public function obtenerTodos() {
        $query = "SELECT * FROM productos ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function obtenerPorId($id) {
        $query = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function crear($nombre, $precio, $descripcion) {
        $query = "INSERT INTO productos (nombre, precio, descripcion) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nombre, $precio, $descripcion]);
    }
    
    public function actualizar($id, $nombre, $precio, $descripcion) {
        $query = "UPDATE productos SET nombre = ?, precio = ?, descripcion = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nombre, $precio, $descripcion, $id]);
    }
    
    public function eliminar($id) {
        $query = "DELETE FROM productos WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>