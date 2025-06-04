<?php
require_once '../app/models/obtenerProductos.php';

class HomeController {
    public function index() {
        $modelo = new ProductoModel();
        $productos = $modelo->obtenerTodosLosProductos();  // Aquí obtienes todos los productos

        // Ahora cargamos la vista y le pasamos $productos
        require_once '../app/views/home.php';
    }
}
?>
