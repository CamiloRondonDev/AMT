<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdamt";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

//echo "Conexión exitosa.<br>";

// Prueba con una consulta
// $sql = "SHOW TABLES"; // Lista las tablas en la base de datos
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     echo "Tablas en la base de datos:<br>";
//     while ($row = $result->fetch_array()) {
//         echo "- " . $row[0] . "<br>";
//     }
// } else {
//     echo "No hay tablas en la base de datos.";
// }


//$conn->close();
?>
