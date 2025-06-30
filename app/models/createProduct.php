<?php
header('Content-Type: application/json');
require __DIR__ . './../../config/bd.php'; // conexión

// Recoger datos del formulario
$nombre = $_POST['nombre_prod'] ?? '';
$proveedor = $_POST['proveedor'] ?? '';
$fabrica = $_POST['fabrica'] ?? '';
$cobertura = $_POST['cobertura'] ?? '';
$disponibilidad = $_POST['disponibilidad'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$precio = $_POST['precio'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$observacion = $_POST['observacion'] ?? '';
$estado = 1;
$img = ''; // Se actualizará luego

// Insertar producto
$stmt = $conn->prepare("INSERT INTO productos (
    nom_prod, doc_proov, fabrica_prod, coverVenta_prod,
    tipo_prod, precio_prod, img_prod, desc_prod,
    cat_prod, obser_prod, estado_prod
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssdssssi", $nombre, $proveedor, $fabrica, $cobertura, $tipo, $precio, $img, $descripcion, $categoria, $observacion, $estado);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error al crear producto: ' . $stmt->error]);
    exit;
}

$idProducto = $stmt->insert_id;
$stmt->close();

// Carpeta de medios
$carpeta = __DIR__ . '/../../public/uploads/medios/';
if (!is_dir($carpeta)) mkdir($carpeta, 0777, true);

$archivos = $_FILES['media'] ?? null;
$mediaGuardados = [];

if ($archivos && is_array($archivos['tmp_name'])) {
    foreach ($archivos['tmp_name'] as $i => $tmp) {
        $tipoArchivo = $archivos['type'][$i];
        $nombreArchivo = $archivos['name'][$i];

        // Validar tipo de archivo
        $permitidos = ['image/jpeg', 'image/png', 'image/webp', 'video/mp4', 'video/webm', 'video/ogg'];
        if (!in_array($tipoArchivo, $permitidos)) continue;

        // Generar nombre único y rutas
        $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $nuevoNombre = uniqid("media_", true) . "." . $ext;
        $rutaRelativa = "public/uploads/medios/" . $nuevoNombre;
        $rutaCompleta = $carpeta . $nuevoNombre;

        // Construir URL absoluta para guardar en la BD
        $host = $_SERVER['HTTP_HOST']; // localhost
        $base = str_replace('/app/models', '', dirname($_SERVER['SCRIPT_NAME'])); // /AMT
        $rutaURL = "http://$host$base/$rutaRelativa";

        if (move_uploaded_file($tmp, $rutaCompleta)) {
            $tipoMedio = str_starts_with($tipoArchivo, "image/") ? "imagen" : "video";

            // Guardar medio
            $stmtMedia = $conn->prepare("INSERT INTO medios (producto_id, ruta, tipo) VALUES (?, ?, ?)");
            $stmtMedia->bind_param("iss", $idProducto, $rutaURL, $tipoMedio);
            $stmtMedia->execute();
            $stmtMedia->close();

            $mediaGuardados[] = $rutaURL;
        }
    }

    // Si hay al menos una imagen, actualizar img_prod del producto
    if (count($mediaGuardados) > 0) {
        $stmtImg = $conn->prepare("UPDATE productos SET img_prod = ? WHERE id_prod = ?");
        $stmtImg->bind_param("si", $mediaGuardados[0], $idProducto);
        $stmtImg->execute();
        $stmtImg->close();
    }
}

$conn->close();

// Respuesta
echo json_encode([
    'success' => true,
    'message' => 'Producto creado con éxito',
    'media' => $mediaGuardados
]);
