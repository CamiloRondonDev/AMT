<?php
session_start();
header('Content-Type: application/json');

require __DIR__ . './../../config/bd.php'; // Asegúrate de que la ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['username'] ?? '');
    $contrasena = trim($_POST['password'] ?? '');

    if (empty($correo) || empty($contrasena)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
        exit;
    }

    // Consulta segura a la base de datos
    $stmt = $conn->prepare("SELECT id_usu, pass_usu FROM usuarios WHERE correo_usu = ?");
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta."]);
        exit;
    }

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar contraseña usando hash
        if (password_verify($contrasena, $usuario['pass_usu'])) {
            $_SESSION['id_usu'] = $usuario['id_usu'];

            echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso."]);
        } else {
            echo json_encode(["success" => false, "message" => "Contraseña incorrecta."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Usuario no encontrado."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Solo se permite el método POST.']);
}
