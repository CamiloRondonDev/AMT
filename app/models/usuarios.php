<?php
header('Content-Type: application/json');
require __DIR__ . './../../config/bd.php';

// Consulta para obtener todos los usuarios
$sql = "SELECT apell_usu, correo_usu, estado_usu, id_usu,logo_empresa, nom_usu, red_social,tel_usu,tipoDoc_usu,tipo_usu FROM usuarios";
$result = $conn->query($sql);

$usuarios = [];

while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

$conn->close();

// Retornar en formato JSON
echo json_encode($usuarios);
?>
