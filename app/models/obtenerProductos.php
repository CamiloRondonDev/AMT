<?php
session_start();
header('Content-Type: application/json');
require __DIR__ . './../../config/bd.php';

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';
$id_prod = $_POST['id_prod'] ?? $_GET['id_prod'] ?? null;


if ($accion === "activate_edit") {
    $stmt = $conn->prepare("UPDATE productos SET estado_prod = 1 WHERE id_prod = ?");
    $stmt->bind_param("s", $id_prod);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Producto Activado Correctamente.',
            'datos' => $accion 
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al activar el producto: ' . $stmt->error
        ]);
    }
}elseif($accion === "inactivate_edit") {
    $stmt = $conn->prepare("UPDATE productos SET estado_prod = 0 WHERE id_prod = ?");
    $stmt->bind_param("s", $id_prod);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Producto desactivado Correctamente.',
            'datos' => $accion 
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al desactivar el producto: ' . $stmt->error
        ]);
    }
}elseif($accion === "allProducts"){

    // Validar que haya sesión activa si no es una acción pública
    if (!isset($_SESSION['id_usu'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'No autenticado']);
        exit;
    }


    $rol = $_SESSION['rol'] ?? '';
    $idUsuario = $_SESSION['id_usu'] ?? 0;

    if ($rol === 'admin') {
        // Admin: trae todos los productos
        $sql = "SELECT   
        p.id_prod, p.nom_prod, p.desc_prod, p.cat_prod, p.tipo_prod, p.precio_prod,
        p.fabrica_prod, p.dispo_prod, p.coverVenta_prod, p.img_prod, p.estado_prod,
        p.doc_proov, p.obser_prod,
        u.id_usu, u.nom_usu, u.apell_usu, u.tipoDoc_usu, u.correo_usu, u.tel_usu,
        u.red_social, u.estado_usu, u.tipo_usu
     FROM productos p 
                INNER JOIN usuarios u ON p.doc_proov = u.id_usu";
        $stmt = $conn->prepare($sql);
    } else {
        // Usuario normal: solo los suyos
        $sql = "SELECT 
            p.id_prod, p.nom_prod, p.desc_prod, p.cat_prod, p.tipo_prod, p.precio_prod,
            p.fabrica_prod, p.dispo_prod, p.coverVenta_prod, p.img_prod, p.estado_prod,
            p.doc_proov, p.obser_prod,
            u.id_usu, u.nom_usu, u.apell_usu, u.tipoDoc_usu, u.correo_usu, u.tel_usu,
            u.red_social, u.estado_usu, u.tipo_usu
        FROM productos p 
                INNER JOIN usuarios u ON p.doc_proov = u.id_usu 
                WHERE u.id_usu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    echo json_encode($productos);

}elseif($accion === 'getById' ){

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
    if (!$stmt) {
        echo json_encode(['error' => 'Error al preparar la consulta: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("i", $id_prod);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['error' => 'Producto no encontrado']);
        $stmt->close();
        $conn->close(); // <- solo aquí está bien
        exit;
    }

    $producto = $result->fetch_assoc();
    $stmt->close(); // Cerrar statement principal

    // Consulta para medios del producto
    $sqlMedios = "SELECT ruta, tipo , id FROM medios WHERE producto_id = ?";
    $stmtMedios = $conn->prepare($sqlMedios);
    if (!$stmtMedios) {
        echo json_encode(['error' => 'Error al preparar medios: ' . $conn->error]);
        $conn->close(); // <- cerrar si hay error
        exit;
    }

    $stmtMedios->bind_param("i", $id_prod);
    $stmtMedios->execute();
    $resMedios = $stmtMedios->get_result();

    $medios = [];
    while ($fila = $resMedios->fetch_assoc()) {
        $medios[] = $fila;
    }
    $stmtMedios->close();

    $producto['medios'] = $medios;

    // ✅ Evita los \u y los \/ en el JSON
    echo json_encode($producto, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $conn->close(); // 🔒 cerrar conexión SOLO al final

} elseif ($accion === 'updateProduct') {
    $id = $_POST['id_prod'] ?? null;
    $nombre = $_POST['nombre_prod'] ?? '';
    $fabrica = $_POST['fabrica'] ?? '';
    $cobertura = $_POST['cobertura'] ?? '';
    $dispo = $_POST['disponibilidad'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $descripcion = $_POST['descripcion'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $proveedor = $_POST['proveedor'] ?? '';
    $observacion = $_POST['observacion'] ?? '';

    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ID no válido']);
        exit;
    }

    // 1) Actualizar datos del producto
    $sql = "UPDATE productos SET 
        nom_prod = ?, fabrica_prod = ?, coverVenta_prod = ?, dispo_prod = ?, 
        tipo_prod = ?, precio_prod = ?, desc_prod = ?, cat_prod = ?, 
        doc_proov = ?, obser_prod = ?
        WHERE id_prod = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssdsssii", 
        $nombre, $fabrica, $cobertura, $dispo,
        $tipo, $precio, $descripcion, $categoria,
        $proveedor, $observacion, $id);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $stmt->error]);
        exit;
    }
    $stmt->close();

    // 2) Subir nuevos archivos si se cargaron
    $mediaGuardadas = [];
    if (!empty($_FILES['media']['name'][0])) {
        $uploadDir = __DIR__ . '/../../public/uploads/medios/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        foreach ($_FILES['media']['tmp_name'] as $i => $tmpName) {
            $ext = pathinfo($_FILES['media']['name'][$i], PATHINFO_EXTENSION);
            $nuevoNombre = 'media_' . uniqid() . '.' . $ext;
            $rutaCompleta = $uploadDir . $nuevoNombre;
            $url = "http://localhost/amt/public/uploads/medios/" . $nuevoNombre;

            if (move_uploaded_file($tmpName, $rutaCompleta)) {
                $tipoArchivo = explode("/", $_FILES['media']['type'][$i])[0] === 'video' ? 'video' : 'imagen';
                $stmtM = $conn->prepare("INSERT INTO medios (producto_id, ruta, tipo) VALUES (?, ?, ?)");
                $stmtM->bind_param("iss", $id, $url, $tipoArchivo);
                $stmtM->execute();
                $stmtM->close();
                $mediaGuardadas[] = $url;
            }
        }
    }

    // 3) Actualizar img_prod:
    //    a) Si subimos nuevas imágenes, usamos la primera de $mediaGuardadas
    //    b) Si no, buscamos la primera imagen existente en medios
    if (count($mediaGuardadas) > 0) {
        $imgPortada = $mediaGuardadas[0];
    } else {
        // traer primera ruta de medios existentes
        $stmtF = $conn->prepare("SELECT ruta FROM medios WHERE producto_id = ? ORDER BY id LIMIT 1");
        $stmtF->bind_param("i", $id);
        $stmtF->execute();
        $resF = $stmtF->get_result();
        $filaF = $resF->fetch_assoc();
        $stmtF->close();
        $imgPortada = $filaF['ruta'] ?? '';
    }

    if ($imgPortada) {
        $stmtU = $conn->prepare("UPDATE productos SET img_prod = ? WHERE id_prod = ?");
        $stmtU->bind_param("si", $imgPortada, $id);
        $stmtU->execute();
        $stmtU->close();
    }

    // 4) Respuesta
    echo json_encode([
        'success' => true,
        'message' => 'Producto actualizado con éxito',
        'nuevosMedios' => $mediaGuardadas
    ]);
    exit;
} elseif ($accion === 'deleteMedia') {
    $id_media = $_POST['id_media'] ?? null;
    if (!$id_media) {
        echo json_encode(['success' => false, 'message' => 'ID de media no proporcionado']);
        exit;
    }

    // 1) Obtener ruta y producto_id del medio
    $stmt = $conn->prepare("SELECT ruta, producto_id FROM medios WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error al preparar select ruta: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $id_media);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Media no encontrada']);
        $stmt->close();
        exit;
    }
    $fila = $res->fetch_assoc();
    $ruta  = $fila['ruta'];
    $prodId = $fila['producto_id'];
    $stmt->close();

    // 2) Eliminar registro de medios
    $stmtDel = $conn->prepare("DELETE FROM medios WHERE id = ?");
    if (!$stmtDel) {
        echo json_encode(['success' => false, 'message' => 'Error al preparar delete medios: ' . $conn->error]);
        exit;
    }
    $stmtDel->bind_param("i", $id_media);
    if (!$stmtDel->execute()) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar de BD: ' . $stmtDel->error]);
        $stmtDel->close();
        exit;
    }
    $stmtDel->close();

    // 3) Eliminar archivo físico
    $publicPath = '/AMT/public/uploads/medios/';
    $docRoot    = $_SERVER['DOCUMENT_ROOT'];
    $filePath   = str_replace($publicPath, $docRoot . $publicPath, $ruta);
    if (file_exists($filePath)) {
        @unlink($filePath);
    }

    // 4) Verificar si era la portada
    $stmtProd = $conn->prepare("SELECT img_prod FROM productos WHERE id_prod = ?");
    $stmtProd->bind_param("i", $prodId);
    $stmtProd->execute();
    $resProd = $stmtProd->get_result();
    $prod    = $resProd->fetch_assoc();
    $stmtProd->close();

    if (isset($prod['img_prod']) && $prod['img_prod'] === $ruta) {
        // Buscar otra imagen en medios
        $stmtNext = $conn->prepare("SELECT ruta FROM medios WHERE producto_id = ? ORDER BY id LIMIT 1");
        $stmtNext->bind_param("i", $prodId);
        $stmtNext->execute();
        $resNext = $stmtNext->get_result();
        $nuevaPortada = '';
        if ($rowNext = $resNext->fetch_assoc()) {
            $nuevaPortada = $rowNext['ruta'];
        }
        $stmtNext->close();

        // Actualizar img_prod (puede ser cadena vacía si no hay más)
        $stmtUp = $conn->prepare("UPDATE productos SET img_prod = ? WHERE id_prod = ?");
        $stmtUp->bind_param("si", $nuevaPortada, $prodId);
        $stmtUp->execute();
        $stmtUp->close();
    }

    echo json_encode(['success' => true, 'message' => 'Imagen eliminada y portada actualizada']);
    exit;
}else {
    // Parámetros de paginación
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $productosPorPagina = 20;
    $inicio = ($pagina - 1) * $productosPorPagina;

    // Contar total de productos activos
    $sqlTotal = "SELECT COUNT(*) AS total FROM productos p 
                 INNER JOIN usuarios u ON p.doc_proov = u.id_usu 
                 WHERE p.estado_prod = 1 AND u.estado_usu = 1";
    $totalResult = $conn->query($sqlTotal);
    $total = $totalResult->fetch_assoc()['total'];
    $totalPaginas = ceil($total / $productosPorPagina);

    // Obtener productos de la página actual
    $sql = "SELECT * FROM productos p 
            INNER JOIN usuarios u ON p.doc_proov = u.id_usu 
            WHERE p.estado_prod = 1 AND u.estado_usu = 1
            LIMIT ?, ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $inicio, $productosPorPagina);
    $stmt->execute();
    $result = $stmt->get_result();

    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    echo json_encode([
        "productos" => $productos,
        "totalPaginas" => $totalPaginas
    ]);
}



