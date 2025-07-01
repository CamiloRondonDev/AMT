<?php
header('Content-Type: application/json');
require __DIR__ . './../../config/bd.php';

// Obtener ID
$id_prod = $_GET['id'] ?? null;

if ($id_prod === null) {
    echo json_encode(['error' => 'ID del producto no proporcionado']);
    exit;
}

// Consulta principal (producto + proveedor)

   $sql = "SELECT 
    p.id_prod, p.nom_prod, p.desc_prod, p.cat_prod, p.tipo_prod, p.precio_prod,
    p.fabrica_prod, p.dispo_prod, p.coverVenta_prod, p.img_prod, p.estado_prod,
    p.doc_proov, p.obser_prod,
    u.id_usu, u.nom_usu, u.apell_usu, u.tipoDoc_usu, u.correo_usu, u.tel_usu,
    u.red_social, u.estado_usu, u.tipo_usu
    FROM productos p
    INNER JOIN usuarios u ON p.doc_proov = u.id_usu
    WHERE p.id_prod = ?";


$stmt = $conn->prepare($sql);
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("i", $id_prod);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Producto no encontrado']);
    exit;
}

$producto = $result->fetch_assoc();
$stmt->close();

// Nueva consulta: traer medios relacionados
$sqlMedios = "SELECT ruta, tipo FROM medios WHERE producto_id = ?";
$stmtMedios = $conn->prepare($sqlMedios);
$stmtMedios->bind_param("i", $id_prod);
$stmtMedios->execute();
$resMedios = $stmtMedios->get_result();

$medios = [];
while ($fila = $resMedios->fetch_assoc()) {
    $medios[] = $fila;
}
$stmtMedios->close();
$conn->close();

// Unir datos del producto y sus medios
$producto['medios'] = $medios;

echo json_encode($producto);
?>
