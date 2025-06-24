<?php
header('Content-Type: application/json');
require __DIR__ . './../../config/bd.php'; // conexión a la base

    // Recoger y validar campos...
$nombre = $_POST['nom_usu'] ?? '';
$apellido = $_POST['apell_usus'] ?? '';
$tipoDoc = $_POST['tipoDoc_usu'] ?? '';
$id_usu = $_POST['id_usu'] ?? '';
$correo = $_POST['correo_usu'] ?? '';
$telefono = $_POST['tel_usu'] ?? '';
$password_plain = $_POST['pass_usu'] ?? '';
$tipo = $_POST['tipo_usu'] ?? '';
$red_social = $_POST['red_social'] ?? '';
$estado = 0;

// Crear hash seguro
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuarios (id_usu, nom_usu, apell_usu, tipoDoc_usu, correo_usu, tel_usu, pass_usu, tipo_usu, red_social, estado_usu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssi", $id_usu, $nombre, $apellido, $tipoDoc, $correo, $telefono, $password_hash, $tipo,$red_social, $estado);

if ($stmt->execute()) {
    echo json_encode([
  'success' => true,
  'message' => 'Usuario creado con contraseña hasheada.'
]);

} else {
    echo json_encode([
  'success' => false,
  'message' => 'Error al crear usuario: ' . $stmt->error
]);
}

$stmt->close();
$conn->close();
?>
