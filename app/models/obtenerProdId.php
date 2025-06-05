<?php
header('Content-Type: application/json');
require __DIR__ . './../../config/bd.php';

// Obtener el ID del producto desde la URL (por ejemplo, ?id=1)
 $id_prod =  $_GET['id']; // Obtenemos el id del producto desde la URL
 //$id_prod = 3;

// Si no se pasa un ID válido, devolvemos un error
if ($id_prod === null) {
    echo json_encode(['error' => 'ID del producto no proporcionado']);
    exit;
}

// Consulta SQL para obtener el producto con el ID específico
$sql = "SELECT * FROM productos WHERE id_prod = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_prod);  // "i" para integer
$stmt->execute();

$result = $stmt->get_result();

// Comprobamos si se encontró el producto
if ($result->num_rows > 0) {
    $producto = $result->fetch_assoc();
    echo json_encode($producto);
} else {
    echo json_encode(['error' => 'Producto no encontrado']);
}

$stmt->close();
$conn->close();
?>
