<?php
class ProductoModel {
    private $conn;

    public function __construct() {
        require __DIR__ . '/../../config/bd.php';
        $this->conn = $conn;
    }

    public function obtenerTodosLosProductos() {
        $sql = "SELECT * FROM productos";
        $result = $this->conn->query($sql);

        $productos = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        }

        $this->conn->close();

        return $productos;
    }
}
