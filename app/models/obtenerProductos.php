<?php
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
}else {

    $sql = "SELECT * FROM productos p inner join usuarios u on p.doc_proov = u.id_usu  ";
    $result = $conn->query($sql);

    $productos = [];

    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    echo json_encode($productos);
}


$conn->close();


