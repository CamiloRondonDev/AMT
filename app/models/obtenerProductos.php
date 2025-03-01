<?php
header('Content-Type: application/json');
require __DIR__ . './../../config/bd.php';


$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

$productos = [];

while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

$conn->close();

echo json_encode($productos);
?>
