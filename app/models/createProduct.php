<?php
header('Content-Type: application/json');
require __DIR__ . './../../config/bd.php'; // conexión a la base

// Recoger y validar campos...
$nombre = $_POST['nombre_prod'] ?? '';
$proveedor = $_POST['proveedor'] ?? '';
$fabrica = $_POST['fabrica'] ?? '';
$cobertura = $_POST['cobertura'] ?? '';
$disponibilidad = $_POST['disponibilidad'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$precio = $_POST['precio'] ?? '';
$img = $_POST['img'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$observacion = $_POST['observacion'] ?? '';
$estado = 1;

$stmt = $conn->prepare("INSERT INTO productos (nom_prod, doc_proov, fabrica_prod, coverVenta_prod, tipo_prod, precio_prod, img_prod, desc_prod,cat_prod,obser_prod,estado_prod) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssi", $nombre, $proveedor, $fabrica, $cobertura, $tipo,$precio, $img, $descripcion, $categoria, $observacion,$estado);

if ($stmt->execute()) {
    echo json_encode([
  'success' => true,
  'message' => 'Prodcuto creado exitosamente.'
]);

} else {
    echo json_encode([
  'success' => false,
  'message' => 'Error al crear producto: ' . $stmt->error
]);
}

$stmt->close();
$conn->close();
?>
