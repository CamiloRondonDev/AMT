<?php
require __DIR__ . './../../config/bd.php'; // conexión a la base

$correo = 'camiloanla2@gmail.com';
$password_plain = 'camilo123*';

// Crear hash seguro
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

// Preparar consulta para insertar usuario
$stmt = $conn->prepare("INSERT INTO usuarios (correo_usu, pass_usu) VALUES (?, ?)");
$stmt->bind_param("ss", $correo, $password_hash);

if ($stmt->execute()) {
    echo "Usuario creado con contraseña hasheada.\n";
} else {
    echo "Error al crear usuario: " . $stmt->error . "\n";
}

$stmt->close();
$conn->close();
?>
