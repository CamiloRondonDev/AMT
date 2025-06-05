<?php
require_once '../app/models/obtenerProductos.php';

class HomeController {
    public function index() {
        // Ahora cargamos la vista y le pasamos $productos
        require_once '../app/views/home.php';
    }
}
?>
