<?php
session_start();
header('Content-Type: application/json');
require __DIR__ . './../../config/bd.php';

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';
$id_usu = $_POST['id_usu'] ?? $_GET['id_usu'] ?? null;


if ($accion === "activate_edit") {
    $stmt = $conn->prepare("UPDATE productos SET estado_prod = 1 WHERE id_prod = ?");
    $stmt->bind_param("s", $id_usu);

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
    $stmt->bind_param("s", $id_usu);

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
}else {

    $sql = "SELECT * FROM
            productos p 
            inner join usuarios u on p.doc_proov = u.id_usu 
            and p.estado_prod = 1
            and u.estado_usu = 1
            ";
    $result = $conn->query($sql);

    $productos = [];

    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    echo json_encode($productos);
}


$conn->close();


