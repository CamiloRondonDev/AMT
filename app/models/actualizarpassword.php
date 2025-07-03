<?php
session_start();
header('Content-Type: application/json');
require __DIR__ . './../../config/bd.php';  // Esto te da $conn como mysqli

// Recoger datos
$id_usu = $_SESSION['id_usu'] ?? null;
$passActual = $_POST['currentPass'] ?? '';
$passNueva  = $_POST['newPass'] ?? '';

// Validaciones…
if (!$id_usu || !$passActual || !$passNueva) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos']);
    exit;
}

// 1) Verificar contraseña actual
$stmt = $conn->prepare("SELECT pass_usu FROM usuarios WHERE id_usu = ?");
$stmt->bind_param("i", $id_usu);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    exit;
}
$usuario = $res->fetch_assoc();
$stmt->close();

if (!password_verify($passActual, $usuario['pass_usu'])) {
    echo json_encode(['success' => false, 'message' => 'Contraseña actual incorrecta']);
    exit;
}

// 2) Hashear y actualizar
$hashNueva = password_hash($passNueva, PASSWORD_DEFAULT);
$stmt2 = $conn->prepare("UPDATE usuarios SET pass_usu = ? WHERE id_usu = ?");
$stmt2->bind_param("si", $hashNueva, $id_usu);
if ($stmt2->execute()) {
    echo json_encode(['success' => true, 'message' => 'Contraseña actualizada']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $stmt2->error]);
}
$stmt2->close();
$conn->close();
